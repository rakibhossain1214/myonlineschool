@extends('user.layout.coursemaster')
@section('content')

<div class="row">
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

                                  <hr>
                                  {{ Form::open(['method'=>'PUT',  'url'=>['dashboard/course/view/'.$course->id.'/update-result/'.$student->id.'/store'], 'style'=>'display:inline'])}}

                                    <div class="form-group">
                                      {{ Form::label('s_name', 'Student Name', ['class' => 'control-label mb-1', 'id' => 's_name']) }}
                                      {{ Form::label('s_name', $student->s_name, ['class' => 'form-control']) }}
                                      </div>

                                      <div class="form-group">
                                      {{ Form::label('s_marks', 'Total Marks', ['class' => 'control-label mb-1', 'id' => 's_marks']) }}
                                      {{ Form::number('s_marks', $student->s_marks, ['class' => 'form-control']) }}
                                      </div>

                                      <div class="form-group">
                                      {{ Form::label('s_grade', 'Grade', ['class' => 'control-label mb-1', 'id' => 's_grade']) }}
                                      {{ Form::text('s_grade', $student->s_grade, ['class' => 'form-control']) }}
                                      </div>

                                      

                                      <div>
                                          <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                              <i class="fa fa-lock fa-lg"></i>&nbsp;
                                              <span id="payment-button-amount">Update</span>
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