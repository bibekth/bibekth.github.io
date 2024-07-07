@extends('layouts.main')

@section('content')
<aside>
    <div class="layout-variant">
        <div class="variant-wrapper">
            <div class="variant-section">
                <div class="variant-head d-flex justify-content-center p-5">
                    <span class="fs-3">Edit the variant <strong>{{ $variant->name }}</strong></span>
                </div>
                <div class="variant-body">
                    <div class="form-wrapper container col-8">
                        <form action="{{ route('variants.update',$variant->id) }}" class="form" method="POST">
                            @csrf @method('PATCH')
                            <div class="form-section">
                                <div class="row mb-3">
                                    <label for="name" class="col-2 col-form-label d-flex justify-content-end">Name:</label>
                                    <div class="col-10">
                                        <input type="text" name="name" id="name" value="{{ old('name') ? old('name') : $variant->name }}"
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
                                    <label for="variant_code" class="col-2 col-form-label d-flex justify-content-end">Variant Code:</label>
                                    <div class="col-10">
                                        <input type="text" name="variant_code" id="variant_code" value="{{ old('variant_code') ? old('variant_code') : $variant->variant_code }}"
                                            class="form-control @error('variant_code') is-invalid @enderror" required
                                            autofocus />
                                        @error('variant_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="description" class="col-2 col-form-label d-flex justify-content-end">Description:</label>
                                    <div class="col-10">
                                            <textarea name="description" id="description" class="form-control @error('desccription') is-invalid @enderror" cols="10" rows="4">{{ old('description') ? old('description') : $variant->description }}</textarea>
                                        @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="submit-button p-5 d-flex justify-content-center">
                                        <button class="btn btn-outline-primary">Submit</button>
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
