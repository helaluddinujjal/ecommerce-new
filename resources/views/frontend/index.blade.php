@extends('layouts.frontend.layouts')
@section('content')
<div id="all">
    <div id="content">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div id="main-slider" class="owl-carousel owl-theme">
              @foreach ($banners as $banner)
                     @php
                            $path=public_path('images/banner/'.$banner->image);
                            if (file_exists($path)) {
                              $url=asset('images/banner/'.$banner->image);
                            }else {
                              $url=asset('images/demo/banner/'.$banner->image);
                            }
                        @endphp
                <div class="item">
                 <a href="{{!empty($banner->link)?$banner->link:'javascript:voied'}}" title="{{!empty($banner->title)?$banner->title:''}}">
                    <img src="{{$url}}" alt="{{!empty($banner->alt)?$banner->alt:''}}" class="img-fluid">
                  </a>
                </div>   
              @endforeach
            </div>
            <!-- /#main-slider-->
          </div>
        </div>
      </div>
      <!--
      *** ADVANTAGES HOMEPAGE ***
      _________________________________________________________
      -->
      <div id="advantages">
        <div class="container">
          <div class="row mb-4">
            <div class="col-md-4">
              <div class="box clickable d-flex flex-column justify-content-center mb-0 h-100">
                <div class="icon"><i class="fa fa-heart"></i></div>
                <h3><a href="#">We love our customers</a></h3>
                <p class="mb-0">We are known to provide best possible service ever</p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="box clickable d-flex flex-column justify-content-center mb-0 h-100">
                <div class="icon"><i class="fa fa-tags"></i></div>
                <h3><a href="#">Best prices</a></h3>
                <p class="mb-0">You can check that the height of the boxes adjust when longer text like this one is used in one of them.</p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="box clickable d-flex flex-column justify-content-center mb-0 h-100">
                <div class="icon"><i class="fa fa-thumbs-up"></i></div>
                <h3><a href="#">100% satisfaction guaranteed</a></h3>
                <p class="mb-0">Free returns on everything for 3 months.</p>
              </div>
            </div>
          </div>
          <!-- /.row-->
        </div>
        <!-- /.container-->
      </div>
      <!-- /#advantages-->
      <!-- *** ADVANTAGES END ***-->
      <!--
      *** HOT PRODUCT SLIDESHOW ***
      _________________________________________________________
      -->
      <div id="hot">
        <div class="box py-4">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <h2 class="mb-0">Featured Product</h2>
              </div>
            </div>
          </div>
        </div>
        <div class="container">
          <div class="product-slider owl-carousel owl-theme">
            @foreach ($featuredData as $feature)
                @php
                    $path=public_path('images/product/small/'.$feature->main_image);
                @endphp
              <div class="item">
                <div class="product">
                  <div class="flip-container">
                    <div class="flipper">
                      <div class="front"><a href="{{url('/product/'.$feature->url)}}"><img src="{{!empty($feature->main_image)&& file_exists($path)?asset('images/product/small/'.$feature->main_image):asset('images/demo/demo-small.png')}}" alt="{{$feature->product_name}}" class="img-fluid"></a></div>
                      <div class="back"><a href="{{url('/product/'.$feature->url)}}"><img src="{{!empty($feature->main_image)&& file_exists($path)?asset('images/product/small/'.$feature->main_image):asset('images/demo/demo-small.png')}}" alt="{{$feature->product_name}}" class="img-fluid"></a></div>
                    </div>
                  </div>
                  <a href="{{url('/product/'.$feature->url)}}" class="invisible"><img src="{{!empty($feature->main_image)&& file_exists($path)?asset('images/product/small/'.$feature->main_image):asset('images/demo/demo-small.png')}}" alt="{{$feature->product_name}}" class="img-fluid"></a>
                  <div class="text">
                    <h3><a href="{{url('/product/'.$feature->url)}}">{{$feature->product_name}}</a></h3>
                    <p class="price"> 
                      @php
                         $discount_data= App\Product::getDiscountPrice($feature->id);
                      @endphp
                      @if ($discount_data['price']>0)
                      <sup><span class="badge badge-info">{{$discount_data['percentage']}}</span></sup><del class="text-danger">{{settings('site_currency')}}{{$feature['product_price']}}</del> {{settings('site_currency')}}{{$discount_data['price']}}
                      @else
                      {{settings('site_currency')}}{{$feature->product_price}}
                      @endif
                    </p>
                  </div>
                  @if (!empty($feature->brand->name))
                    <div class="ribbon sale">
                      <div class="theribbon">{{$feature->brand->name}}</div>
                      <div class="ribbon-background"></div>
                    </div> 
                   @endif
                   @if (App\Product::countProductStock($feature->id)<1)
                    <div class="ribbon red">
                      <div class="theribbon">Sold</div>
                      <div class="ribbon-background"></div>
                    </div> 
                   @endif
                </div>
                <!-- /.product-->
              </div>
            @endforeach
            <!-- /.product-slider-->
          </div>
          <!-- /.container-->
        </div>
        <!-- /#hot-->
        <!-- *** HOT END ***-->
      </div>
      <!--
      *** LATTEST PRODUCT ***
      _________________________________________________________
      -->
      <div class="heading">
        <div class="box py-4">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <h2 class="mb-0 title">Latest Products</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="lattest-product">
        <div id="content">
          <div class="container">
            <div class="row">                       
              <div class="col-lg-12">
                <div class="row products" id="show_product">
                  @include('frontend.product.ajax_home_latest_product')
                </div>
                  <!-- /.products-->
                  
              </div>
              
              <!-- /.col-lg-9-->
            </div>
          </div>
        </div>
    </div>
      <!-- /.latest product end-->
    </div>
  </div>
@endsection