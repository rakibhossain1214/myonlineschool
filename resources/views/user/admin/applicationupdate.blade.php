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
                            <a href="{{ url('dashboard/course/create') }}" class="btn btn-primary pull-right" >Add User</a>
                        </div>
                        <div class="card-body">

                        @if($message = Session::get('success'))
                        <div class="alert alert-success">
                            {{ $message }}
                        </div>
                    @endif

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

                    <form enctype="multipart/form-data" action="{{ url('dashboard/applications/approve/'.$edituser->id.'/store') }}" method="POST">
                            @csrf
                            
                            <h4>Name: <input type="text" class="control-label mb-1" name="name" value="{{ $edituser->name }}"></h4>
                            <h4>Email: <input type="text" class="control-label mb-1" name="email" value="{{ $edituser->email }}"></h4>
                           
                            <hr>
                            <input type="submit" value="Make Teacher" class="mt-1 form-control-file btn btn-sm btn-primary" id="user_update">

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

    
@endsection

