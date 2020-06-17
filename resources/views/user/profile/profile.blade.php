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
                                
                                <label class="control-label mb-1 mt-3"> Name </label>
                                <h4 class="control-label mb-1"> {{ $user->name }}</h4>
                                <label class="control-label mb-1 mt-3"> <i class="menu-icon fa fa-paper-plane"> </i>Email </label>
                                <h4> {{ $user->email }}</h4>
                                <label class="control-label mb-1 mt-3"><i class="menu-icon fa fa-user"> </i> Type </label>
                                @if($user->type == 2)
                                <h4> Teacher</h4>
                                @elseif($user->type==3 )
                                <h4>Type: Admin</h4>
                                @else
                                <h4>Type: Student</h4>
                                @endif

                                <a href="{{ url('dashboard/profile/edit/'.$user->id) }}" class="mt-5 btn btn-primary">Edit Profile</a>

                        </div>
                    </div> <!-- .card -->

                  </div>

@endsection