<div class="ajax-loader">
    <div class="spinner-border ajax-spinner text-primary" role="status">
    </div>
</div>

<div class="topbar">

    <div class="topbar-left	d-none d-lg-block">
        <div class="text-center">
            <a href="{{ route('admin.dashboard') }}" class="logo"><img src="{{ asset('assets/images/logo-dark.jpg') }}" class="img-fluid" alt="logo"></a>
        </div>
    </div>

    <nav class="navbar-custom">

        <ul class="list-inline float-right mb-0">
            <!-- <li class="list-inline-item notification-list dropdown d-none d-sm-inline-block">
                <form role="search" class="app-search">
                    <div class="form-group mb-0"> 
                        <input type="text" class="form-control" placeholder="Search..">
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </form> 
            </li> -->

            <li class="list-inline-item dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button"
                aria-haspopup="true" aria-expanded="true">
                <img src="{{ asset('assets/images/users/user-1.jpg')}}" alt="user" class="rounded-circle">
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown ">
                <a class="dropdown-item" href="{{ route('admin.change-password') }}"><i class="mdi mdi-lock-open-outline m-r-5 text-muted"></i> Change Password</a>

                <a class="dropdown-item" href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="mdi mdi-logout m-r-5 text-muted"></i> Logout</a>

                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>

    </ul>

    <ul class="list-inline menu-left mb-0">
        <li class="list-inline-item">
            <button type="button" class="button-menu-mobile open-left waves-effect">
                <i class="ion-navicon"></i>
            </button>
        </li>
    </ul>

    <div class="clearfix"></div>

</nav>

</div>