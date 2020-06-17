@extends('user.layout.coursemaster')
@section('content')

    <link rel="stylesheet" href="{{ asset('teacher/assets/css/lib/datatable/dataTables.bootstrap.min.css') }}">

    

<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>{{ $page_name }}</h1>
                    </div>
                </div>
            </div>
            
        </div>


<div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">

                <div class="col-md-12">
                    <div class="card">

                    @if($message != null)
                        <div class="alert alert-success">
                            {{ $message }}
                        </div>
                    @endif
                        
                        <div class="card-body">
                  <table id="bootstrap-data-table" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Total Marks</th>
                        <th>Grade</th>
                        @if($isTeacher == 1 || $user->type == 3)
                        <th>Action</th>
                        @endif
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                      @foreach($students as $i=>$row)
                        <td>{{ ++$i }}</td>
                        <td>{{ $row->s_name }}</td>
                        <td>{{ $row->s_marks }}</td>
                        <td>{{ $row->s_grade }}</td>
                        <td>
                        
                        @if($isTeacher == 1 || $user->type == 3)
                        <a href="{{ url('dashboard/course/view/'.$course->id.'/update-result/'.$row->id) }}" class="btn btn-primary">Edit</a>
                        @endif
                        
                        @if($user->type == 3 )
                        {{ Form::open(['method'=>'DELETE', 'url'=>['/dashboard/course/view/'.$course->id.'/delete-student/'.$row->id], 'style'=>'display:inline'])}}
                          {{ Form::submit('Delete', ['class' =>'btn btn-danger']) }}
                          {{ Form::close() }}
                        @endif
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
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

    

@endsection

