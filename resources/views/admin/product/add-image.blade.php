@extends('layouts.admin.layouts')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Product Images</h1>
          <div class="mt-3">
            @include('include.session_msg')
          </div>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('/admin/products')}}">Product</a></li>
            <li class="breadcrumb-item active">Products Image</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <form  action="{{url('admin/add-image',$productData->id)}}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Product Images</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body" style="display: block;">
              <div class="row">
                <div class="col-md-8">
                  <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                      <b>Product Name</b> <a class="float-right">{{$productData->product_name}}</a>
                    </li>
                    <li class="list-group-item">
                      <b>Product Code</b> <a class="float-right">{{$productData->product_code}}</a>
                    </li>
                    <li class="list-group-item">
                      <b>Product Color</b> <a class="float-right">{{$productData->product_color}}</a>
                    </li>
                    <li class="list-group-item">
                      <b>Product Price</b> <a class="float-right">{{$productData->product_price}}</a>
                    </li>
                  </ul>
                    <div class="field_wrapper">
                      <div class="form-group">
                        <label for="product_image">Product Main Image</label>
                        <span class="info-container"><small class="info">  (Recommanded image size Wedth 1040px,Height 1200px)</small></span>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="images" name="images[]" multiple>
                            <label class="custom-file-label overflow-auto" for="images">Choose file</label>
                          </div>
                          <div class="input-group-append">
                            <span class="input-group-text">Upload</span>
                          </div>
                        </div>
                      </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    @if (!empty($productData->main_image))
                    <div class="form-group mt-2 text-center"> 
                      <img width="200" src="{{asset('images/product/small/'.$productData->main_image)}}" alt="{{$productData->product_name}}"> 
                    </div>
                    @endif
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12 text-center">
          <input type="submit" value="Add Image" class="btn btn-info btn-lg w-50 mb-3">
        </div>
      </div>
    </form>
  </section>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Products Image List</h3>
          <div class="mt-5">
            @include('include.session_msg')
          </div>
        </div>
        <!-- /.card-header -->
        <form action="{{url('admin/edit-image',$productData->id)}}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="card-body">
            <table id="product" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody>
                @foreach ($productData->images as $image)
                  <tr>
                    <td>{{$image->id}}</td>
                    <td><div class="form-group mt-2 text-center"> 
                      <img width="130" src="{{asset('images/product/small/'.$image->image)}}" alt="{{$productData->product_name}}" multiple> 
                    </div></td>
                    <td>
                      <a class="updateStatus" href="javascript:void(0)" id="image-{{$image->id}}" name="image" get_id="{{$image->id}}">
                        @if ($image->status==1)
                        <i title="Click to inactive" class="fa fa-toggle-on fa-2x" aria-hidden="true" status="Active"></i>
                        @else
                        <i title="Click to active" class="fa fa-toggle-off fa-2x" aria-hidden="true" status="Inctive"></i>
                        @endif  
                      </a> 
                    </td>
                    <td>
                      <div class="btn-group" role="group" aria-label="Basic example">
                        <a title="Delete Image" class="btn btn-sm btn-danger confirm-delete" record="image" recorded="{{$image->id}}" href="javascript:void(0)"><i class="fas fa-trash"></i></a>
                      </div>
                    </td>
                  </tr>  
                @endforeach
              </tbody>
            </table>
          </div>
        </form>
      </div>
      <!-- /.card -->
    </div>
  </div>
  <!-- /.content -->
</div>
@endsection