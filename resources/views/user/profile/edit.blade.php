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

                                  <hr>
                                  {{ Form::model($user, ['route' => ['profile-update', $user->id], 'method'=>'put']) }}
                                      
                                      <div class="form-group">
                                      {{ Form::label('name', 'Update Name', ['class' => 'control-label mb-1', 'id' => 'name']) }}
                                      {{ Form::text('name', null, ['class' => 'form-control']) }}
                                      </div>
                                      <div class="form-group">
                                      {{ Form::label('email', 'Update Email', ['class' => 'control-label mb-1', 'id' => 'email']) }}
                                      {{ Form::text('email', null, ['class' => 'form-control']) }}
                                      </div>
                                      <div class="form-group">
                                      {{ Form::label('password', 'New Password', ['class' => 'control-label mb-1', 'id' => 'password']) }}
                                      {{ Form::password('password', null, ['class' => 'form-control']) }}
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


@endsection