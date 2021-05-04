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
                <li aria-current="page" class="breadcrumb-item active">New account / Sign in</li>
              </ol>
            </nav>
          </div>
          <div class="col-lg-6">
            <div class="box">
              <h1>New account</h1>
              <p class="lead">Not our registered customer yet?</p>
              <p>With registration with us new world of fashion, fantastic discounts and much more opens to you! The whole process will not take you more than a minute!</p>
              <p class="text-muted">If you have any questions, please feel free to <a href="contact.html">contact us</a>, our customer service center is working for you 24/7.</p>
              <hr>
              @include('include.session_msg')
              <form action="{{url('/register')}}" method="post" id="signupForm">
                @csrf
                <div class="form-group">
                  <label for="reg_first_name">First Name</label>
                  <input id="reg_first_name" name="reg_first_name" type="text" class="form-control">
                </div>
                <div class="form-group">
                  <label for="reg_last_name">Last Name</label>
                  <input id="reg_last_name" name="reg_last_name" type="text" class="form-control">
                </div>
                <div class="form-group">
                  <label for="reg_email">Email</label>
                  <input id="reg_email" name="reg_email" type="text" class="form-control">
                </div>
                <div class="form-group">
                  <label for="reg_password">Password</label>
                  <input id="reg_password" name="reg_password" type="password" class="form-control">
                </div>
                <div class="form-group">
                  <label for="reg_mobile">Mobile</label>
                  <input id="reg_mobile" name="reg_mobile" type="text" class="form-control">
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary"><i class="fa fa-user-md"></i> Register</button>
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
                <div class="form-group">
                    <label>Forget password?<a href="{{url('forget-password')}}"> Click here</a> to recover the password</label>
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