<aside>
    {{-- @php
        $tenantid = tenant()->id;
    @endphp --}}
    <div class="layout-sidenav">
        <div class="sidenav-wrapper">
            <div class="sidenav-section">
                <div class="logo-section p-5 d-flex justify-content-center">
                    <a href="{{ route('dashboard') }}">
                        <h4 class="text-uppercase">Grocery App</h4>
                        {{-- <h4 class="text-uppercase">{{ $tenantid }}</h4> --}}
                    </a>
                </div>
                <div class="side-nav-wrapper">
                    <ul>
                        <li class="mb-3">
                            <div class="vendor-section text-uppercase">Vendor Section</div>
                            <ul>
                                <li><a href="{{ route('vendors.create') }}">Add Vendor</a></li>
                                <li><a href="{{ route('vendors.index') }}">List Vendor</a></li>
                            </ul>
                        </li>
                        <li class="mb-3">
                            <div class="product-section">Product Section</div>
                            <ul>
                                <li><a href="{{ route('products.create') }}">Add New Product</a></li>
                                {{-- <li><a href="/products">List Products</a></li> --}}
                                {{-- Here is an error, work on it. --}}
                                <li><a href="{{ route('products.index') }}">List Products</a></li>
                            </ul>
                        </li>
                        <li class="mb-3"    >
                            <div class="variant-section">Variant Section</div>
                            <ul>
                                <li><a href="{{ route('variants.create') }}">Add New Variant</a></li>
                                <li><a href="{{ route('variants.index') }}">List Variants</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <style>
        .layout-sidenav {
            position: absolute;
            left: 0;
            top: 0;
            width: 20%;
            height: 100%;
            background-color: #D3D3D3;
        }

        .logo-section {
            position: relative;
            top: 0;
            left: 0;
        }
    </style>
</aside>
