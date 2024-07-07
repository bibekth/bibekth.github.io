@extends('layouts.app')

@section('app-content')
<aside>
    <div class="layout-tenant container">
        <div class="tenant-wrapper">
            <div class="tenant-section">
                <div class="tenant-head d-flex justify-content-center p-5">
                    <span class="fs-3">List of all the tenants</span>
                </div>
                <div class="tenant-body">
                    <div class="add-new">
                        <span><a href="{{ route('tenant.create') }}"><i class="fa fa-plus-circle"
                                    aria-hidden="true"></i> Add New</a></span>
                    </div>
                    <div class="table-wrapper">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered no-wrap">
                                <thead class="thead ">
                                    <tr>
                                        <th>S.N.</th>
                                        <th>Logo</th>
                                        <th>Company Info</th>
                                        <th>Email</th>
                                        <th>Domain</th>
                                        <th>Joined At</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="tbody">
                                    @foreach ($tenants as $item)
                                    @php
                                    $domain = null;
                                        foreach($domains as $value){
                                            if($value->tenant_id == $item->id){
                                                $domain = $value;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><a href="{{ route('tenant.show',$item->id) }}">
                                            <img src="{{ asset('storage/images/'.$item->tenant_logo) }}" alt="" class="img-thumbnail" style="width:auto; height:50px;"></a>
                                        </td>
                                        <td><a href="{{ route('tenant.show',$item->id) }}">{{ $item->name }}</a></td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $domain->domain.'.meropasal.org' }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            @if($item->deleted_at == null)
                                            {{ 'Active' }}
                                            @else
                                            {{ 'Deactivated' }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->deleted_at == null)
                                            <form action="{{ route('tenant.destroy',$item->id) }}" method="post">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete '.$item->name)">DELETE</button>
                                            </form>
                                            @else
                                            <form action="{{ route('tenant.restore',$item->id) }}" method="post">
                                                @csrf
                                                <button class="btn btn-sm btn-success" onclick="return confirm('Are you sure you want to delete '.$item->name)">RESTORE</button>
                                            </form>
                                            @endif

                                        </td>
                                        {{-- <td class="d-flex gap-2">
                                            <a href="{{ route('tenant.edit',$item->id) }}"><button class="btn btn-sm btn-secondary">EDIT</button></a>
                                            <form action="{{ route('tenant.destroy',$item->id) }}" method="post">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete '.$item->name)">DELETE</button>
                                        </form>
                                        </td> --}}
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
<style>
    a{
        text-decoration: none;
        color: inherit;
    }
</style>
@endsection
