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
                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                @if (isset($productDetails->section->name)&&!empty($productDetails->section->name))
                  <li class="breadcrumb-item"><a href="{{url('/'.$productDetails->section->url)}}">{{$productDetails->section->name}}</a></li>  
                @endif
                @if (isset($productDetails->category->category_name)&&!empty($productDetails->category->category_name))
                  <li class="breadcrumb-item"><a href="{{url('/'.$productDetails->section->url.'/'.$productDetails->category->url)}}">{{$productDetails->category->category_name}}</a></li>  
                  @endif
                  <li class="breadcrumb-item active">{{$productDetails->product_name}}</li>  
              </ol>
            </nav>
            @include('include.session_msg')
          </div>
          {{-- sidebar --}}
          @include('layouts.frontend.sidebar')
          <div class="col-lg-9 order-1 order-lg-2">
            <div id="productMain" class="row">
              <div class="col-md-6">
                <div data-slider-id="1" class="owl-carousel shop-detail-carousel">
                  <div class="item"> 
                    @php
                        $image_path=public_path('images/product/medium/'.$productDetails->main_image);
                    @endphp
                    @if (!empty($productDetails->main_image)&&file_exists($image_path))
                    <img src="{{asset('images/product/medium/'.$productDetails->main_image)}}" alt="{{$productDetails->product_name}}" class="img-fluid">
                    @else
                    <img src="{{asset('images/demo/demo-medium.jpeg')}}" alt="{{$productDetails->product_name}}">
                    @endif
                  </div>
                  @if ($productDetails->images->count()>0)
                  @foreach ($productDetails->images as $image)
                  @php
                        $image_path=public_path('images/product/medium/'.$image->image);
                    @endphp
                    @if (!empty($image->image)&&file_exists($image_path))
                    <div class="item"> <img src="{{asset('images/product/medium/'.$image->image)}}" alt="{{$productDetails->product_name}}" class="img-fluid"></div>
                    @else
                    <div class="item"> <img src="{{asset('images/demo/demo-medium.jpeg')}}" alt="{{$productDetails->product_name}}" class="img-fluid"></div>
                    @endif 
                  @endforeach
                  @endif
                </div>
                @if (!empty($productDetails->brand->name))
                  <div class="ribbon sale">
                    <div class="theribbon">{{$productDetails->brand->name}}</div>
                    <div class="ribbon-background"></div>
                  </div>
                @endif
                @if (App\Product::countProductStock($productDetails->id)<1)
                      <!-- /.ribbon-->
                <div class="ribbon red">
                  <div class="theribbon">Sold</div>
                  <div class="ribbon-background"></div>
                </div>
                <!-- /.ribbon-->
                @endif
              </div>
              <div class="col-md-6">
                <div class="box">
                  <h1 class="text-center">{{$productDetails->product_name}}</h1>
                  <p class="goToDescription"><a href="#details" class="scroll-to">Scroll to product details, material &amp; care and sizing</a></p>
                  <p class="price"><span class="attrPrice">
                    @php
                        $discount_data= App\Product::getDiscountPrice($productDetails->id);
                    @endphp
                    @if ($discount_data['price']>0)
                    <del class="text-danger" id="attr_price">{{settings('site_currency')}}{{$productDetails->product_price}}</del> <span id="dis_price"> {{settings('site_currency')}}{{$discount_data['price']}}</span> <sup><span class="badge badge-info" id="percentage">{{$discount_data['percentage']}}</span></sup>
                    @else
                      <span id="attr_price">{{settings('site_currency')}}{{$productDetails->product_price}}</span>
                    @endif
                  
                  </span></p>
                  <p id="hiddenPrice" class="price" style="display:none">
                    @php
                        $discount_data= App\Product::getDiscountPrice($productDetails->id);
                    @endphp
                    @if ($discount_data>0)
                    <del class="text-danger" id="hidden_attr_price">{{settings('site_currency')}}{{$productDetails->product_price}}</del> <span id="hidden_dis_price">{{settings('site_currency')}}{{$discount_data['price']}}</span><sup><span class="badge badge-info" id="hidden_percentage">{{$discount_data['percentage']}}</span></sup>
                    @else
                      <span id="hidden_attr_price">{{settings('site_currency')}}{{$productDetails->product_price}}</span>
                    @endif
                  </p>
                  <span id="hidden_attr_stock" style="display:none">{{$totalStock}}</span>
                  <p class="text-center"><small class="badge badge-secondary"><b id="attr_stock">{{$totalStock}}</b> Items in stock</small></p>
                  <form action="{{url('add-to-cart')}}" method="Post">
                    @csrf
                    <p>
                      <div class="form-group row">
                        <div class="col-sm-12">
                          <div class="input-group mb-3">
                            <input type="hidden" name="product_id" value="{{$productDetails->id}}">
                            <select id="getSize" name="size" class="form-control" product_id="{{$productDetails->id}}">
                              <option value="">Select Size</option>
                              @if ($productDetails->attributes->count()>0)
                                @foreach ($productDetails->attributes as $attribute)
                                    <option value="{{$attribute->size}}">{{$attribute->size}}</option>
                                @endforeach
                              @endif
                            </select>
                             <input class="form-control ml-1" type="number" name="quantity" id="quantity" value="1">
                           
                          </div>
                         
                        </div>
                        
                      </div>
                    </p>
                    <p class="text-center buttons">
                      <button type="submit" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Add to cart</button><a href="basket.html" class="btn btn-outline-primary"><i class="fa fa-heart"></i> Add to wishlist</a></p>
                  </form>
                  
                </div>
                <div data-slider-id="1" class="owl-thumbs">
                  <button class="owl-thumb-item">
                    @php
                        $image_path=public_path('images/product/small/'.$productDetails->main_image);
                    @endphp
                    @if (!empty($productDetails->main_image)&&file_exists($image_path))
                    <img src="{{asset('images/product/small/'.$productDetails->main_image)}}" alt="{{$productDetails->product_name}}" class="img-fluid">
                    @else
                    <img src="{{asset('images/demo/demo-medium.jpeg')}}" alt="{{$productDetails->product_name}}">
                    @endif
                  </button>
                  @if ($productDetails->images->count()>0)
                  @foreach ($productDetails->images as $image)
                  <button class="owl-thumb-item">
                    @php
                        $image_path=public_path('images/product/small/'.$image->image);
                    @endphp
                      @if (!empty($image->image)&&file_exists($image_path))
                      <img src="{{asset('images/product/small/'.$image->image)}}" alt="{{$productDetails->product_name}}" class="img-fluid">
                      @else
                       <img src="{{asset('images/demo/demo-medium.jpeg')}}" alt="{{$productDetails->product_name}}" class="img-fluid">
                    @endif
                  </button>
                  @endforeach
                  @endif
                </div>
              </div>
            </div>
            
            <ul class="nav nav-tabs details gradient">
              <li class="active"><a data-toggle="tab" class="active nav-link" href="#Details">Details</a></li>
              <li><a class="nav-link" data-toggle="tab" href="#washCare">Wash & Care</a></li>
              <li><a class="nav-link" data-toggle="tab" href="#video">Video</a></li>
            </ul>
            <div id="details" class="box pt-1">
              <div class="tab-content">
                <div id="Details" class="tab-pane fade in active show">
                  <p></p>
                  <h4>Product details</h4>
                  @if (!empty($productDetails->description))
                    <p>{{$productDetails->description}}</p>
                    @else
                    <p>empty</p>
                  @endif
                  <h4>Product Information</h4>
                  <div class="table-responsive text-center">
                    <table class="table table-hover">
                      <thead>
                          <th colspan="2">Product Details</th>
                      </thead>
                      <tbody>
                        @if (!empty($productDetails->brand->name))
                          <tr>
                            <th>Brand</th>
                            <td>{{$productDetails->brand->name}}</td>
                            </tr>
                          <tr>
                        @endif
                        @if (!empty($productDetails->product_code))
                          <tr>
                            <th>Code</th>
                            <td>{{$productDetails->product_code}}</td>
                            </tr>
                          <tr>
                        @endif
                        @if (!empty($productDetails->product_color))
                          <tr>
                            <th>Color</th>
                            <td>{{$productDetails->product_color}}</td>
                            </tr>
                          <tr>
                        @endif
                        @if (!empty($productDetails->product_weight))
                          <tr>
                            <th>Weight</th>
                            <td>
                              <span id="hidden_attr_weight" style="display:none">{{$productDetails->product_weight}}</span>
                              <span id="attr_weight">{{$productDetails->product_weight}}</span></td>
                            </tr>
                          <tr>
                        @endif
                        @if (!empty($productDetails->fabric))
                          <tr>
                            <th>Fabric</th>
                            <td>{{$productDetails->fabric}}</td>
                            </tr>
                          <tr>
                        @endif
                        @if (!empty($productDetails->pattern))
                          <tr>
                            <th>Pattern</th>
                            <td>{{$productDetails->pattern}}</td>
                            </tr>
                          <tr>
                        @endif
                        @if (!empty($productDetails->sleeve))
                          <tr>
                            <th>Sleeve</th>
                            <td>{{$productDetails->sleeve}}</td>
                            </tr>
                          <tr>
                        @endif
                        @if (!empty($productDetails->fit))
                          <tr>
                            <th>Fit</th>
                            <td>{{$productDetails->fit}}</td>
                            </tr>
                          <tr>
                        @endif
                        @if (!empty($productDetails->occation))
                          <tr>
                            <th>Occation</th>
                            <td>{{$productDetails->occation}}</td>
                            </tr>
                          <tr>
                        @endif
                      </tbody>
                    </table>
                  </div>
                </div>
                <div id="washCare" class="tab-pane fade">
                  <p></p>
                  <h4>Wash and Care</h4>
                  @if (!empty($productDetails->wash_care))
                    <p>{{$productDetails->wash_care}}</p>
                  @else
                      <p>empty</p>
                  @endif
                </div>
                <div id="video" class="tab-pane fade">
                  <p></p>
                  <h4>Menu 2</h4>
                  <p>Some content in menu 2.</p>
                </div>
              </div>
             
              <hr>
              <div class="social">
                <h4>Show it to your friends</h4>
                <p><a href="#" class="external facebook"><i class="fa fa-facebook"></i></a><a href="#" class="external gplus"><i class="fa fa-google-plus"></i></a><a href="#" class="external twitter"><i class="fa fa-twitter"></i></a><a href="#" class="email"><i class="fa fa-envelope"></i></a></p>
              </div>
            </div>
            @if ($relatedProducts->count()>0)
              <div class="row same-height-row">
                <div class="col-md-3 col-sm-6">
                  <div class="box same-height">
                    <h3>You may also like these products</h3>
                  </div>
                </div>
                @foreach ($relatedProducts as $relatedPro)
                
                <div class="col-md-3 col-sm-6">
                  <div class="product same-height">
                    <div class="flip-container">
                      <div class="flipper">
                        <div class="front"><a href="{{url('/product/'.$relatedPro->url)}}">
                        @php
                          $image_path=public_path('images/product/small/'.$relatedPro->main_image);
                        @endphp
                        @if (!empty($relatedPro->main_image)&&file_exists($image_path))
                          <img src="{{asset('images/product/small/'.$relatedPro->main_image)}}" alt="{{$relatedPro->product_name}}" class="img-fluid">
                        @else
                          <img src="{{asset('images/demo/demo-small.jpeg')}}" alt="{{$relatedPro->product_name}}" class="img-fluid">
                        @endif
                        </a></div>
                        <div class="back"><a href="{{url('/product/'.$relatedPro->url)}}">
                        @if (!empty($relatedPro->main_image)&&file_exists($image_path))
                          <img src="{{asset('images/product/small/'.$relatedPro->main_image)}}" alt="{{$relatedPro->product_name}}" class="img-fluid">
                        @else
                          <img src="{{asset('images/demo/demo-small.jpeg')}}" alt="{{$relatedPro->product_name}}" class="img-fluid">
                        @endif
                        </a></div>
                      </div>
                    </div>
                    <a href="{{url('/product/'.$relatedPro->url)}}" class="invisible">
                      @if (!empty($relatedPro->main_image)&&file_exists($image_path))
                          <img src="{{asset('images/product/small/'.$relatedPro->main_image)}}" alt="{{$relatedPro->product_name}}" class="img-fluid">
                        @else
                          <img src="{{asset('images/demo/demo-small.jpeg')}}" alt="{{$relatedPro->product_name}}" class="img-fluid">
                        @endif
                    </a>
                    <div class="text">
                      <h3>{{$relatedPro->product_name}}</h3>
                      <p class="price">
                        @php
                            $discount_data= App\Product::getDiscountPrice($relatedPro->id);
                        @endphp
                        @if ($discount_data['price']>0)
                        <sup><span class="badge badge-info">{{$discount_data['percentage']}}</span></sup><del class="text-danger">{{settings('site_currency')}}{{$relatedPro->product_price}}</del> {{settings('site_currency')}}{{$discount_data['price']}}
                        @else
                          {{settings('site_currency')}}{{$productDetails->product_price}}
                        @endif
                      </p>
                    </div>
                    @if (!empty($relatedPro->brand->name))
                        <div class="ribbon sale">
                          <div class="theribbon">{{$relatedPro->brand->name}}</div>
                          <div class="ribbon-background"></div>
                        </div>
                      @endif
                      @if (App\Product::countProductStock($relatedPro->id)<1)
                            <!-- /.ribbon-->
                      <div class="ribbon red">
                        <div class="theribbon">Sold</div>
                        <div class="ribbon-background"></div>
                      </div>
                      <!-- /.ribbon-->
                      @endif
                  </div>
                  <!-- /.product-->
                </div>
                @endforeach
              </div>
            @endif
            @if ($lastProductViews->count()>0)
              <div class="row same-height-row">
                <div class="col-md-3 col-sm-6">
                  <div class="box same-height">
                    <h3>Products viewed recently</h3>
                  </div>
                </div>
                @foreach ($lastProductViews as $proViews) 
                @php
                    $proDetails=App\Product::getProductDetails($proViews->product_id);
                @endphp
                   <div class="col-md-3 col-sm-6">
                    <div class="product same-height">
                      <div class="flip-container">
                        <div class="flipper">
                          <div class="front"><a href="{{$proViews->url}}">
                          @php
                            $image_path=public_path('images/product/small/'.$proDetails->main_image);
                          @endphp
                          @if (!empty($proDetails->main_image)&&file_exists($image_path))
                            <img src="{{asset('images/product/small/'.$proDetails->main_image)}}" alt="{{$proDetails->product_name}}" class="img-fluid">
                          @else
                            <img src="{{asset('images/demo/demo-small.jpeg')}}" alt="{{$proDetails->product_name}}" class="img-fluid">
                          @endif
                          </a></div>
                          <div class="back"><a href="{{$proViews->url}}">
                          @if (!empty($proDetails->main_image)&&file_exists($image_path))
                            <img src="{{asset('images/product/small/'.$proDetails->main_image)}}" alt="{{$proDetails->product_name}}" class="img-fluid">
                          @else
                            <img src="{{asset('images/demo/demo-small.jpeg')}}" alt="{{$proDetails->product_name}}" class="img-fluid">
                          @endif
                          </a></div>
                        </div>
                      </div>
                      <a href="{{$proViews->url}}" class="invisible">
                        @if (!empty($proDetails->main_image)&&file_exists($image_path))
                            <img src="{{asset('images/product/small/'.$proDetails->main_image)}}" alt="{{$proDetails->product_name}}" class="img-fluid">
                          @else
                            <img src="{{asset('images/demo/demo-small.jpeg')}}" alt="{{$proDetails->product_name}}" class="img-fluid">
                          @endif
                      </a>
                      <div class="text">
                        <h3>{{$proDetails->product_name}}</h3>
                        <p class="price">
                          @php
                          $discount_data= App\Product::getDiscountPrice($proDetails->id);
                          @endphp
                          @if ($discount_data['price']>0)
                          <sup><span class="badge badge-info">{{$discount_data['percentage']}}</span></sup><del class="text-danger">{{settings('site_currency')}}{{$proDetails->product_price}}</del> {{settings('site_currency')}}{{$discount_data['price']}}
                          @else
                            {{settings('site_currency')}}{{$proDetails->product_price}}
                          @endif
                        </p>
                      </div>
                      @if (!empty($proDetails->brand->name))
                        <div class="ribbon sale">
                          <div class="theribbon">{{$proDetails->brand->name}}</div>
                          <div class="ribbon-background"></div>
                        </div>
                      @endif
                      @if (App\Product::countProductStock($proDetails->id)<1)
                            <!-- /.ribbon-->
                      <div class="ribbon red">
                        <div class="theribbon">Sold</div>
                        <div class="ribbon-background"></div>
                      </div>
                      <!-- /.ribbon-->
                      @endif
                    </div>
                    <!-- /.product-->
                  </div>
                @endforeach
              </div>
            @endif
          </div>
          <!-- /.col-lg-9-->
        </div>
      </div>
    </div>
  </div>
@endsection