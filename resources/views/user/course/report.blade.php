@extends('user.layout.coursemaster')
@section('content')

<div class="container" style="margin-top: 100px;">

<h2>Report Page</h2>

                              @if($message != null)
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

{{ Form::open(['url' => 'dashboard/course/view/'.$course->id.'/report/store', 'method'=>'post', 'enctype'=>'multipart/form-data']) }}
@csrf
<div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
  </div>  

  <div class="form-group">
    <label for="email">Email address</label>
    <input type="email" class="form-control" id="email" name="email" aria-describedby="email" value="{{ $user->email }}">
  </div>

  <div class="form-group">
    <label for="reason">What problems are you facing?</label>
    <textarea class="form-control" id="reason" name="reason" aria-describedby="reason" placeholder=""></textarea>
  </div>

  

  <button type="submit" class="btn btn-primary">Repost Now</button>
  {{ Form::close() }}
</div>

@endsection