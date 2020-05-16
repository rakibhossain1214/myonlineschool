@extends('teacher.layout.master')
@section('content')

<div class="row">
                  <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">My Notifications</strong>
                        </div>
                        <div class="card-body">

                                
                    @if($message = Session::get('success'))
                        <div class="alert alert-success">
                            {{ $message }}
                        </div>
                    @endif
                    
                   
                    @foreach( $notification as $value )
                        <ul>
                           
                                    @if($value->n_status == 0)
                                    <h4 class="mt-2 text-primary"> {{ $value->notification }}</h4>
                                    @else
                                    <h4 class="mt-2"> {{ $value->notification }}</h4>
                                    @endif
                                    
                                    <p class="mt-2">{{ Carbon\Carbon::parse($value->created_at)->diffForHumans()}}</p>
                        </ul>
                    @endforeach
                   

                                


                        </div>
                    </div> <!-- .card -->

                  </div>
</div>



@endsection