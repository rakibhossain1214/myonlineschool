<header id="header" class="header">

<div class="header-menu">

    <div class="col-sm-7">
        <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
        <div class="header-left">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a> 

                <a class="navbar-brand" href="{{ url('/') }}">
                    | Home
                </a> 

                <a class="navbar-brand" href="{{ url('/all-courses') }}">
                    Courses
                </a> 
        </div>
    </div>

    <div class="col-sm-5">
        <div class="user-area dropdown float-right">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="user-avatar rounded-circle" src="{{asset('uploads/avatars').'/'.$user->avatar}}" alt="User Avatar">
            </a>

            <div class="user-menu dropdown-menu">
            <a class="nav-link" href="{{ url('/dashboard') }}"><i class="menu-item fa fa-dashboard"></i>Dashboard</a>
                    <a class="nav-link" href="{{  url('dashboard/notification') }}"><i class="menu-item fa fa-bell"></i>Notifications <span class="count">{{ $n }}</span></a>
                    <a class="nav-link" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                     <i class="menu-item fa fa-user"></i>{{ __('Logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
            </div>
        </div>

    </div>
</div>

</header><!-- /header -->