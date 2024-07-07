<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AssignCustomer;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageShopController extends Controller
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
            $data['shop'] = AssignCustomer::with(['assignVendor', 'assignCustomer', 'assignVendor.productPrice' => function ($query) {
                $query->select('id', 'price', 'vendor_id', 'product_id', 'variant_id');
            }, 'assignVendor.productPrice.product' => function ($query) {
                $query->select('id', 'name');
            }, 'assignVendor.productPrice.variant' => function ($query) {
                $query->select('id', 'name', 'variant_code');
            }])->whereHas('assignCustomer', function ($query) use ($authUser) {
                $query->where('id', $authUser->customer_id);
            })->get();
            return response()->json(['status' => 'Success', 'message' => $data], 200);
        } else {
            $data['shop'] = Vendor::with(['vendorAssign.assignCustomer','productPrice.product'=>function($query){
                $query->where('status','1')->select('id','name','description')->get();
            },'productPrice.variant'=>function($query){
                $query->where('status','1')->select('id','name','variant_code')->get();
            }])->where('id',$authUser->vendor_id)->first();
            return response()->json(['status' => 'Success', 'message' => $data], 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
