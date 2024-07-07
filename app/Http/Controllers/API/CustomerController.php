<?php

namespace App\Http\Controllers\API;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\AssignCustomer;
use App\Models\Customer;
use App\Models\User;
use App\Models\Vendor;
use Exception;
use Illuminate\Http\Client\ResponseSequence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
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
        $data['customer'] = null;
        if (auth()->user()->role == 'User') {
            $data['customer'] = Customer::where('id', auth()->user()->customer_id)->first();
        } elseif (auth()->user()->role == 'Vendor') {
            $vendor_id = auth()->user()->vendor->id;
            $data['customer'] = DB::table('customers')
                ->join('assigncustomers', 'customers.id', 'assigncustomers.customer_id')
                ->where('assigncustomers.vendor_id', $vendor_id)
                ->select(['customers.*'])
                ->get();
        } else {
            $data['customer'] = Customer::all();
        }
        return response()->json(['status' => 'Success', 'message' => $data], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer = '';
        if (auth()->user()->role == 'User') {
            $validate = Validator::make($request->all(), [
                'name' => 'nullable|string',
                'address' => 'nullable|string',
                'email' => 'nullable|email|unique:users,email,' . auth()->user()->id . ',id',
            ]);
            if ($validate->fails()) {
                return response()->json(['status' => 'Error', 'message' => $validate->errors()], 422);
            }
            $token = Helper::SeperateBearer($request->header('authorization'));
            $authUser = User::where('token', $token)->first();
            $authUser->update($request->all());
            DB::table('customers')->where('id', $authUser->customer_id)->update($request->all());
            $customer = Auth::user();
        } else {
            $validator = Validator::make(
                $request->all(),
                [
                    'phone_number' => 'required|digits:10|unique:customers,phone_number',
                ]
            );
            if ($validator->fails()) {
                return response()->json(['status' => 'Error', 'message' => $validator->errors()], 422);
            } else {
                try {
                    DB::beginTransaction();
                    $customer = Customer::create([
                        'phone_number' => $request->phone_number,
                    ]);

                    $vendor = Vendor::where('contact', auth()->user()->phone_number)->first();

                    $assignCustomer = AssignCustomer::create([
                        'vendor_id' => $vendor->id,
                        'customer_id' => $customer->id,
                    ]);
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollBack();
                    return response()->json(['status' => 'Error', 'message' => 'Internal Issue'], 501);
                }
            }
        }
        return response()->json(['status' => 'Success', 'message' => $customer], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['customer'] = Customer::findOrFail($id);
        if ($data['customer']) {
            return response()->json(['status' => 'Success', 'message' => $data], 200);
        } else {
            return response()->json(['status' => 'Failed to find the customer.'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        if (auth()->user()->role == 'User') {
            $customer = Customer::findOrFail($id);
            $validator = Validator::make(
                $request->all(),
                [
                    // 'phone_number' => 'required|digits:10|unique:customers,phone_number,except,' . $customer->id,
                    'name' => 'nullable|max:255|string|regex:/^[a-zA-Z\s]+$/',
                    'address' => 'nullable|max:255|string',
                    'email' => 'nullable|email|unique:customers,email,' . $customer->id,
                ]
            );
            if ($validator->fails()) {
                return response()->json(['status' => 'Error', 'message' => 'Validation Fails'], 400);
            } else {
                try {
                    DB::beginTransaction();
                    $customer->update($request->all());
                    $data['customer'] = $customer;
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollBack();
                    return response()->json(['status' => 'Error', 'message' => 'Failed to update the customer.'], 501);
                }
                return response()->json(['status' => 'Success', 'message' => $data], 200);
            }
        } else {
            abort(403);
        }
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
