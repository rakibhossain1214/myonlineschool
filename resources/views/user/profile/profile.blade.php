@extends('user.layout.master')
@section('content')

<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>My profile</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Dashboard</a></li>
                            <li class="active">Profile</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

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
                                
                                <h4 class="mt-3"> {{ $user->name }}</h4>
                                <h4 class="mt-3"> <i class="menu-icon fa fa-paper-plane"> </i>{{ $user->email }}</h4>
                                @if($user->type == 2)
                                <h4 class="mt-3"><i class="menu-icon fa fa-user"> </i> Teacher</h4>
                                @elseif($user->type==3 )
                                <h4 class="mt-3">Type: Admin</h4>
                                @else
                                <h4 class="mt-3">Type: Student</h4>
                                @endif

                                <a href="{{ url('dashboard/profile/edit/'.$user->id) }}" class="mt-5 btn btn-primary">Edit Profile</a>

                        </div>
                    </div> <!-- .card -->

                  </div>

@endsection