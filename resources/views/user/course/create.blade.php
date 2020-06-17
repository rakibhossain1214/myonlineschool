@extends('user.layout.master')
@section('content')

                  <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">{{ $page_name }}</strong>
                        </div>
                        <div class="card-body">
                          <!-- Credit Card -->
                          <div id="pay-invoice">
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


                                @if($message = Session::get('success'))
                                    <div class="alert alert-danger">
                                        {{ $message }}
                                    </div>
                                @endif

                                  <hr>
                                  {{ Form::open(['url' => 'dashboard/course/store', 'method'=>'post', 'enctype'=>'multipart/form-data']) }}
                                      
                                      <div class="form-group">
                                      {{ Form::label('c_name', 'Course Name', ['class' => 'control-label mb-1', 'id' => 'c_name']) }}
                                      {{ Form::text('c_name', null, ['class' => 'form-control']) }}
                                      </div>

                                      <div class="form-group">
                                      {{ Form::label('c_curriculum', 'Course Curriculum', ['class' => 'control-label mb-1', 'id' => 'c_curriculum']) }}
                                      {{ Form::textarea('c_curriculum', null, ['class' => 'form-control']) }}
                                      </div>

                                      <div class="form-group">
                                      {{ Form::label('c_link', 'Video Call Link', ['class' => 'control-label mb-1', 'id' => 'c_link']) }}
                                      {{ Form::text('c_link', null, ['class' => 'form-control']) }}
                                      </div>

                                      <div class="form-group">
                                        <input type="file" name="c_image" class="form-control-file text-primary" id="course-pic">
                                    </div>

                                    <div class="form-group">
                                      {{ Form::label('schedule', 'Select Schedule', ['class' => 'control-label mb-1']) }}
                                      {{ Form::select('schedule[]', $schedule, null, ['class' => 'form-control myselect', 'data-placeholder' => 'Select Schedules', 'multiple']) }}
                                    </div>

                                    <div class="form-group">
                                        <label for="start_date">Course Start Date</label>
                                        <input type="date" name="start_date" id="start_date">
                                    </div>

                                    <div class="form-group">
                                        <label for="end_date">Course End Date</label>
                                        <input type="date" name="end_date" id="end_date">
                                    </div>

                                    @if($user->type==3)
                                    <div class="form-group">
                                      {{ Form::label('teacher', 'Select Teacher', ['class' => 'control-label mb-1']) }}
                                      {{ Form::select('teacher[]', $teacher, null, ['class' => 'form-control myselect', 'data-placeholder' => 'Select Teacher', 'multiple']) }}
                                    </div>
                                    @endif

                                      <div>
                                          <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                              <i class="fa fa-lock fa-lg"></i>&nbsp;
                                              <span id="payment-button-amount">Create</span>
                                              <span id="payment-button-sending" style="display:none;">Sending…</span>
                                          </button>
                                      </div>
                                      {{ Form::close() }}
                              </div>
                          </div>

                        </div>
                    </div> <!-- .card -->

                  </div><!--/.col-->



@endsection