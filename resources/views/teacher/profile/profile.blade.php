@extends('teacher.layout.master')
@section('content')

<div class="row">
                  <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">You can update your Profile</strong>
                        </div>
                        <div class="card-body">

                                
                    @if($message = Session::get('success'))
                        <div class="alert alert-success">
                            {{ $message }}
                        </div>
                    @endif

                                <h3 class="mt-2"> {{ $user->name }}</h3>
                                <h4 class="mt-2"> <i class="menu-icon fa fa-paper-plane"> </i>{{ $user->email }}</h4>
                                @if($user->type == 2)
                                <h4 class="mt-2"><i class="menu-icon fa fa-user"> </i> Teacher</h4>
                                @elseif($user->type==3 )
                                <h4 class="mt-2">Type: Admin</h4>
                                @else
                                <h4 class="mt-2">Type: Student</h4>
                                @endif

                                <a href="{{ url('dashboard/profile/edit/'.$user->id) }}" class="mt-2 btn btn-primary">Edit Profile</a>

                        </div>
                    </div> <!-- .card -->

                  </div>
</div>

@endsection