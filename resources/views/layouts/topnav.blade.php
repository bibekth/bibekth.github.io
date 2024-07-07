<aside>
    <div class="layout-topnav">
        <div class="topnav-wrapper">
            <div class="topnav-section d-flex align-items-center">
                <div class="row container">
                    <div class="col-2">
                        <div class="d-flex justify-content-center allign-items-center">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .layout-topnav {
            position: absolute;
            top: 0;
            left: 20%;
            width: 80%;
            height: 8%;
            display: flex;
            align-items: center;
            justify-content: end;
            background-color: #FFDAB9;
        }
    </style>
</aside>
