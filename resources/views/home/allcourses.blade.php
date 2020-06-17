@extends('home.allcourse')
@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<h2 style="color:grey; margin:30px;">Find your preferred courses, in your preferred time!</h2>
            <table id="bootstrap-data-table" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Course Cover</th>
                        <th>Course Name</th>
                        <th>Course Teacher</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                      @foreach($courses as $i=>$row)
                        <td>{{ ++$i }}</td>
                        <td>
                            <img class="mt-2 rounded-circle" style="width:100px;height:100px;" src="{{asset('uploads/courses').'/'.$row->c_image}}" alt="Logo">
                        </td>
                        <td>{{ $row->c_name }}</td>
                        <td>{{ $row->c_teacher_name }}</td>
                        <td>
                        <a href="{{ url('dashboard/course/view/'.$row->id) }}" class="btn btn-success">Go to Course</a>
                          
                        </td>
                        
                      </tr>
                      @endforeach
                    </tbody>
                </table>


                



<script src="https://code.jquery.com/jquery-3.5.1.js" ></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" ></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js" ></script>

    <script>
    $(document).ready(function() {
          $('#bootstrap-data-table').DataTable(
          );
        } );
    </script>

@endsection