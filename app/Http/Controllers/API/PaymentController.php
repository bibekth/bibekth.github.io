<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AssignCustomer;
use App\Models\CustomerCredit;
use App\Models\Payment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
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

        if ($authUser->role == 'Vendor') {
            $data['payments'] = AssignCustomer::with(['payment'])->where('vendor_id', $authUser->vendor_id)->get();
        } else {
            $data['payments'] = AssignCustomer::with(['payment'])->where('customer_id', $authUser->customer_id)->get();
        }

        if (!$data['payments']) {
            return response()->json(['status' => 'Error', 'message' => 'Internal server error.'], 500);
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
        $authUser = Auth::user();

        if ($authUser->role == 'User') {
            return response()->json(['status' => 'Error', 'message' => 'Forbidden.'], 403);
        }

        $validation = Validator::make($request->all(), [
            'customer_id' => 'required|numeric',
            'amount' => 'required|numeric',
        ]);

        if ($validation->fails()) {
            return response()->json(['status' => 'Error', 'message' => $validation->errors()], 422);
        }

        $assignCustomer = AssignCustomer::where('customer_id', $request->customer_id)->where('vendor_id', $authUser->vendor_id)->first();
        $creditAmount = CustomerCredit::where('assign_customer_id', $authUser->customer_id)->first();

        try {
            DB::beginTransaction();
            if ($creditAmount) {
                $data['payment'] = Payment::create([
                    'assign_customer' => $assignCustomer->id,
                    'amount' => $request->amount,
                ]);
            } else {
                return response()->json(['status' => 'Error', 'message' => 'This customer has no credit amount.'], 422);
            }

            if ($data['payment']) {
                $creditAmount->update([
                    'credit_amount' => $creditAmount->credit_amount - $request->amount,
                ]);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'Error', 'message' => 'Internal server error.'], 500);
        }

        return response()->json(['status' => 'Success', 'message' => $data], 200);
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
