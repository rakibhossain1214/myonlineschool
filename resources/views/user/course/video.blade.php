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
                        
                <div class="row">
                <div class="col">
                        <h2 style="padding:50px;">
                            
                            <a href="skype:{{ $course->c_link }}?call">
                                <img class="mt-2" style="width:50px;height:50px;" src="{{asset('uploads/other/video-call.png')}}" alt="Logo">
                                Start Live Class
                            </a>
                            @if($course->availability == 1)
                            <p class="text-success mt-3">Your teacher is available! Click the button above to start live class now!</p>
                            @else
                            <p class="text-primary mt-3">Your teacher is not available right now! Please wait or come again later!</p>
                            @endif
                        </h2>
                    </div>

                    <div class="col">
                       
                        
                        <h4 style="margin-top:30px; padding:10px;">Status</h4>

                        @if($course->availability == 1)
                        <h3 class="text-success">Online</h3>
                        @elseif($course->availability == 2)
                        <h3 class="text-warning">Away</h3>
                        @elseif($course->availability == 3)
                        <h3 class="text-danger">Busy</h3>
                        @elseif($course->availability == 0)
                        <h3>Offline</h3>
                        @endif

                        @if($user->type==2 || $user->type==3)
                        {{ Form::open(['method'=>'PUT', 'url'=>['dashboard/course/view/'.$course->id.'/update-status'], 'style'=>'display:inline'])}}
                        <h4 style="margin-top:30px; padding:10px;">Select Availability:  
                            <select name="availability" class="form-control selectpicker mt-2" >
                                    <option value="Online" >Online</option>
                                    <option values="Away">Away</option>
                                    <option values="Busy">Busy</option>
                                    <option value="Offline">Offline</option>
                            </select>
                        </h4>
                        
                        <div style="padding:10px;">
                            <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                <i class="fa fa-lock fa-lg"></i>&nbsp;
                                <span id="payment-button-amount">Update</span>
                                <span id="payment-button-sending" style="display:none;">Sending…</span>
                            </button>
                        </div>
                        {{ Form::close() }}
                        @endif
                    </div>
                    

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

