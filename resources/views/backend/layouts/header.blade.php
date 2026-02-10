<div class="navbar-header">
    <div class="d-flex">
        <div class="navbar-brand-box">
            <a href="{{ route('dashboard') }}" class="logo logo-dark">
                <span class="logo-sm">
                    <img src="{{ asset('storage/assets/images/logo-sm-dark.png') }}" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="{{ asset('storage/assets/images/logo-dark.png') }}" alt="" height="24">
                </span>
            </a>
            <a href="{{ route('dashboard') }}" class="logo logo-light">
                <span class="logo-sm">
                    <img src="{{ asset('storage/assets/images/logo-sm-light.png') }}" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="{{ asset('storage/assets/images/logo-light.png') }}" alt="" height="24">
                </span>
            </a>
        </div>
        <button type="button" class="btn px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
            <i class="mdi mdi-menu"></i>
        </button>
    </div>
    <div class="d-flex">
        <div class="dropdown d-inline-block d-lg-none ms-2">
            <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="mdi mdi-magnify"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                aria-labelledby="page-header-search-dropdown">
                <form class="p-3">
                    <div class="form-group m-0">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search ..."
                                aria-label="Recipient's username">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- User -->
        <div class="dropdown d-inline-block">
            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="rounded-circle header-profile-user" src="{{ asset('storage/assets/images/users/avatar-4.jpg') }}"
                    alt="Header Avatar">
            </button>

            <div class="dropdown-menu dropdown-menu-end">
                <!-- item-->
                <a class="dropdown-item" href="#"><i
                        class="mdi mdi-account-circle font-size-16 align-middle me-2 text-muted"></i>
                    <span>Profile</span></a>
                <div class="dropdown-divider"></div>
                 <form method="POST" action="{{ route('logout') }}">
                        @csrf
                    <a class="dropdown-item text-primary" :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();" style="cursor: pointer"><i
                        class="mdi mdi-power font-size-16 align-middle me-2 text-primary"></i>
                    <span>Logout</span></a>
                </form>
            </div>
        </div>
        <!-- Setting -->
        <div class="dropdown d-inline-block">
            <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                <i class="mdi mdi-cog bx-spin"></i>
            </button>
        </div>

    </div>
</div>
