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
                        <th>User Name</th>
                        <th>User Email</th>
                        <th>Course Name</th>
                        <th>Report</th>
                        
                        
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                      @foreach($allreports as $i=>$row)
                        <td>{{ ++$i }}</td>
                        
                        

                        <td>{{ $row->name }}</td>
                        <td>{{ $row->email }}</td>
                        <td>{{ $row->course_name }}</td>
                        <td>{{ $row->report }}</td>

                        
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

