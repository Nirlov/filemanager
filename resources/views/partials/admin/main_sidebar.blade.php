@inject('info' , 'App\Lib\SiteInfo')
<aside class="menu-sidebar2">
        <div class="logo">
            <a href="{{ route('dashboard') }}">
                @if(is_null($info->getInfo()->logo))
                <img class="scale-with-grid" src="{{ asset('admin/images/architect.png') }}" alt="" style="width: 267px; height: auto;"/>
                @else
                <img class="scale-with-grid" src="{{ asset('uploads/logo/'.$info->getInfo()->logo) }}" alt="Braak Konto" style="width: 267px; height: auto;"/>
                @endif
            </a>
        </div>
        <div class="menu-sidebar2__content js-scrollbar1">
            <div class="account2">
                <a href="{{ route('user_index') }}">
                    <div class="image img-cir img-120">
                    @if(!is_null(Auth::user()->image))
                        <img src="{{ asset('uploads/user/'.Auth::user()->image) }}" alt="" />
                    @else
                        <img src="{{ asset('admin/images/icon/avatar-01.png') }}" alt="" />
                    @endif
                    </div>
                </a>
                <h4 class="name">{{ Auth::user()->name }}</h4><a href="{{ route('user_change_password') }}"><span class="badge badge-info">Change Password</span></a>
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Sign out</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
            </div>
            <nav class="navbar-sidebar2">
                <ul class="list-unstyled navbar__list">
                    <li class="has-sub" id="dashboard">
                        <a class="js-arrow" href="{{ route('dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i>Dashboard
                        </a>                            
                    </li>
                    <li class="has-sub" id="category">
                        <a class="js-arrow" href="{{ route('question_category_index') }}">
                            <i class="fa fa-bolt"></i>Question Category
                        </a>                            
                    </li>
                    <li class="has-sub" id="question">
                        <a class="js-arrow" href="{{ route('question_bank_index') }}">
                            <i class="fas fa-question"></i>Question Bank
                        </a>                            
                    </li>
                    <li class="has-sub" id="subject">
                        <a class="js-arrow" href="{{ route('recent_subject_index') }}">
                            <i class="fa fa-bolt"></i>Recent Subject
                        </a>                            
                    </li>
                    <li class="has-sub" id="circuler">
                        <a class="js-arrow" href="{{ route('circuler_index') }}">
                            <i class="fas fa-images"></i>Circuler
                        </a>                            
                    </li>
                    <li class="has-sub" id="profile">
                        <a class="js-arrow" href="{{ route('profile_index') }}">
                            <i class="fas fa-info"></i>Profile
                        </a>                            
                    </li>
                </ul>
            </nav>
        </div>
    </aside>