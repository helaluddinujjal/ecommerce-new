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
                  <li class="breadcrumb-item active">Shopping cart</li>  
              </ol>
            </nav>
            @include('include.session_msg')
          </div>
          <div id="basket" class="col-lg-9">
            <div class="box">
              <form method="post" action="checkout1.html">
                <h1>Shopping cart</h1>
                <p class="text-muted">You currently have <span class="totalCartItems">{{totalCartItem()}}</span> item(s) in your cart.</p>
                <div class="table-responsive">
                  <div id="cartItemAppend">
                    @include('frontend.product.ajax_cart_table')
                  </div>
                </div>
                <!-- /.table-responsive-->
                <div class="box-footer d-flex justify-content-between flex-column flex-lg-row">
                  <div class="left"><a href="{{url('/')}}" class="btn btn-outline-secondary"><i class="fa fa-chevron-left"></i> Continue shopping</a></div>
                  <div class="right">
                    <a href="{{url('checkout')}}" type="submit" class="btn btn-primary">Proceed to checkout <i class="fa fa-chevron-right"></i></a>
                  </div>
                </div>
              </form>
            </div>
            <!-- /.box-->
            @if ($relatedProducts->count()>0)
            <div class="row same-height-row">
              <div class="col-lg-3 col-md-6">
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
                        <sup><span class="badge badge-info">{{$discount_data['percentage']}}</span></sup><del class="text-danger">${{$relatedPro->product_price}}</del> ${{$discount_data['price']}}
                        @else
                          ${{$relatedPro->product_price}}
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
          </div>
          <!-- /.col-lg-9-->
          <div class="col-lg-3">
            <div class="order_summery">
              @include('frontend.product.ajax_order_summery')
            </div>
            <div class="box">
              <div class="box-header">
                <h4 class="mb-0">Coupon code</h4>
              </div>
              <p class="text-muted">If you have a coupon code, please enter it in the box below.</p>
              <form id="couponForm" method="post" action="javascript:void(0)" @if (Auth::check())
              user="1"
          @endif >
                <div class="input-group">
                  <input type="text" class="form-control" id="coupon_code"><span class="input-group-append">
                    <button id="couponSubmit" type="submit" class="btn btn-primary"><i class="fa fa-gift"></i></button></span>
                </div>
                <!-- /input-group-->
              </form>
            </div>
          </div>
          <!-- /.col-md-3-->
        </div>
      </div>
    </div>
  </div>
@endsection