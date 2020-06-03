<aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">

            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="./"><img class="mt-2" src="{{asset('uploads/courses').'/'.$course->c_image}}" alt="Logo"></a>
                
                @if($user->type == 2 || $user->type == 3)
                <form enctype="multipart/form-data" action="{{ url('dashboard/course/view/'.$course->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="file" name="c_image" class="form-control-file text-primary" id="course-pic">
                        <input type="submit" value="Upload Course picture" class="mt-1 form-control-file btn btn-sm btn-primary" id="course-pic">
                    </div>
                </form>
                @endif
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="{{ url('/dashboard/course/view/'.$course->id) }}"> <i class="menu-icon fa fa-dashboard"></i>Course Overview</a>
                    </li>
                    
                    @if($status == 1 || $user->type == 2 || $user->type == 3)
                    <li>
                        <a href="{{ url('/dashboard/course/view/'.$course->id.'/student') }}"> <i class="menu-icon fa fa-laptop"></i>Course Students</a>
                    </li>
                    
                    <li>
                        <a href="{{ url('/dashboard/course/view/'.$course->id.'/note') }}"> <i class="menu-icon fa fa-envelope"></i>Course Notes</a>
                    </li>
                    <li>
                        <a href="{{ url('/dashboard/course/view/'.$course->id.'/notice') }}"> <i class="menu-icon fa fa-envelope"></i>Course Notices</a>
                    </li>
                    <li>
                        <a href="{{ url('/dashboard/course/view/'.$course->id.'/video') }}"> <i class="menu-icon fa fa-envelope"></i>Live Class</a>
                    </li>
                    @else
                    <li>
                        <a href="{{ url('/dashboard/course/view/'.$course->id.'/book') }}"> <i class="menu-icon fa fa-envelope"></i>Book Course</a>
                    </li>
                    @endif
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><!-- /#left-panel -->