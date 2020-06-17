<aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">

            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="./"><img class="mt-2" src="{{asset('uploads/courses').'/'.$course->c_image}}" alt="Logo"></a>
                
                @if($course->c_teacher_id == $user->id || $user->type == 3)
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
                    
                    @if($course->c_teacher_id == $user->id || $user->type == 3)
                    <li>
                        <a href="{{ url('/dashboard/course/view/'.$course->id.'/student') }}"> <i class="menu-icon fa fa-users"></i>Course Students</a>
                    </li>
                    
                    <li>
                        <a href="{{ url('/dashboard/course/view/'.$course->id.'/note') }}"> <i class="menu-icon fa fa-sticky-note"></i>Course Notes</a>
                    </li>
                    <li>
                        <a href="{{ url('/dashboard/course/view/'.$course->id.'/assignment') }}"> <i class="menu-icon fa fa-tasks"></i>Course Assignments</a>
                    </li>
                    
                    <li>
                        <a href="{{ url('/dashboard/course/view/'.$course->id.'/notice') }}"> <i class="menu-icon fa fa-window-restore"></i>Course Notices</a>
                    </li>
                    <li>
                        <a href="{{ url('/dashboard/course/view/'.$course->id.'/video') }}"> <i class="menu-icon fa fa-window-restore"></i>Live Class</a>
                    </li>
                    <li>
                        <a href="{{ url('/dashboard/course/view/'.$course->id.'/report') }}"> <i class="menu-icon fa fa-flag"></i>Report</a>
                    </li>
                    @elseif($status==1)
                    <li>
                        <a href="{{ url('/dashboard/course/view/'.$course->id.'/note') }}"> <i class="menu-icon fa fa-sticky-note"></i>Course Notes</a>
                    </li>
                    <li>
                        <a href="{{ url('/dashboard/course/view/'.$course->id.'/assignment') }}"> <i class="menu-icon fa fa-tasks"></i>Course Assignments</a>
                    </li>
                    <li>
                        <a href="{{ url('/dashboard/course/view/'.$course->id.'/assignment/assignment-marks') }}"> <i class="menu-icon fa fa-graduation-cap"></i>Assignment Marks</a>
                    </li>
                    <li>
                        <a href="{{ url('/dashboard/course/view/'.$course->id.'/notice') }}"> <i class="menu-icon fa fa-window-restore"></i>Course Notices</a>
                    </li>
                    <li>
                        <a href="{{ url('/dashboard/course/view/'.$course->id.'/video') }}"> <i class="menu-icon fa fa-video-camera"></i>Live Class</a>
                    </li>
                    <li>
                        <a href="{{ url('/dashboard/course/view/'.$course->id.'/report') }}"> <i class="menu-icon fa fa-flag"></i>Report</a>
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