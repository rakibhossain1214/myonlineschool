<aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">

            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="./"><img class="mt-2" src="{{asset('uploads/avatars').'/'.$user->avatar}}" alt="Logo"></a>
                <form enctype="multipart/form-data" action="{{ url('dashboard') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="file" name="avatar" class="form-control-file text-primary" id="profile-pic">
                        <input type="submit" value="Upload profile picture" class="mt-1 form-control-file btn btn-sm btn-primary" id="profile-pic">
                    </div>
                </form>
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="{{ url('/dashboard') }}"> <i class="menu-icon fa fa-dashboard"></i>Profile Information </a>
                    </li>
                    <li>
                        <a href="{{ url('/dashboard/course/') }}"> <i class="menu-icon fa fa-laptop"></i>Instructing Courses</a>
                    </li>
                    <li>
                        <a href="{{ url('/dashboard/message/') }}"> <i class="menu-icon fa fa-envelope"></i>Messages</a>
                    </li>
                   
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><!-- /#left-panel -->