<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProductPrice;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductPriceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','vendor']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $data['productPrices'] = ProductPrice::where('vendor_id', $user->vendor->id)->where('status', '1')->get();
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
        $productPrice = ProductPrice::findOrFail($id);
        $validate = Validator::make($request->all(), [
            'price' => 'required|numeric',
        ]);
        if ($validate->fails()) {
            return response()->json(['status' => 'Error', 'message' => $validate->errors()], 422);
        }
        try {
            $productPrice->update($request->all());
            return response()->json(['status' => 'Success', 'message' => $productPrice], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'Error', 'message' => 'Internal server error.'], 500);
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

    public function setProductPrice(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'product_id' => 'required|numeric',
            'variant_id' => 'required|numeric',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
        ]);
        if ($validate->fails()) {
            return response()->json(['status' => 'Error', 'message' => $validate->errors()], 422);
        }
        $user = Auth::user();
        $existedPrice = ProductPrice::where('vendor_id', $user->vendor->id)->where('product_id', $request->product_id)
            ->where('variant_id', $request->variant_id)->where('quantity', $request->quantity)
            ->first();

        if ($existedPrice) {
            return response()->json(['status' => 'Error', 'message' => 'This product price is already existed.'], 409);
        }
        try {
            $productPrice = ProductPrice::create([
                'vendor_id' => $user->vendor->id,
                'product_id' => $request->product_id,
                'variant_id' => $request->variant_id,
                'quantity' => $request->quantity,
                'price' => $request->price,
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => 'Error', 'message' => 'Unable to create a this'], 500);
        }
        return response()->json(['status' => 'Success', 'message' => $productPrice], 200);
    }
}
