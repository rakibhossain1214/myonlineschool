@extends('user.layout.coursemaster')
@section('content')

<link rel="stylesheet" href="{{ asset('teacher/assets/css/lib/datatable/dataTables.bootstrap.min.css') }}">

<div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">

                <div class="col-md-12">
                    <div class="card">

                    @if($mymessage != null)
                        <div class="alert alert-success">
                            {{ $mymessage }}
                        </div>
                    @endif
                        <div class="card-header">
                            <strong class="card-title">{{ $page_name }}</strong>
                            @if($user->type == 2 || $user->type == 3)
                            <a href="{{ url('dashboard/course/view/'.$course->id.'/assignment/create') }}" class="btn m-1 btn-primary pull-right" >Upload a new Assignment</a>
                            @endif
                        </div>
                        <div class="card-body">
                        @foreach($assignment as $as)
                        <div href="{{ url('dashboard/course/view/'.$course->id.'/assignment/create')}}" class="alert alert-secondary" role="alert">
                                
                                    <h4 class="alert-heading text-primary">{{ $as->assignment_title }}</h4>    
                                    <p>{{ Carbon\Carbon::parse($as->created_at)->diffForHumans() }}</p>
                                    <hr>
                                    <p>Deadline: <strong>{{ $as->assignment_deadline }}</strong></p>
                                    <p>Total Marks: <strong>{{ $as->assignment_total_marks }}</strong></p>
                                <a href="{{ asset('uploads/courses/assignments/'.$as->assignment_file_teacher) }}" download> 
                                    <p class="alert-heading text-primary">Download Assignment</p>
                                </a>

                                <hr>

                                @if($user->type == 1)
                                <a class="btn btn-primary" href="{{ url('dashboard/course/view/'.$course->id.'/assignment/submit/'.$as->id) }}"> 
                                    Submit Assignment
                                </a>

                                <hr>
                                @elseif($user->type == 2 || $user->type == 3)
                                <a class="btn btn-primary" href="{{ url('dashboard/course/view/'.$course->id.'/assignment/submission/'.$as->id) }}"> 
                                    Assignment Submissions
                                </a>

                                    {{ Form::open(['method'=>'DELETE', 'url'=>['dashboard/course/view/'.$course->id.'/assignment/delete/'.$as->id], 'style'=>'display:inline'])}}
                                    {{ Form::submit('Delete', ['class' =>'btn btn-danger']) }}
                                    {{ Form::close() }}
                                @endif
                        </div>
                        @endforeach
                        </div>
                    </div>
                </div>


                </div>
            </div><!-- .animated -->
        </div><!-- .content -->

                            




    <script src="{{ asset('teacher/assets/js/lib/data-table/datatables.min.js') }}"></script>
    <script src="{{ asset('teacher/assets/js/lib/data-table/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('teacher/assets/js/lib/data-table/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('teacher/assets/js/lib/data-table/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('teacher/assets/js/lib/data-table/jszip.min.js') }}"></script>
    <script src="{{ asset('teacher/assets/js/lib/data-table/pdfmake.min.js') }}"></script>
    <script src="{{ asset('teacher/assets/js/lib/data-table/vfs_fonts.js') }}"></script>
    <script src="{{ asset('teacher/assets/js/lib/data-table/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('teacher/assets/js/lib/data-table/buttons.print.min.js') }}"></script>
    <script src="{{ asset('teacher/assets/js/lib/data-table/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('teacher/assets/js/lib/data-table/datatables-init.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
          $('#bootstrap-data-table-export').DataTable();
        } );
    </script>

@endsection

