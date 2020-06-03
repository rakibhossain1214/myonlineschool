@extends('user.layout.coursemaster')
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

                                <hr>

                                <h3>Invoice</h3>
                                <hr>
                                <h4><strong>Course Name:</strong>   {{ $course->c_name }}</h4>
                                <br>
                                <p><strong>Course Time:</strong>  
                                @foreach($schedule as $val)
                                {{ $val }}
                                @endforeach</p>
                                
                                <p><strong>Duration:</strong>  12 weeks (24 x lectures)
                                [2 x classes / week]</p>
                                
                                <h4><strong>Course Fee:</strong> bdt. 15000 only</h4>

                                  <hr>
                                  {{ Form::open(['url' => '/dashboard/course/view/'.$course->id.'/book/', 'method'=>'post', 'enctype'=>'multipart/form-data']) }}
                                      
                                      <div class="form-group">
                                      {{ Form::label('s_name', 'Student Name', ['class' => 'control-label mb-1', 'id' => 's_name']) }}
                                      {{ Form::text('s_name', $user->name, ['class' => 'form-control']) }}
                                      </div>

                                      <div class="form-group">
                                      {{ Form::label('s_email', 'Student Email', ['class' => 'control-label mb-1', 'id' => 's_email']) }}
                                      {{ Form::text('s_email', $user->email, ['class' => 'form-control']) }}
                                      </div>

                                      <div class="form-group">
                                      {{ Form::label('amount', 'Sent Amount', ['class' => 'control-label mb-1', 'id' => 'amount']) }}
                                      {{ Form::number('amount', 15000, ['class' => 'form-control']) }}
                                      </div>

                                      <div class="form-group">
                                      {{ Form::label('instructions', 'Bkash Payment Instructions', ['class' => 'control-label mb-1', 'id' => 'instructions']) }}
                                      </div>
                                      <img src="{{asset('uploads/other/bkash.png')}}" alt="User Avatar">

                                      <div class="form-group">
                                      {{ Form::label('bkash_account', 'Bkash Account', ['class' => 'control-label mb-1', 'id' => 'bkash_account']) }}
                                      {{ Form::text('bkash_account', null, ['class' => 'form-control']) }}
                                      </div>

                                     
                                      <div class="form-group">
                                      {{ Form::label('trx_id', 'Transaction Id', ['class' => 'control-label mb-1', 'id' => 'trx_id']) }}
                                      {{ Form::text('trx_id', null, ['class' => 'form-control']) }}
                                      </div>



                                      <div>
                                          <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                              <i class="fa fa-lock fa-lg"></i>&nbsp;
                                              <span id="payment-button-amount">Confirm Payment</span>
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