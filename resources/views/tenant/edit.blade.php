@extends('layouts.app')

@section('app-content')
    <aside>
        <div class="layout-tenant container">
            <div class="tenant-wrapper ">
                <div class="tenant-section">
                    <div class="tenant-heading d-flex justify-content-center p-5 text-uppercase">
                        <h3>Edit the Tenant, <strong>{{ $tenant->name }}</strong></h3>
                    </div>
                    <div class="tenant-body d-flex justify-content-center">
                        <div class="form-wrapper col-6">
                            <form action="{{ route('tenant.update',$tenant->id) }}" method="post" class="" enctype="multipart/form-data">
                                @csrf @method('PUT')
                                <div class="row mb-3">
                                    <label for="id" class="col-2">ID: </label>
                                    <div class="col-10">
                                        <input type="text" name="id" id="id" value="{{ old('id') ? old('id') : $tenant->id  }}" class="form-control @error('id') is-invalid @enderror">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="name" class="col-2">Name: </label>
                                    <div class="col-10">
                                        <input type="text" name="name" id="name" value="{{ old('name') ? old('name') : $tenant->name  }}" class="form-control @error('name') is-invalid @enderror">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="phone_number" class="col-2">Contact: </label>
                                    <div class="col-10">
                                        <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') ? old('phone_number') : $tenant->phone_number  }}" class="form-control @error('phone_number') is-invalid @enderror">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="email" class="col-2">Email: </label>
                                    <div class="col-10">
                                        <input type="text" name="email" id="email" value="{{ old('email') ? old('email') : $tenant->email  }}" class="form-control @error('email') is-invalid @enderror">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="password" class="col-2">Password: </label>
                                    <div class="col-10">
                                        <input type="text" name="password" id="password" value="{{ old('password') ? old('password') : $tenant->password  }}" class="form-control @error('password') is-invalid @enderror">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="logo" class="col-2">Logo: </label>
                                    <div class="col-10">
                                        <input type="file" name="logo" id="logo" class="form-control @error('logo') is-invalid @enderror">
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
