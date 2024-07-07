<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\AssignCustomer;
use App\Models\CashTransaction;
use App\Models\CreditTransaction;
use App\Models\CustomerCredit;
use App\Models\Vendor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CustomerCreditController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authUser = Auth::user();
        if ($authUser->role == 'User') {
            $data['credits'] = AssignCustomer::with(['assignVendor', 'creditAmount'])->where('customer_id', $authUser->customer_id)->get();
        } else {
            $data['credits'] = AssignCustomer::with(['creditAmount', 'assignCustomer'])->where('vendor_id', $authUser->vendor_id)->get();
        }
        return response()->json(['status' => 'Success', 'message' => $data], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->role == 'Vendor') {
            $validator = Validator::make($request->all(), [
                'customer_id' => 'required|numeric',
                'payment_type' => 'required|string|in:cash,credit',
                'bill.*.product_price_id' => 'required|numeric',
                'bill.*.quantity' => 'required|numeric',
                'bill.*.total_amount' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => 'Error', 'message' => $validator->errors()], 422);
            }

            $authUser = Auth::user();
            $assignCustomer = AssignCustomer::where('customer_id', $request->customer_id)->where('vendor_id', $authUser->vendor_id)->select('id')->first();
            $payment_type = $request->payment_type;

            // Bill will have a array of the products price id, quantity and total_price
            $bills = $request->bill;
            $bulkActivity = [];
            $total_credit_amount = 0;
            foreach ($bills as $item) {
                $bulkActivity[] = [
                    'payment_type' => $payment_type,
                    'product_price_id' => $item['product_price_id'],
                    'quantity' => $item['quantity'],
                    'total_amount' => $item['total_amount'],
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                $total_credit_amount += $item['total_amount'];
            }
            try {
                DB::beginTransaction();
                if ($payment_type == 'credit') {
                    $userExist = CustomerCredit::where('assign_customer_id', $assignCustomer->id)->first();
                    if ($userExist == null) {
                        $data['credit'] = CustomerCredit::create([
                            'assign_customer_id' => $assignCustomer->id,
                            'credit_amount' => $total_credit_amount,
                        ]);
                    } else {
                        $userExist->update(['credit_amount' => $userExist->credit_amount + $total_credit_amount]);
                        $data['credit'] = $userExist;
                    }
                    $creditTransaction = CreditTransaction::create([
                        'assign_customer_id' => $assignCustomer->id,
                        'total_credit' => $total_credit_amount,
                    ]);
                    foreach ($bulkActivity as &$activity) {
                        $activity['credit_transaction_id'] = $creditTransaction->id;
                    }
                    Activity::insert($bulkActivity);
                } else {
                    $cashTransaction = CashTransaction::create(['vendor_id' => $authUser->vendor_id, 'amount' => $total_credit_amount]);
                    $data['credit'] = 'Transaction has been successfully made on cash.';
                    foreach ($bulkActivity as &$activity) {
                        $activity['cash_transaction_id'] = $cashTransaction->id;
                    }
                    Activity::itnser($bulkActivity);
                }
                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                Log::error($e);
                return response()->json(['status' => 'Error', 'message' => 'Internal server error.'], 500);
            }
            return response()->json(['status' => 'Success', 'message' => $data], 200);
        } else {
            abort(403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
