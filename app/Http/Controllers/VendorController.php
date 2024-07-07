<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['vendors'] = Vendor::withTrashed()->get();
        return view('vendor.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vendor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $this->validate($request, [
            'name' => 'required|max:64|regex:^[A-Za-z]+$^',
            'firm_name' => 'required|max:255',
            'address' => 'required',
            'email' => 'nullable|email',
            'contact' => 'required|unique:vendors,contact',
            'pan_vat' => 'nullable|unique:vendors,pan_vat',
        ]);
        try {
            DB::beginTransaction();
            $vendor = Vendor::create([
                'name' => $request->name,
                'firm_name' => $request->firm_name,
                'contact' => $request->contact,
                'address' => $request->address,
                'pan_vat' => $request->pan_vat,
                'email' => $request->email,
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Session::flash('error', 'Failed to create the Vendor');
            return back()->withInput($validate);
        }
        Session::flash('success', $vendor->name . ' has been added successfully');
        return redirect(route('vendors.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $vendor)
    {
        $data['vendor'] = $vendor;
        return view('vendor.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit(Vendor $vendor)
    {
        $data['vendor'] = $vendor;
        return view('vendor.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vendor $vendor)
    {
        $validate = $this->validate($request, [
            'name' => 'required|max:64|regex:^[A-Za-z]+$^',
            'firm_name' => 'required|max:255',
            'address' => 'required',
            'email' => 'nullable|email|unique:vendors,email,' . $vendor->id . ',id',
            'contact' => [
                'required',
                Rule::unique('vendors', 'contact')->ignore($vendor->id),
            ],
            'pan_vat' => [
                'nullable',
                Rule::unique('vendors', 'pan_vat')->ignore($vendor->id),
            ],
        ]);

        try {
            DB::beginTransaction();

            $vendor->update($validate);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Session::flash('error', 'Failed to update ' . $vendor->firm_name);
            return back()->withInput($request->all());
        }
        Session::flash('success', $vendor->firm_name . ' has been updated');
        return redirect(route('vendors.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor $vendor)
    {
        $destroy = Vendor::destroy($vendor->id);
        if ($destroy) {
            Session::flash('success', $vendor->name . ' has been deleted successfully');
        } else {
            Session::flash('error', 'Failed to delete ' . $vendor->name);
        }
        return back();
    }

    public function restore($id){
        $vendor = Vendor::withTrashed()->findOrFail($id);
        $vendor->restore();
        return back();
    }
}
