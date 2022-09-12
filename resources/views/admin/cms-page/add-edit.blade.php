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
            <li class="breadcrumb-item"><a href="{{url('/admin/cms-pages')}}">Cms Pages</a></li>
            <li class="breadcrumb-item active">{{$title}}</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <form @if (!empty($cmsPageData->id))
      action="{{url('admin/add-edit-cms-page',$cmsPageData->id)}}"
    @else
    action="{{url('admin/add-edit-cms-page')}}"
    @endif method="POST" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">General Cms Page</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body" style="display: block;">
              <div class="form-group">
                <label for="cmsPageName">Page Title</label>
                <input type="text" id="cmsPageName" class="form-control" name="title" placeholder="Enter Page Title" @if (!empty($cmsPageData->title))
                  value="{{$cmsPageData->title}}"
                @else
                value="{{old('name')}}"
                @endif>
              </div>

              <div class="form-group">
                <label for="pageDescription">Description</label>
                <textarea id="pageDescription" class="form-control" name="description" placeholder="Enter Page description" cols="100" rows="30">@if (!empty($cmsPageData->description)){{$cmsPageData->description}}@else{{old('description')}}
                @endif
                </textarea>
              </div>
              <div class="form-group">
                <label for="priority">Priority</label>
                <input type="text" id="priority" class="form-control" name="priority" placeholder="Enter Page Priority" @if (!empty($cmsPageData->priority))
                  value="{{$cmsPageData->priority}}"
                @else
                value="{{old('priority')}}"
                @endif>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-6">
          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">SEO Cms Page</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="cms_url">Page URL</label>
                <input getId="{{!empty($cmsPageData->id)?$cmsPageData->id:''}}" getPath="cms-url" onpaste="setTimeout(checkSlug,1000)" onkeyup="checkSlug()" type="text" id="url" class="form-control" name="url" placeholder="Enter URL" @if (!empty($cmsPageData->url))
                value="{{$cmsPageData->url}}"
              @else
              value="{{old('url')}}"
              @endif>
              <p id="result"></p>
              </div>
              <div class="form-group">
                <label for="meta_title">Meta Title</label>
                <textarea id="meta_title" class="form-control" rows="4" name="meta_title" placeholder="Enter Meta Title">@if(!empty($cmsPageData->meta_title)){{$cmsPageData->meta_title}}@else{{old('meta_title')}}@endif</textarea>
              </div>
              <div class="form-group">
                <label for="meta_description">Meta Description</label>
                <textarea id="meta_description" class="form-control" rows="4" name="meta_description" placeholder="Enter Meta Description">@if (!empty($cmsPageData->meta_description)){{$cmsPageData->meta_description}}@else{{old('meta_description')}}@endif</textarea>
              </div>
              <div class="form-group">
                <label for="meta_keyward"> Meta Keyword</label>
                <textarea id="meta_keyward" class="form-control" rows="4" name="meta_keyward" placeholder="Enter Meta Keyword">@if(!empty($cmsPageData->meta_keyward)){{$cmsPageData->meta_keyward}}@else{{old('meta_keyward')}}@endif</textarea>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12 text-center">
          <input type="submit" value="{{$title}}" class="btn btn-info btn-lg w-50 mb-3">
        </div>
      </div>
    </form>
  </section>
  <!-- /.content -->
</div>
@endsection
