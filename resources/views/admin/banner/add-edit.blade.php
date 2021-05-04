@extends('layouts.admin.layouts')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{$title}}</h1>
          <div class="mt-3">
            @include('include.session_msg')
          </div>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('/admin/banners')}}">Banners</a></li>
            <li class="breadcrumb-item active">{{$title}}</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <form @if (!empty($bannerData->id))
      action="{{url('admin/add-edit-banner',$bannerData->id)}}"
    @else
    action="{{url('admin/add-edit-banner')}}"  
    @endif method="POST" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">General Banner</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="card-body" style="display: block;">
                  <div class="form-group">
                    <label for="bannerName">Banner Title</label>
                    <input type="text" id="bannerName" class="form-control" name="title" placeholder="Enter Banner Title" @if (!empty($bannerData->title))
                      value="{{$bannerData->title}}"  
                    @else
                    value="{{old('title')}}"  
                    @endif>
                  </div>
                  <div class="form-group">
                    <label for="link">Banner Link</label>
                    <input type="text" id="link" class="form-control" name="link" placeholder="Enter Banner Link" @if (!empty($bannerData->link))
                      value="{{$bannerData->link}}"  
                    @else
                    value="{{old('link')}}"  
                    @endif>
                  </div>
                  <div class="form-group">
                    <label for="alt">Banner Alternate Text</label>
                    <input type="text" id="alt" class="form-control" name="alt" placeholder="Enter Banner Alt" @if (!empty($bannerData->alt))
                      value="{{$bannerData->alt}}"  
                    @else
                    value="{{old('alt')}}"  
                    @endif>
                  </div>
                  <div class="form-group">
                    <label for="image">Banner Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" name="image">
                        <label class="custom-file-label" for="image">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">

                @if (isset($bannerData->image))
                <div class="form-group mt-2">
                  <input type="text" style="display:none" value="{{$bannerData->image}}" name="current_img">
                  @php
                            $path=public_path('images/banner/'.$bannerData->image);
                            if (file_exists($path)) {
                              $url=asset('images/banner/'.$bannerData->image);
                            }else {
                              $url=asset('images/demo/banner/'.$bannerData->image);
                            }
                        @endphp
                  <img style="max-width: 100%" src="{{$url}}" alt="{{$bannerData->banner_name}}">  
                </div>
                @endif
              </div>
            </div>
            
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12 text-center">
          <input type="submit" value="{{!empty($bannerData->id)?'Update banner':'Create banner'}}" class="btn btn-info btn-lg w-50 mb-3">
        </div>
      </div>
    </form>
  </section>
  <!-- /.content -->
</div>
@endsection