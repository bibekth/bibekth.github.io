@extends('layouts.main')

@section('content')
<aside>
    <div class="layout-product">
        <div class="product-wrapper">
            <div class="product-section">
                <div class="product-head d-flex justify-content-center p-5">
                    <span class="fs-3">Edit <strong>{{ $product->name }}</strong> </span>
                </div>
                <div class="product-body">
                    <div class="form-wrapper container col-8">
                        <form action="{{ route('products.update',$product->id) }}" class="form" method="POST">
                            @csrf @method('PATCH')
                            <div class="form-section">
                                <div class="row mb-3">
                                    <label for="name"
                                        class="col-2 col-form-label d-flex justify-content-end">Name:</label>
                                    <div class="col-10">
                                        <input type="text" name="name" id="name"
                                            value="{{ (old('name') ? old('name') : $product->name) ? $product->name : '' }}"
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
                                    <label for="description"
                                        class="col-2 col-form-label d-flex justify-content-end">Description:</label>
                                    <div class="col-10">
                                        <textarea name="description" id="description"
                                            class="form-control @error('desccription') is-invalid @enderror" cols="10"
                                            rows="4">{{ (old('description') ? old('description') : $product->description == null ) ? '' : $product->description }}</textarea>
                                        @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="submit-button p-5 d-flex justify-content-center">
                                        <button class="btn btn-outline-primary">Update</button>
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
