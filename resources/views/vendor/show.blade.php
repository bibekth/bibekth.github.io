@extends('layouts.main')
@section('content')
    <aside>
        <div class="layout-vendor">
            <div class="vendor-wrapper">
                <div class="vendor-section">
                    <div class="vendor-head d-flex justify-content-center p-5">
                        <span class="fs-3">Vendor <strong>{{ $vendor->name }}</strong></span>
                    </div>
                    <div class="vendor-body">
                        <div class="table-wrapper">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Firm Name</th>
                                        <td>{{ $vendor->firm_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Owner Name</th>
                                        <td>{{ $vendor->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Contact</th>
                                        <td>{{ $vendor->contact }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $vendor->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Address</th>
                                        <td>{{ $vendor->address }}</td>
                                    </tr>
                                    <tr>
                                        <th>PAN/VAT</th>
                                        <td>{{ $vendor->pan_vat }}</td>
                                    </tr>
                                    <tr>
                                        <th>Joined At</th>
                                        <td>{{ $vendor->created_at }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>
@endsection
