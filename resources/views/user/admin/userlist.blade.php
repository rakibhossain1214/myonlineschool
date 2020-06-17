@extends('user.layout.master')
@section('content')

<link rel="stylesheet" href="{{ asset('teacher/assets/css/lib/datatable/dataTables.bootstrap.min.css') }}">

<div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">

                <div class="col-md-12">
                    <div class="card">

                    
                        <div class="card-header">
                            <strong class="card-title">{{ $page_name }}</strong>
                            <a href="{{ url('dashboard/all-users/add') }}" class="btn btn-primary pull-right" >Add User</a>
                        </div>
                        <div class="card-body">

                        @if($message = Session::get('success'))
                        <div class="alert alert-success">
                            {{ $message }}
                        </div>
                    @endif

                  <table id="bootstrap-data-table" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>User Photo</th>
                        <th>User Name</th>
                        <th>User Email</th>
                        <th>User Type</th>
                        <th>Action</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                      @foreach($allusers as $i=>$row)
                        <td>{{ ++$i }}</td>
                        
                        <td>
                            <img class="mt-2 rounded-circle" style="width:100px;height:100px;" src="{{asset('uploads/avatars').'/'.$row->avatar}}" alt="Logo">
                        </td>

                        <td>{{ $row->name }}</td>
                        <td>{{ $row->email }}</td>

                        @if($row->type == 1)
                          <td>Student</td>
                        @elseif($row->type == 2)
                          <td>Teacher</td>
                        @elseif($row->type == 3)
                          <td>Admin</td>
                        @endif

                         <td>
                         <a href="{{ url('dashboard/all-users/edit/'.$row->id) }}" class="btn btn-primary">Edit</a>
                          {{ Form::open(['method'=>'DELETE', 'url'=>['/dashboard/all-users/'.$row->id.'/delete'], 'style'=>'display:inline'])}}
                          {{ Form::submit('Delete', ['class' =>'btn btn-danger']) }}
                          {{ Form::close() }}
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

    <script>
    $(document).ready(function() {
          $('#bootstrap-data-table-export').DataTable(
            {
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            }
          );
        } );
    </script>
@endsection

