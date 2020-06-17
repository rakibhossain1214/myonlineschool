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
                        <th>Course Name</th>
                        <th>Student Name</th>
                        <th>Student Email</th>
                        <th>Amount Paid</th>
                        <th>Account No</th>
                        <th>Trx Id</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                      @foreach($checkout as $i=>$row)
                        <td>{{ ++$i }}</td>
                        <td>{{ $row->c_name }}</td>
                        <td>{{ $row->s_name }}</td>
                        <td>{{ $row->s_email }}</td>
                        <td>{{ $row->amount }}</td>
                        <td>{{ $row->bkash_account }}</td>
                        <td>{{ $row->trx_id }}</td>

                        @if($row->order_status == 0)
                        <td>Pending</td>
                        @elseif($row->order_status == 1)
                        <td>Approved</td>
                        @endif
                        <td>

                        
                        
                       
                        {{ Form::open(['method'=>'POST', 'url'=>['/dashboard/course/checkouts/'.$row->id], 'style'=>'display:inline'])}}
                        @if($row->order_status == 0)
                          {{ Form::submit('Approve', ['class' =>'btn btn-primary']) }}
                        @elseif($row->order_status == 1) 
                        {{ Form::submit('Reject', ['class' =>'btn btn-danger']) }} 
                        @endif
                        {{ Form::close() }}
                       
                         
                          {{ Form::open(['method'=>'DELETE', 'url'=>['/dashboard/course/checkouts/'.$row->id.'/delete'], 'style'=>'display:inline'])}}
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

