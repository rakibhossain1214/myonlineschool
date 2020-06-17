@extends('home.allcourse')
@section('content')

<div class="container" style="margin-top: 100px;">

  <h2>Teaching Application</h2>
 
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

 {{ Form::open(['url' => 'apply-store', 'method'=>'post', 'enctype'=>'multipart/form-data']) }}
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
      <label for="reason">Why do you want to teach in online?</label>
      <textarea class="form-control" id="reason" name="reason" aria-describedby="reason" placeholder=""></textarea>
    </div>

    <div class="form-group">
      <label for="cv">Upload your resume</label>
      <input type="file" name="cv" class="form-control-file text-primary" id="cv">
    </div>

    <button type="submit" class="btn btn-primary">Apply to Teach</button>
    {{ Form::close() }}
</div>
@endsection