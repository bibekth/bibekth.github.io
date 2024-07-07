@extends('layouts.main')

@section('content')
    <aside>
        <div class="layout-product">
            <div class="product-wrapper">
                <div class="product-section">
                    <div class="product-head d-flex justify-content-center p-5">
                        <span class="fs-3">List of the Products</span>
                    </div>
                    <div class="product-body">
                        <div class="table-wrapper">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="thead">
                                        <tr>
                                            <th>SN</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbody">
                                        @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $product->name }}</td>
                                            @if($product->description == null)
                                            <td><i class="dull-null">null</i></td>
                                            @else
                                            <td>{{ $product->description }}</td>
                                            @endif
                                            <td class="d-flex gap-2">
                                                <a href="{{ route('products.edit',$product->id) }}"><button class="btn btn-sm btn-outline-secondary">EDIT</button></a>
                                                @if ($product->deleted_at == null)
                                                <form action="{{ route('products.destroy',$product->id) }}" class="form" method="POST">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this product?')">DELETE</button>
                                                </form>
                                                @else
                                                <form action="{{ route('products.restore',$product->id) }}" method="post">
                                                @csrf
                                                <button class="btn btn-sm btn-outline-success">RESTORE</button>
                                                </form>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>
@endsection
