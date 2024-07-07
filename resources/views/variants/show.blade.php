@extends('layouts.main')

@section('content')
<aside>
    <div class="layout-variant">
        <div class="variant-wrapper">
            <div class="variant-section">
                <div class="variant-head">
                    <span class="fs-3">Variant <strong>{{ $variant->name }}</strong></span>
                </div>
                <div class="variant-body">
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $variant->name }}</td>
                                </tr>
                                <tr>
                                    <th>Variant Code</th>
                                    <td>{{ $variant->variant_code }}</td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td class="text-wrap">{{ $variant->description }}</td>
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
