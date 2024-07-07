@extends('layouts.main')

@section('content')
<aside>
    <div class="layout-vendor">
        <div class="vendor-wrapper ">
            <div class="vendor-section">
                <div class="vendor-head d-flex justify-content-center p-5">
                    <span class="fs-3">Edit the Vendor</span>
                </div>
                <div class="vendor-body">
                    <div class="form-wrapper container col-8">
                        <form action="{{ route('vendors.update',$vendor->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <div class="form-section">
                                <div class="row mb-3">
                                    <label for="name" class="col-2 col-form-label d-flex justify-content-end">Name:</label>
                                    <div class="col-10">
                                        <input type="text" name="name" id="name" value="{{ (old('name') ? old('name') : $vendor->name) ? $vendor->name : 'null' }}"
                                            class="form-control @error('name') is-invalid @enderror" required
                                            autofocus />
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="firm_name" class="col-2 col-form-label d-flex justify-content-end">Firm Name:</label>
                                    <div class="col-10">
                                        <input type="text" name="firm_name" id="firm_name" value="{{ (old('firm_name') ? old('firm_name') : $vendor->firm_name) ? $vendor->firm_name : 'null' }}"
                                            class="form-control @error('firm_name') is-invalid @enderror" required
                                            autofocus />
                                        @error('firm_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="address" class="col-2 col-form-label d-flex justify-content-end">Address:</label>
                                    <div class="col-10">
                                        <input type="text" name="address" id="address" value="{{ (old('address') ? old('address') : $vendor->address) ? $vendor->address : 'null' }}"
                                            class="form-control @error('address') is-invalid @enderror"
                                            autofocus />
                                        @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="contact" class="col-2 col-form-label d-flex justify-content-end">Contact:</label>
                                    <div class="col-10">
                                        <input type="text" name="contact" id="contact" value="{{ (old('contact') ? old('contact') : $vendor->contact) ? $vendor->contact : 'null' }}"
                                            class="form-control @error('contact') is-invalid @enderror" required
                                            autofocus />
                                        @error('contact')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="pan_vat" class="col-2 col-form-label d-flex justify-content-end">PAN / VAT:</label>
                                    <div class="col-10">
                                        <input type="text" name="pan_vat" id="pan_vat" value="{{ (old('pan_vat') ? old('pan_vat') : $vendor->pan_vat) ? $vendor->pan_vat : 'null' }}"
                                            class="form-control @error('pan_vat') is-invalid @enderror"
                                            autofocus />
                                        @error('pan_vat')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 pt-3">
                                    <div class="submit-button d-flex justify-content-center">
                                        <input type="submit" value="Update" class="btn btn-outline-primary">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</aside>
@endsection
