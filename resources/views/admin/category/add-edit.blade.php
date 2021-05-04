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
            <li class="breadcrumb-item"><a href="{{url('/admin/categories')}}">Categories</a></li>
            <li class="breadcrumb-item active">{{$title}}</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <form @if (!empty($categoryData->id))
      action="{{url('admin/category-add-edit',$categoryData->id)}}"
    @else
    action="{{url('admin/category-add-edit')}}"  
    @endif method="POST" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">General Category</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body" style="display: block;">
              <div class="form-group">
                <label for="categoryName">Category Name</label>
                <input type="text" id="categoryName" class="form-control" name="category_name" placeholder="Enter Category Name" @if (!empty($categoryData->category_name))
                  value="{{$categoryData->category_name}}"  
                @else
                value="{{old('category_name')}}"  
                @endif>
              </div>
              <div class="form-group">
                {{-- @php
                    echo $categoryData->section_id;die;
                @endphp --}}
                <label>Select Section</label>
                <select class="form-control select2" style="width: 100%;" name="section_id" id="section_id">
                  <option selected="selected">Select</option>
                  @foreach ($sections as $section)
                    <option value="{{$section->id}}" @if (isset($categoryData->section_id)&&$categoryData->section_id==$section->id)
                        selected
                    @endif>{{$section->name}}</option>
                  @endforeach
                </select>
              </div>
              <div id="append-category-lavel">
                @include('admin.category.append-category-lavel') 
              </div>
              <div class="form-group">
                <label for="categoryDiscount">Category Discount</label>
                <input type="text" id="categoryDiscount" class="form-control" name="discount" placeholder="Enter Category Discount" @if (!empty($categoryData->discount))
                value="{{$categoryData->discount}}"  
              @else
              value="{{old('discount')}}"  
              @endif>
              </div>
              <div class="form-group">
                <label for="category_image">Categry Image</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="category_image" name="category_image">
                    <label class="custom-file-label" for="category_image">Choose file</label>
                  </div>
                  <div class="input-group-append">
                    <span class="input-group-text">Upload</span>
                  </div>
                </div>
                @if (!empty($categoryData->category_image))
                <div class="form-group mt-2">
                  <label for="categoryDescription">Old Image</label>
                  <input type="hidden" value="{{$categoryData->category_image}}" name="current_img">
                  <img width="100" src="{{asset('images/category/'.$categoryData->category_image)}}" alt="{{$categoryData->category_name}}"> &#8214; 
                  <a class="confirm-delete" href="javascript:valid(0)" record="category-image" recorded="{{$categoryData->id}}">Delete</a>
                </div>
                @endif
              </div>
              <div class="form-group">
                <label for="categoryDescription">Category Description</label>
                <textarea id="categoryDescription" class="form-control" rows="4" name="description" placeholder="Enter Category Description" >@if (!empty($categoryData->description)){{$categoryData->description}}@else{{old('description')}}@endif
              </textarea>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-6">
          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">SEO Category</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="url">Category URL</label>
                <input type="text" getId="{{!empty($categoryData->id)?$categoryData->id:''}}" getPath="category-url" onpaste="setTimeout(checkSlug,1000)" onkeyup="checkSlug()" id="url" class="form-control" name="url" placeholder="Enter URL" @if (!empty($categoryData->url))
                value="{{$categoryData->url}}"  
              @else
              value="{{old('url')}}"  
              @endif>
              <p id="result"></p>
              </div>
              <div class="form-group">
                <label for="meta_title">Meta Title</label>
                <textarea id="meta_title" class="form-control" rows="4" name="meta_title" placeholder="Enter Meta Title">@if (!empty($categoryData->meta_title)){{$categoryData->meta_title}} @else{{old('meta_title')}}@endif
              </textarea>
              </div>
              <div class="form-group">
                <label for="meta_description">Meta Description</label>
                <textarea id="meta_description" class="form-control" rows="4" name="meta_description" placeholder="Enter Meta Description">@if (!empty($categoryData->meta_description)){{$categoryData->meta_description}}@else{{old('meta_description')}}@endif
                </textarea>
              </div>
              <div class="form-group">
                <label for="meta_keyward"> Meta Keyword</label>
                <textarea id="meta_keyward" class="form-control" rows="4" name="meta_keyward" placeholder="Enter Meta Keyword">@if(!empty($categoryData->meta_keyward)){{$categoryData->meta_keyward}}@else{{old('meta_keyward')}}  
                @endif
              </textarea>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12 text-center">
          <input type="submit" value="{{!empty($categoryData->id)?'Update Category':'Create Category'}}" class="btn btn-info btn-lg w-50 mb-3">
        </div>
      </div>
    </form>
  </section>
  <!-- /.content -->
</div>
@endsection