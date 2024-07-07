<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['products'] = Product::withTrashed()->get();
        return view('products.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:products,name',
            'description' => 'nullable|min:5',
        ]);
        if ($validator->fails()) {
            Session::flash('error', 'Validation Fails');
            return back()->withInput($request->all());
        } else {
            try {
                DB::beginTransaction();
                Product::create($request->all());
                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                Session::flash('error', 'Failed to store the new product');
                return back()->withInput($request->all());
            }
            Session::flash('success', 'A new product has been added successfully');
            return redirect(route('products.index'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $data['product'] = $product;
        return view('products.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:products,name,' . $product->id .',id',
            'description' => 'nullable|min:5'
        ]);

        if ($validator->fails()) {
            Session::flash('warning', 'Validation Fails');
            return back()->withInput($request->all());
        }

        try {
            DB::beginTransaction();
            $product->update($request->all());
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Session::flash('error','Failed to update '.$product->name);
            return back()->withInput($request->all());
        }
        Session::flash('success',$product->name . ' has been updated successfully');
        return redirect(route('products.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $destroy = Product::destroy($product->id);
        if($destroy){
            Session::flash('success',$product->name . ' has been deleted successfully');
        }else{
            Session::flash('error','Failed to delete '.$product->name);
        }
        return back();
    }

    public function restore($id){
        $restore = Product::withTrashed()->findOrFail($id);
        $restore->restore();
        Session::flash('success','Product has been restored successfully');
        return back();
    }
}
