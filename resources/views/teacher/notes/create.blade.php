@extends('teacher.layout.coursemaster')
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
                        <form enctype="multipart/form-data" action="{{ url('dashboard/course/view/'.$course->id.'/note/store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="note_title" placeholder="Note Name" id="note_title">
                            </div>

                            <div class="form-group">
                                <input type="file" name="note_content" class="form-control-file text-primary" id="note-file">
                                <input type="submit" value="Upload Course Note" class="mt-1 form-control-file btn btn-sm btn-primary" id="note-file">
                            </div>

                        </form>
                        </div>
                    </div>
                </div>


                </div>
            </div><!-- .animated -->
        </div><!-- .content -->


    <script src="{{ asset('teacher/assets/js/vendor/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ asset('teacher/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('teacher/assets/js/plugins.js') }}"></script>
    <script src="{{ asset('teacher/assets/js/main.js') }}"></script>

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

