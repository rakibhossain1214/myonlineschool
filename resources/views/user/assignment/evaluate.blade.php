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

                    @if($errormessage != null)
                        <div class="alert alert-success">
                            {{ $errormessage }}
                        </div>
                    @endif
                        <div class="card-header">
                            <strong class="card-title">{{ $page_name }}</strong>
                        </div>

                        <div class="card-body">
                        @if(count($errors) > 0)
                                    <div class="alert alert-danger" role="alert">
                                        <ul>
                                        @foreach($errors->all() as $error)
                                            <li>
                                                {{ $error }}
                                            </li>
                                        @endforeach
                                        </ul>
                                    </div>
                                @endif
                        <hr>
                        

                            @foreach($assignment as $a)
                            <form enctype="multipart/form-data" action="{{ url('dashboard/course/view/'.$course->id.'/assignment/submission/store/'.$a->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label> Assignment Title: <strong> {{ $a->assignment_title }}</strong> </label>
                            </div>
                            
                            <a href="{{ asset('uploads/courses/assignments/submissions'.$a->assignment_file_student) }}" download> 
                                    <p class="alert-heading text-primary">Submitted Assignment File</p>
                            </a>
                           
                            <div class="form-group">
                                <label> Total marks: <strong> {{ $a->assignment_total_marks }}</strong> </label>
                            </div>
                            <hr>
                            
                            @endforeach
                            <div class="form-group">
                                Obtained Marks:
                                <input type="number" name="assignment_obtained_marks" placeholder="0" id="assignment_obtained_marks">
                            </div>

                                         

                            <div class="form-group">
                                <input type="submit" value="Evaluate Assignment" class="mt-1 form-control-file btn btn-sm btn-primary" id="assignment_file_teacher">
                            </div>

                        </form>
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

    

@endsection

