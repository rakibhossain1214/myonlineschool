@extends('user.layout.coursemaster')
@section('content')

<link rel="stylesheet" href="{{ asset('teacher/assets/css/lib/datatable/dataTables.bootstrap.min.css') }}">

<div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">

                <div class="col-md-12">
                    <div class="card">

                    @if($message = Session::get('success'))
                        <div class="alert alert-success">
                            {{ $message }}
                        </div>
                    @endif
                        <div class="card-header">
                            <strong class="card-title">{{ $page_name }}</strong>
                            @if($user->type == 2 || $user->type == 3)
                            <a href="{{ url('dashboard/course/view/'.$course->id.'/note/create') }}" class="btn m-1 btn-primary pull-right" >Upload a new note</a>
                            @endif
                        </div>
                        <div class="card-body">
                        @foreach($note as $not)
                        <div class="alert alert-primary" role="alert">
                                <a href="{{ asset('uploads/courses/notes/'.$not->note_content) }}" download>
                                    <h4 class="alert-heading text-primary">{{ $not->note_title }}</h4>    
                                    <p>{{ Carbon\Carbon::parse($not->created_at)->diffForHumans() }}</p>
                                    
                                    <p class="alert-heading text-primary">{{ $not->note_content }}</p>
                                </a>
                                @if($user->type == 2 || $user->type == 3)
                                    {{ Form::open(['method'=>'DELETE', 'url'=>['dashboard/course/view/'.$course->id.'/note/delete/'.$not->id], 'style'=>'display:inline'])}}
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

