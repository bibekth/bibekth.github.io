<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Stancl\Tenancy\Database\Models\Domain;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['tenants'] = Tenant::withTrashed()->get();
        $data['domains'] = Domain::withTrashed()->get();
        return view('tenant.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tenant.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'id' => 'required|unique:tenants,id',
            'name' => 'required',
            'email' => 'required',
            'password' => 'nullable',
            'logo' => 'nullable',
        ]);
        if ($validate->fails()) {
            return back()->with('Error', 'Validation Fails')->withInput($request->all());
        }
        try {
            $store_name = null;
            if ($request->logo != null) {
                $image = File::get($request->logo);
                $image_name = time() . '_' . $request->logo->getClientOriginalName();
                $store = Storage::disk('public')->put("/images/company/$request->id/logo/$image_name", $image);
                $store_name = "company/$request->id/logo/$image_name";
            }
            $email = $request->email;
            $password = $request->password;
            $name = $request->name;
            $id = $request->id;
            DB::beginTransaction();
            $tenant = Tenant::create([
                'id' => $id,
                'email' => $email,
                'name' => $name,
                'password' => $password,
                'tenant_logo' => $store_name,
            ]);

            if ($tenant) {
                $tenant->domains()->create([
                    'domain' => $tenant->id,
                    'tenant_id' => $tenant->id,
                ]);
            }

            tenancy()->initialize($tenant->id);
            $users = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone_number' => $request->phone_number,
                'role' => 'Admin',
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withInput($request->all());
        }
        return redirect(route('tenant.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function show(Tenant $tenant)
    {
        $data['tenant'] = $tenant;
        return view('tenant.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function edit(Tenant $tenant)
    {
        return abort(403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tenant $tenant)
    {
        return abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tenant $tenant)
    {
        $destroy = Tenant::destroy($tenant->id);
        if ($destroy) {
            $domain = Domain::where('tenant_id', $tenant->id)->first();
            Domain::destroy($domain->id);
        }
        return back();
    }

    public function restore($id)
    {

        $tenant = Tenant::withTrashed()->where('id', $id)->first();
        $domain = Domain::withTrashed()->where('tenant_id',$tenant->id)->first();
        $tenant->restore();
        $domain->restore();
        return redirect(route('tenant.index'));
    }
}
