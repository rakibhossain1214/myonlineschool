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

                                  <hr>
                                  {{ Form::open(['url' => 'dashboard/message/store', 'method'=>'post', 'enctype'=>'multipart/form-data']) }}

                                  <div class="form-group">
                                      {{ Form::label('m_title', 'Message Title', ['class' => 'control-label mb-1', 'id' => 'm_title']) }}
                                      {{ Form::text('m_title', null, ['class' => 'form-control']) }}
                                      </div>

                                      <div class="form-group">
                                      {{ Form::label('users', 'To: ', ['class' => 'control-label mb-1']) }}
                                      {{ Form::select('users[]', $users, null, ['class' => 'form-control myselect', 'data-placeholder' => 'Select Receiver', 'multiple']) }}
                                    </div>

                                      <div class="form-group">
                                      {{ Form::label('m_text', 'Message Text', ['class' => 'control-label mb-1', 'id' => 'm_text']) }}
                                      {{ Form::textarea('m_text', null, ['class' => 'form-control']) }}
                                      </div>


                                      <div>
                                          <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                              <i class="fa fa-lock fa-lg"></i>&nbsp;
                                              <span id="payment-button-amount">Send</span>
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