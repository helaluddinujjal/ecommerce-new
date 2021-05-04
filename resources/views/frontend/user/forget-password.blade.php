@extends('layouts.frontend.layouts')
@section('content')
<div id="all">
    <div id="content">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <!-- breadcrumb-->
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('login')}}">Login</a></li>
                <li aria-current="page" class="breadcrumb-item active">Forget Password</li>
              </ol>
            </nav>
          </div>
          <div class="col-lg-6">
            <div class="box">
              <h1>Forget Password</h1>
              <p class="lead">Forget Password?</p>
              <p>Enter your email to get the new password.</p>
              <hr>
              @include('include.session_msg')
              <form action="{{url('/forget-password')}}" method="post" id="forgetPassword">
                @csrf
                <div class="form-group">
                  <label for="email">Email</label>
                  <input id="email" name="email" type="text" class="form-control">
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary"><i class="fa fa-user-md"></i> Send</button>
                </div>
              </form>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="box">
              <h1>Login</h1>
              <p class="lead">Already our customer?</p>
              <p class="text-muted">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
              <hr>
              <form action="{{url('/login')}}" method="post" id="loginForm">
                @csrf
                <div class="form-group">
                    <label for="login_email">Email</label>
                    <input id="login_email" name="login_email" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="login_password">Password</label>
                    <input id="login_password" name="login_password" type="password" class="form-control">
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i> Log in</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('script')
<script src="{{asset('js/frontend/jquery.validate.min.js')}}"></script>
<script src="{{asset('js/frontend/custom.jquery.validate.js')}}"></script>
@endpush