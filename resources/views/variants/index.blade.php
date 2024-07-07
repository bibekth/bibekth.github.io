@extends('layouts.main')
@section('content')
    <aside>
        <div class="layout-variant">
            <div class="variant-wrapper">
                <div class="variant-section">
                    <div class="variant-head d-flex justify-content-center p-5">
                        <span class="fs-3">List of Variants</span>
                    </div>
                    <div class="variant-body">
                        <div class="table-wrapper">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="thead">
                                        <tr>
                                            <th>SN</th>
                                            <th>Name</th>
                                            <th>Code</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbody">
                                        @foreach ($variants as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td> <a href="{{ route('variants.show',$item->id) }}">{{ $item->name }}</a></td>
                                            <td>{{ $item->variant_code }}</td>
                                            <td>
                                                @if ($item->description == null)
                                                <i class="dull-null">null</i>
                                                @else
                                                {{ $item->description }}</td>
                                                @endif
                                                <td class="d-flex gap-2">
                                                    <a href="{{ route('variants.edit',$item->id) }}"><button class="btn btn-sm btn-outline-secondary">EDIT</button></a>
                                                    @if ($item->deleted_at == null)
                                                    <form action="{{ route('variants.destroy',$item->id) }}" class="form" method="POST">
                                                        @csrf @method('DELETE')
                                                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this item?')">DELETE</button>
                                                    </form>
                                                    @else
                                                    <form action="{{ route('variants.restore',$item->id) }}" method="post">
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
