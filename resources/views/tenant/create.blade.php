@extends('layouts.app')

@section('app-content')
    <aside>
        <div class="layout-tenant container">
            <div class="tenant-wrapper ">
                <div class="tenant-section">
                    <div class="tenant-heading d-flex justify-content-center p-5 text-uppercase">
                        <h3>Add new Tenant</h3>
                    </div>
                    <div class="tenant-body d-flex justify-content-center">
                        <div class="form-wrapper col-6">
                            <form action="{{ route('tenant.store') }}" method="post" class="" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <label for="id" class="col-2">ID: </label>
                                    <div class="col-10">
                                        <input type="text" name="id" id="id" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="name" class="col-2">Name: </label>
                                    <div class="col-10">
                                        <input type="text" name="name" id="name" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="phone_number" class="col-2">Contact: </label>
                                    <div class="col-10">
                                        <input type="text" name="phone_number" id="phone_number" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="email" class="col-2">Email: </label>
                                    <div class="col-10">
                                        <input type="text" name="email" id="email" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="password" class="col-2">Password: </label>
                                    <div class="col-10">
                                        <input type="text" name="password" id="password" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="logo" class="col-2">Logo: </label>
                                    <div class="col-10">
                                        <input type="file" name="logo" id="logo" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-2"></div>
                                    <div class="col-10 d-flex justify-content-center">
                                        <button class="btn btn-outline-primary col-2">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>
    <style>
        label{
            display: flex;
            justify-content: end;
        }
    </style>
@endsection
