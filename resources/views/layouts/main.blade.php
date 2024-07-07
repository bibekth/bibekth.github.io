<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- @php
        $tenant = ucfirst(tenant()->id);
    @endphp --}}
    {{-- <title> {{ $tenant }}</title> --}}
    <title>Grocery App</title>
    @include('layouts.utilities')

</head>

<body>
    @if (auth()->user()->role === 'Admin')
    <div class="layout-wrapper">
        <div class="sidenav-wrapper">
            @include('layouts.sidenav')
            <div class="topnav-wrapper">
                @include('layouts.topnav')
                <div class="content-wrapper container">
                    @include('errors.session')
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    @else
    @php
        abort(403);
    @endphp
    @endif
</body>

</html>
