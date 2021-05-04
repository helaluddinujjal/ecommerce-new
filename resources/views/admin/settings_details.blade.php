@extends('layouts.admin.layouts')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Admin Details</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Settings</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Update Admin Details</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              @include('include.session_msg')
              <form action="{{url('admin/update-details')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Admin Email</label>
                    <input type="email" readonly class="form-control" value="{{$adminDetails->email}}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Admin Type</label>
                    <input type="text" readonly class="form-control" value="{{$adminDetails->type}}">
                  </div>
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" name="name"  type="text" class="form-control" value="{{$adminDetails->name}}">
                  </div>
                  <div class="form-group">
                    <label for="mobile">Mobile</label>
                    <input id="mobile" name="mobile" type="text" class="form-control" value="{{$adminDetails->mobile}}">
                  </div>
                  <div class="form-group">
                    <label for="image">Image</label>
                    <input id="image" name="image" type="file">
                    @if (!empty(Auth::guard('admin')->user()->image))
                        <a target="_blank" href="{{asset('images/admin/profile/'.Auth::guard('admin')->user()->image)}}">View Image</a>
                        <input type="hidden" value="{{Auth::guard('admin')->user()->image}}" name="current_image">
                    @endif
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
       
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection