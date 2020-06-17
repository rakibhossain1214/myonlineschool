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
                        <div class="alert alert-danger">
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
                        <form enctype="multipart/form-data" action="{{ url('dashboard/course/view/'.$course->id.'/assignment/store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="assignment_title" placeholder="Title" id="assignment_title">
                            </div>

                            <div class="form-group">
                                <input type="text" name="assignment_description" placeholder="Description" id="assignment_description">
                            </div>

                            <div class="form-group">
                                <input type="number" name="assignment_total_marks" placeholder="Total Marks" id="assignment_total_marks">
                            </div>

                            <div class="form-group">
                                <input type="date" name="assignment_deadline" placeholder="Deadline" id="assignment_deadline">
                            </div>

                            <div class="form-group">
                                <input type="file" name="assignment_file_teacher" class="form-control-file text-primary" id="assignment_file_teacher">
                                <input type="submit" value="Add Course Assignment" class="mt-1 form-control-file btn btn-sm btn-primary" id="assignment_file_teacher">
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

    <script type="text/javascript">
        $(document).ready(function() {
          $('#bootstrap-data-table-export').DataTable();
        } );
    </script>

@endsection

