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
                <li class="breadcrumb-item"><a href="{{url('orders')}}">Orders</a></li>
                <li aria-current="page" class="breadcrumb-item active">Order Details</li>
              </ol>
            </nav>
          </div>
          @include('layouts.frontend.customer-sidebar')
          <div id="customer-order" class="col-lg-9">
            <div class="box">
              <h1>Order #{{$orderDetails->id}}</h1>
              <p class="lead">Order #{{$orderDetails->id}} was placed on <strong>{{date('d-m-Y',strtotime($orderDetails->created_at))}}</strong> and current status is  <strong>{{$orderDetails->order_status}}</strong>.</p>
              @if (!empty($orderDetails->courier_name)&&!empty($orderDetails->tracking_number))
              <p>Courier name is <strong>{{$orderDetails->courier_name}}</strong> and Tracking number is <strong>{{$orderDetails->tracking_number}}</strong>.</p> 
              @endif
              <p class="text-muted">If you have any questions, please feel free to <a href="{{url('/contact')}}">contact us</a>, our customer service center is working for you 24/7.</p>
              <hr>
              <div class="table-responsive mb-4">
                <table class="table">
                  <thead>
                    <tr>
                      <th colspan="2">Product</th>
                      <th>Quantity</th>
                      <th>Unit price</th>
                      <th>Discount</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                        $totalPrice=0;
                    @endphp
                    @foreach ($orderDetails->order_products as $product)
                    @php
                        $productData=getProductData($product->product_id,['main_image','url']);
                    @endphp
                      <tr>
                        <td>
                          <a href="{{url('product/'.$productData->url)}}">
                            @php
                              $image_path=public_path('images/product/small/'.$productData->main_image);
                            @endphp
                            @if (!empty($productData->main_image)&&file_exists($image_path))
                            <img src="{{asset('images/product/small/'.$productData->main_image)}}" alt="{{$product->product_name}}" class="img-fluid">
                            @else
                            <img src="{{asset('images/demo/demo-medium.jpeg')}}" alt="{{$product->product_name}}">
                            @endif
                          </a>
                        </td>
                        <td><a href="{{url('product/'.$productData->url)}}">{{$product->product_name}}</a><br><small>Product Code: <strong>{{$product->product_code}}</strong></small> <br><small>Size: <strong>{{$product->product_size}}</strong></small> | <small>color: <strong>{{$product->product_color}}</strong></small></td>
                        <td>{{$product->product_qty}}</td>
                        <td>${{$product->product_unit_price}}</td>
                        <td>${{ $product->product_unit_price-$product->product_discount_price}}*{{$product->product_qty}}=${{($product->product_unit_price-$product->product_discount_price)*$product->product_qty}}</td>
                        <td>${{$product->product_discount_price*$product->product_qty}}</td>
                      </tr>
                      @php
                          $totalPrice=$totalPrice+($product->product_discount_price*$product->product_qty);
                      @endphp
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="5" class="text-right">Order subtotal</th>
                      <th>${{$totalPrice}}</th>
                    </tr>
                    <tr>
                      <th colspan="3">Delivery Method: {{$orderDetails->delivery_method}}
                      <br>
                      @if ($orderDetails->delivery_method=="Local Pickup")
                      Pickup Date and Time: {{date('d-m-Y h:i A',strtotime($orderDetails->delivery_pickup_dateTime))}} 
                      @else
                        Delivery Date: {{date('d-m-Y',strtotime($orderDetails->delivery_pickup_dateTime))}} 
                      @endif
                      </th>
                      <th colspan="2" class="text-right">Delivery Charges (+)</th>
                      <th>${{$orderDetails->delivery_charges}}</th>
                    </tr>
                    <tr>
                      <th colspan="5" class="text-right">Coupon Discount(-)
                        @if (!empty($orderDetails->coupon_code))
                            <br> Coupon Code: <small>{{$orderDetails->coupon_code}}</small>
                        @endif
                      </th>
                      <th>${{!empty($orderDetails->coupon_amount)?$orderDetails->coupon_amount:0}}</th>
                    </tr>
                    <tr>
                      <th colspan="3">Payment Method: {{$orderDetails->payment_method}}</th>
                      <th colspan="2" class="text-right">Total</th>
                      <th>${{$totalPrice-$orderDetails->coupon_amount+$orderDetails->delivery_charges}}</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.table-responsive-->
              <div class="row addresses">
                <div class="col-lg-6">
                  <h2>Billing address</h2>
                  <p>{{$orderDetails->billing_first_name}} {{$orderDetails->billing_last_name}}<br>{{$orderDetails->billing_address_1}} {{$orderDetails->billing_address_2}}<br>{{$orderDetails->billing_state}}<br>{{$orderDetails->billing_city}}<br>{{$orderDetails->billing_pincode}}<br>{{$orderDetails->billing_country}}<br>{{$orderDetails->billing_mobile}}</p>
                </div>
                <div class="col-lg-6">
                  @if ($orderDetails->delivery_method=="Flat Rate")
                    <h2>Shipping address</h2>
                    <p>{{$orderDetails->delivery_first_name}} {{$orderDetails->delivery_last_name}}<br>{{$orderDetails->delivery_address_1}} {{$orderDetails->delivery_address_2}}<br>{{$orderDetails->delivery_state}}<br>{{$orderDetails->delivery_city}}<br>{{$orderDetails->delivery_pincode}}<br>{{$orderDetails->delivery_country}}<br>{{$orderDetails->delivery_mobile}}</p>
                  @else
                    <h2>Local Pickup</h2>
                    <p>Product will collect from the shop</p>
                  @endif

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection