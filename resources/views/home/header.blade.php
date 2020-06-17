<div class="container">

      <div id="logo" class="pull-left">
        <h1><a href="{{ url('/') }}" class="scrollto">Online<span>School</span></a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="#body"><img src="img/logo.png" alt="" title="" /></a>-->
      </div>

      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <li class="menu-active"><a href="{{ url('/') }}">Home</a></li>
          <li><a href="{{ url('/all-courses') }}">Courses</a></li>
          <li><a href="{{ url('/terms') }}">Terms</a></li>
          <li><a href="{{ url('/privacy') }}">Privacy Policy</a></li>


          <li class="menu-has-children">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="rounded-circle" style="width:30px; height:30px;" src="{{asset('uploads/avatars').'/'.$user->avatar}}" alt="User Avatar">
                {{ $user->name }}
            </a>
            <ul>
              <li><a href="{{ url('/dashboard') }}"><i class="menu-item fa fa-dashboard"></i>Dashboard</a></li>
              <li><a href="{{ url('/dashboard/notification') }}"><i class="menu-item fa fa-bell"></i>Notifications <span class="count">{{ $n }}</span></a></li>
              <li>
              <a class="nav-link" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                     <i class="menu-item fa fa-user"></i>{{ __('Logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
              </li>
              
            </ul>
          </li>
        </ul>
      </nav><!-- #nav-menu-container -->
    </div>