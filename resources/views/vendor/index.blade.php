@extends('layouts.main')

@section('content')
<aside>
    <div class="layout-vendor">
        <div class="vendor-wrapper ">
            <div class="vendor-section">
                <div class="vendor-head d-flex justify-content-center p-5">
                    <span class="fs-3">List of the Vendors</span>
                </div>
                <div class="vendor-body">
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>SN</th>
                                        <th>Name</th>
                                        <th>Firm Name</th>
                                        <th>Address</th>
                                        <th>Contact</th>
                                        <th>PAN / VAT</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="tbody">
                                    @foreach ($vendors as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><a href="{{ route('vendors.show',$item->id) }}">{{ $item->name }}</a></td>
                                        <td>{{ $item->firm_name }}</td>
                                        <td>{{ $item->address }}</td>
                                        <td>{{ $item->contact }}</td>
                                        <td>
                                            @if($item->pan_vat == 'null')
                                            <span style="color:rgb(0,0,0,0.5);"><i>{{ 'null' }}</i></span>
                                            @else
                                            {{ $item->pan_vat }}
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('vendors.edit',$item->id) }}"><button
                                                        class="btn btn-sm btn-outline-secondary">EDIT</button></a>
                                                @if($item->deleted_at == null)
                                                    <form action="{{ route('vendors.destroy',$item->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete '.$item->name.'?')">DELETE</button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('vendors.restore',$item->id) }}" method="POST">
                                                        @csrf @method('POST')
                                                        <button class="btn btn-sm btn-outline-success">RESTORE</button>
                                                    </form>
                                                @endif
                                            </div>
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
