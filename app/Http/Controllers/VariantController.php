<?php

namespace App\Http\Controllers;

use App\Models\Variant;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class VariantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['variants'] = Variant::withTrashed()->get();
        return view('variants.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('variants.create');
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
            'name' => 'required|max:255|unique:variants,name',
            'variant_code'=>'required|unique:variants,variant_code',
            'description' => 'nullable|min:5',
        ]);
        if ($validator->fails()) {
            Session::flash('error', 'Validation Fails');
            return back()->withInput($request->all());
        } else {
            try {
                DB::beginTransaction();
                Variant::create($request->all());
                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                Session::flash('error', 'Failed to store the new variant');
                return back()->withInput($request->all());
            }
            Session::flash('success', 'A new variant has been added successfully');
            return redirect(route('variants.index'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Variant  $variant
     * @return \Illuminate\Http\Response
     */
    public function show(Variant $variant)
    {
        $data['variant'] = $variant;
        return view('variants.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Variant  $variant
     * @return \Illuminate\Http\Response
     */
    public function edit(Variant $variant)
    {
        $data['variant'] = $variant;
        return view('variants.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Variant  $variant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Variant $variant)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:variants,name,'.$variant->id.',id',
            'variant_code'=>'required|unique:variants,variant_code,'.$variant->id.',id',
            'description' => 'nullable|min:5',
        ]);
        if ($validator->fails()) {
            Session::flash('error', 'Validation Fails');
            return back()->withInput($request->all());
        } else {
            try {
                DB::beginTransaction();
                $variant->update($request->all());
                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                Session::flash('error', 'Failed to store the new variant');
                return back()->withInput($request->all());
            }
            Session::flash('success', 'A new variant has been added successfully');
            return redirect(route('variants.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Variant  $variant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Variant $variant)
    {
        $destroy = Variant::destroy($variant->id);
        Session::flash('success','Variant has been deactivated successfully');
        return back();
    }

    public function restore($id){
        $restore = Variant::withTrashed()->findOrFail($id);
        $restore->restore();
        Session::flash('success','Variant has been restored successfully');
        return back();
    }
}
