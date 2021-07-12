<div class="left side-menu">
    <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
        <i class="ion-close"></i>
    </button>

    <div class="left-side-logo d-block d-lg-none">
        <div class="text-center">
            <a href="index.html" class="logo"><img src="{{ asset('assets/images/logo-dark.jpg') }}" class="img-fluid" alt="logo"></a>
        </div>
    </div>

    <div class="sidebar-inner slimscrollleft">

        <div id="sidebar-menu">
            <ul>
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="waves-effect">
                        <i class="ion-social-buffer"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.category.index') }}" class="waves-effect">
                        <i class="ion-clipboard"></i>
                        <span> Manage Category  </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.subcategory.index') }}" class="waves-effect">
                        <i class="ion-clipboard"></i>
                        <span> Manage Sub Category </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.color.index') }}" class="waves-effect">
                        <i class="ion-android-display"></i>
                        <span> Manage Color Palette </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.users.index') }}" class="waves-effect">
                        <i class="ion-android-social"></i>
                        <span> Manage Users </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.poll.index') }}" class="waves-effect">
                        <i class="ion-pie-graph"></i>
                        <span> Manage Poll </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.notification.index') }}" class="waves-effect">
                        <i class="ion-ios7-bell"></i>
                        <span> Notifications </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.contactus.index') }}" class="waves-effect">
                        <i class="fa fa-question"></i>
                        <span> Contact Us </span>
                    </a>
                </li>

            </ul>
        </div>
        <div class="clearfix"></div>
    </div> <!-- end sidebarinner -->
</div>
