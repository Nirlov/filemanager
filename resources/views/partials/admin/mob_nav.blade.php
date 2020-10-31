<!-- HEADER DESKTOP-->
@inject('info' , 'App\Lib\SiteInfo')
<header class="header-desktop2">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="header-wrap2">
                <div class="logo d-block d-lg-none">
                    <a href="{{ route('dashboard') }}">
                        @if(is_null($info->getInfo()->logo))
                        <img src="{{ asset('admin/images/architect.png') }}" alt="" style="width: 267px; height: 35px;"/>
                        @else
                        <img src="{{ asset('uploads/logo/'.$info->getInfo()->logo) }}" alt="" style="width: 267px; height: 35px;"/>
                        @endif
                    </a>
                </div>
                <div class="header-button2">
                    <div class="header-button-item mr-0 js-sidebar-btn">
                        <i class="zmdi zmdi-menu"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<aside class="menu-sidebar2 js-right-sidebar d-block d-lg-none">
    <div class="logo">
        <a href="#">
            <img src="{{ asset('admin/images/architect.png') }}" alt="" />
        </a>
    </div>
    <div class="menu-sidebar2__content js-scrollbar2">
        <div class="account2">
            <a href="#">
                <div class="image img-cir img-120">
                @if(!is_null(Auth::user()->image))
                    <img src="{{ asset('uploads/user/'.Auth::user()->image) }}" alt="" />
                @else
                    <img src="{{ asset('admin/images/icon/avatar-01.png') }}" alt="" />
                @endif
                </div>
            </a>
            <h4 class="name">{{ Auth::user()->name }}</h4><a href="{{ route('user_change_password') }}"><span class="badge badge-info">Change Password</span></a>
            <a href="{{ route('logout') }}">Sign out</a>
        </div>
        <nav class="navbar-sidebar2">
            <ul class="list-unstyled navbar__list">
                <li class="has-sub" id="dashboard">
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i>Dashboard
                    </a>
                </li>
                <li class="has-sub" id="department">
                    <a href="{{ route('department_index') }}">
                        <i class="fas fa-copy"></i>Departments
                    </a>                            
                </li>
                <li class="has-sub" id="doctor">
                    <a href="{{ route('doctor_index') }}">
                        <i class="fas fa-shopping-basket"></i>Doctors
                    </a>                            
                </li>
                <li class="has-sub" id="slider">
                    <a href="{{ route('slider_index') }}">
                        <i class="fas fa-images"></i>Slider
                    </a>                            
                </li>
                <li class="has-sub" id="career">
                    <a href="#">
                        <i class="far fa-check-square"></i>Career
                    </a>                            
                </li>
                <li class="has-sub" id="profile">
                    <a href="{{ route('profile_index') }}">
                        <i class="fas fa-user"></i>Profile
                    </a>                            
                </li>
            </ul>
        </nav>
    </div>
</aside>
<!-- END HEADER DESKTOP-->

    <!-- BREADCRUMB-->
    <section class="au-breadcrumb m-t-75">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                    You are here: @yield('breadcrumb')
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END BREADCRUMB-->