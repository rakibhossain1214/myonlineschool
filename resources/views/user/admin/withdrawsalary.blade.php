@extends('user.layout.master')
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

                                
                        @if($message != null)
                        <div class="alert alert-success">
                            {{ $message }}
                        </div>
                    @endif

                                  <hr>
                                  {{ Form::open(['method'=>'PUT',  'url'=>['dashboard/my-salary/'.$teacher->id.'/store'], 'style'=>'display:inline'])}}

                                   
                                    <h2>Account Balance: {{ $teacher->salary }}</h2>

                                      <div class="form-group">
                                      {{ Form::label('salary', 'Withdrawal Amount', ['class' => 'control-label mb-1', 'id' => 'salary']) }}
                                      {{ Form::number('salary', null, ['class' => 'form-control']) }}
                                      </div>

                                      <div class="form-group">
                                      {{ Form::label('account', 'Account Number', ['class' => 'control-label mb-1', 'id' => 'account']) }}
                                      {{ Form::text('account', null, ['class' => 'form-control']) }}
                                      </div>

                                      <div>
                                          <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                              <i class="fa fa-lock fa-lg"></i>&nbsp;
                                              <span id="payment-button-amount">Withdraw</span>
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