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
                            <a href="{{ url('dashboard/course/view/'.$course->id.'/assignment/create') }}" class="btn m-1 btn-primary pull-right" >Upload a new Assignment</a>
                            @endif
                        </div>
                        <div class="card-body">

                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Assignment Title</th>
                        <th>Submission Time</th>
                        <th>Total Marks</th>
                        <th>Obtained Marks</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                      @foreach($assignment as $i=>$row)
                        <td>{{ ++$i }}</td>
                        
                        <td>{{ $row->assignment_title }}</td>
                        <td>{{ $row->created_at }}</td>
                        <td>{{ $row->assignment_total_marks }}</td>
                        <td>{{ $row->assignment_obtained_marks }}</td>
                        
                        
                      </tr>
                      @endforeach
                    </tbody>
                  </table>




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

    
@endsection

