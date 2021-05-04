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
            <li class="breadcrumb-item"><a href="{{url('/admin/products')}}">Products</a></li>
            <li class="breadcrumb-item active">{{$title}}</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <form @if (!empty($productData->id))
      action="{{url('admin/add-edit-product',$productData->id)}}"
    @else
    action="{{url('admin/add-edit-product')}}"  
    @endif method="POST" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">General Product</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body" style="display: block;">
              <div class="row">
                <div class="col-md-6">
                  {{-- <div id="append-product-lavel">
                    @include('admin.product.append-product-lavel')
                  </div> --}}
                  <div class="form-group">
                    <label for="productName">Product Name</label>
                    <input type="text" id="productName" class="form-control" name="product_name" placeholder="Enter product Name" @if (!empty($productData->product_name))
                      value="{{$productData->product_name}}"  
                    @else
                    value="{{old('product_name')}}"  
                    @endif>
                  </div>
                  <div class="form-group">
                    <label for="productCode">Product Code</label>
                    <input type="text" getId="{{!empty($productData->id)?$productData->id:''}}" getPath="product-code" onpaste="setTimeout(checkCode,1000)" onkeyup="checkCode()" id="productCode" class="form-control codeCheck" name="product_code" placeholder="Enter Product Code" @if (!empty($productData->product_code))
                      value="{{$productData->product_code}}"  
                    @else
                    value="{{old('product_code')}}"  
                    @endif>
                    <p id="codeResult"></p>
                  </div>
                  <div class="form-group">
                    <label for="productColor">Product Color</label>
                    <input type="text" id="productColor" class="form-control" name="product_color" placeholder="Enter Product Color" @if (!empty($productData->product_color))
                      value="{{$productData->product_color}}"  
                    @else
                    value="{{old('product_color')}}"  
                    @endif>
                  </div>
                  <div class="form-group">
                    <label for="productWeight">Product Weight</label>
                    <input type="text" id="productWeight" class="form-control" name="product_weight" placeholder="Enter Product Weight" @if (!empty($productData->product_weight))
                      value="{{$productData->product_weight}}"  
                    @else
                    value="{{old('product_weight')}}"  
                    @endif>
                  </div>
                 
                  <div class="form-group">
                    <label for="productPrice">Product Price</label>
                    <input type="text" id="productPrice" class="form-control" name="product_price" placeholder="Enter Product Price" @if (!empty($productData->product_price))
                    value="{{$productData->product_price}}"  
                  @else
                  value="{{old('product_price')}}"  
                  @endif>
                  </div>
                  <div class="form-group">
                    <label for="productDiscount">Product Discount(%)</label>
                    <input type="text" id="productDiscount" class="form-control" name="product_discount" placeholder="Enter product Discount" @if (!empty($productData->product_discount))
                    value="{{$productData->product_discount}}"  
                  @else
                  value="{{old('product_discount')}}"  
                  @endif>
                  </div>
                  <div class="form-group">
                    <label for="productDescription">Product Description</label>
                    <textarea id="productDescription" class="form-control" rows="4" name="description" placeholder="Enter product Description" >@if (!empty($productData->description)){{$productData->description}}@else{{old('description')}}@endif
                  </textarea>
                  </div>
                  <div class="form-group">
                    <label for="washCare">Wash Care</label>
                    <textarea id="washCare" class="form-control" rows="4" name="wash_care" placeholder="Enter Wash Care" >@if (!empty($productData->wash_care)){{$productData->wash_care}}@else{{old('wash_care')}}@endif
                  </textarea>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Select Section</label>
                    <select class="form-control select2" style="width: 100%;" name="section_id" id="section_id">
                      <option selected="selected" value="">Select Section</option>
                      @foreach ($categories as $section)
                        <option value="{{$section->id}}" @if (!empty(old('section_id'))&&$section==old('section_id'))
                          selected=""
                        @elseif (isset($productData->section_id)&&$productData->section_id==$section->id)
                            selected
                        @endif>{{$section->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Select Category</label>
                    <select class="form-control select2" style="width: 100%;" name="category_id" id="category_id">
                      <option value="" selected>Select Category</option>
                        @foreach ($categories as $section)
                          <optgroup label="{{$section->name}}""></optgroup>
                            @foreach ($section->categories as $parentCat)
                              <option 
                              value="{{$parentCat->id}}"
                              @if (!empty(old('category_id'))&&$parentCat->id==old('category_id'))
                                selected=""
                                @elseif(!empty($productData->category_id)&&$productData->category_id==$parentCat->id)selected=""
                              @endif>&#10146;&#10146;{{$parentCat->category_name}}</option>
                              @foreach ($parentCat->childcategories as $childCat)
                                <option value="{{$childCat->id}}""
                                  @if (!empty(old('category_id'))&&$childCat->id==old('category_id'))
                                selected=""
                                @elseif(!empty($productData->category_id)&&$productData->category_id==$childCat->id)selected=""
                              @endif
                                  >&emsp;&emsp;&#10551; {{$childCat->category_name}}</option>
                              @endforeach
                            @endforeach
                        @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Select Brand</label>
                    <select class="form-control select2" style="width: 100%;" name="brand" id="brand_id">
                      <option selected="selected" value="0">Select Brand</option>
                      @foreach ($brands as $brand)
                        <option value="{{$brand->id}}" @if (!empty(old('brand'))&&$brand==old('brand'))
                          selected=""
                        @elseif (isset($productData->brand_id)&&$productData->brand_id==$brand->id)
                            selected
                        @endif>{{$brand->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  @if (!empty($fabricArray))
                  <div class="form-group">
                    <label>Select Fabric</label>
                    <select class="form-control select2" style="width: 100%;" name="fabric" id="fabric">
                      <option selected="selected" value="">Select Fabric</option>
                      @foreach ($fabricArray as $fabric)
                        <option value="{{$fabric->name}}" @if (!empty(old('fabric'))&&$fabric==old('fabric'))
                          selected=""
                        @elseif (isset($productData->fabric)&&$productData->fabric==$fabric->name)
                            selected
                        @endif>{{$fabric->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  @endif
                  @if (!empty($patternArray))
                  <div class="form-group">
                    <label>Select Pattern</label>
                    <select class="form-control select2" style="width: 100%;" name="pattern" id="pattern">
                      <option selected="selected" value="">Select Pattern</option>
                      @foreach ($patternArray as $pattern)
                        <option value="{{$pattern->name}}" @if (!empty(old('pattern'))&&$pattern==old('pattern'))
                          selected=""
                          @elseif (isset($productData->pattern)&&$productData->pattern==$pattern->name)
                            selected
                        @endif>{{$pattern->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  @endif
                  @if (!empty($sleeveArray))
                  <div class="form-group">
                    <label>Select Sleeve</label>
                    <select class="form-control select2" style="width: 100%;" name="sleeve" id="sleeve">
                      <option selected="selected" value="">Select sleeve</option>
                      @foreach ($sleeveArray as $sleeve)
                        <option value="{{$sleeve->name}}" @if (!empty(old('sleeve'))&&$sleeve->name==old('sleeve'))
                        selected=""
                        @elseif (isset($productData->sleeve)&&$productData->sleeve==$sleeve->name)
                            selected
                      @endif>{{$sleeve->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  @endif
                  @if (!empty($fitArray))
                  <div class="form-group">
                    <label>Select Fit</label>
                    <select class="form-control select2" style="width: 100%;" name="fit" id="fit">
                      <option selected="selected" value="">Select fit</option>
                      @foreach ($fitArray as $fit)
                        <option value="{{$fit->name}}" @if (!empty(old('fit'))&&$fit->name==old('fit'))
                        selected=""
                        @elseif(isset($productData->fit)&&$productData->fit==$fit->name)
                        selected
                      @endif>{{$fit->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  @endif
                  @if (!empty($occationArray))
                  <div class="form-group">
                    <label>Select Occation</label>
                    <select class="form-control select2" style="width: 100%;" name="occation" id="occation">
                      <option selected="selected" value="">Select occation</option>
                      @foreach ($occationArray as $occation)
                        <option value="{{$occation->name}}" @if (!empty(old('occation'))&&$occation->name==old('occation'))
                        selected=""
                        @elseif (isset($productData->occation)&&$productData->occation==$occation->name)
                            selected
                      @endif>{{$occation->name}}</option>
                      @endforeach
                    </select>
                  </div> 
                  @endif
                  
                  <div class="form-group clearfix">
                    <div class="icheck-primary d-inline">
                      <input type="checkbox" value="1"  id="is_featured" name="is_featured" id="is_featured" @if (isset($productData->is_featured)&&$productData->is_featured=="Yes")
                      checked
                      @endif @if (old('is_featured'))
                      checked
                      @endif>
                      <label for="is_featured">Featured Item
                    </label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="product_image">Product Main Image</label>
                    <span class="info-container"><small class="info">  (Recommanded image size Wedth 1040px,Height 1200px)</small></span>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="main_image" name="main_image">
                        <label class="custom-file-label" for="main_image">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                      </div>
                    </div>
                    @if (!empty($productData->main_image))
                    <div class="form-group mt-2">
                      <label for="productDescription">Old Image</label>
                      <img width="100" src="{{asset('images/product/small/'.$productData->main_image)}}" alt="{{$productData->product_name}}"> &#8214; 
                      <a class="confirm-delete" href="javascript:valid(0)" record="product-image" recorded="{{$productData->id}}">Delete</a>
                    </div>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="product_video">Product Video</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="product_video" name="product_video">
                        <label class="custom-file-label" for="product_video">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                      </div>
                    </div>
                    @if (!empty($productData->product_video))
                    <div class="form-group mt-2">
                      <label for="productDescription">Old Video</label>
                      <!-- 4:3 aspect ratio -->
                        <div class="embed-responsive embed-responsive-4by3">
                          <iframe class="embed-responsive-item" src="{{asset('videos/product/'.$productData->product_video)}}" title="{{$productData->product_name}}"></iframe>
                        </div>
                      </iframe> &#8214; 
                      <a class="confirm-delete" href="javascript:valid(0)" record="product-video" recorded="{{$productData->id}}">Delete</a>
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
        <div class="col-md-6">
          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">SEO Product</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="url">Product URL</label>
                <input type="text" getId="{{!empty($productData->id)?$productData->id:''}}" getPath="product-url" onpaste="setTimeout(checkSlug,1000)" onkeyup="checkSlug()" id="url" class="form-control" name="url" placeholder="Enter URL" @if (!empty($productData->url))
                value="{{$productData->url}}"  
              @else
              value="{{old('url')}}"  
              @endif>
              <p id="result"></p>
              </div>
              <div class="form-group">
                <label for="meta_title">Meta Title</label>
                <textarea id="meta_title" class="form-control" rows="4" name="meta_title" placeholder="Enter Meta Title">@if (!empty($productData->meta_title)){{$productData->meta_title}} @else{{old('meta_title')}}@endif
              </textarea>
              </div>
              <div class="form-group">
                <label for="meta_description">Meta Description</label>
                <textarea id="meta_description" class="form-control" rows="4" name="meta_description" placeholder="Enter Meta Description">@if (!empty($productData->meta_description)){{$productData->meta_description}}@else{{old('meta_description')}}@endif
                </textarea>
              </div>
              <div class="form-group">
                <label for="meta_keyword"> Meta Keyword</label>
                <textarea id="meta_keyword" class="form-control" rows="4" name="meta_keyword" placeholder="Enter Meta Keyword">@if(!empty($productData->meta_keyword)){{$productData->meta_keyword}}@else{{old('meta_keyword')}}  
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
          <input type="submit" value="{{!empty($productData->id)?'Update Product':'Create Product'}}" class="btn btn-info btn-lg w-50 mb-3">
        </div>
      </div>
    </form>
  </section>
  <!-- /.content -->
</div>
@endsection