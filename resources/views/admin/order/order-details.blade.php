@extends('layouts.admin.layouts')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Catalogues</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('/admin/orders')}}">Orders</a></li>
            <li class="breadcrumb-item active">Orders Details</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  @include('include.session_msg')
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Order #{{$orderDetails->id}} Details</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-bordered">
                <tbody>
                  <tr>
                    <th>Order Date</th>
                    <td>{{date('d-m-Y',strtotime($orderDetails->created_at))}}</td>
                  </tr>
                  <tr>
                    <th>Order Status</th>
                    <td>{{$orderDetails->order_status}}</td>
                  </tr>
                  <tr>
                    <th>Total</th>
                    <td>{{$orderDetails->total}}</td>
                  </tr>
                  <tr>
                    <th>Coupon Code</th>
                    <td>{{$orderDetails->coupon_code}}</td>
                  </tr>
                  <tr>
                    <th>Coupon Amount</th>
                    <td>{{$orderDetails->coupon_amount}}</td>
                  </tr>
                  <tr>
                    <th>Delivery Method</th>
                    <td>{{$orderDetails->delivery_method}}</td>
                  </tr>
                  <tr>
                    @if ($orderDetails->delivery_method=="Local Pickup")
                      <th>Pickup Date and Time:</th> 
                      <td>{{date('d-m-Y h:i A',strtotime($orderDetails->delivery_pickup_dateTime))}} </td>
                    @else
                        <th>
                          Delivery Date: 
                        </th>
                        <td>
                          {{date('d-m-Y',strtotime($orderDetails->delivery_pickup_dateTime))}}
                        </td> 
                    @endif
                  </tr>
                  <tr>
                    <th>Delivery Charges</th>
                    <td>{{$orderDetails->delivery_charges}}</td>
                  </tr>
                  <tr>
                    <th>Payment Method</th>
                    <td>{{$orderDetails->payment_method}}</td>
                  </tr>
                  <tr>
                    <th>Payment Getway</th>
                    <td>{{$orderDetails->payment_gateway}}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Customer Details</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-bordered">
                <tbody>
                  <tr>
                    <th>Name</th>
                    <td>{{$orderDetails->user->first_name}} {{$orderDetails->user->last_name}}</td>
                  </tr>
                  <tr>
                    <th>Email</th>
                    <td>{{$orderDetails->user->email}}</td>
                  </tr>
                  <tr>
                    <th>Mobile</th>
                    <td>{{$orderDetails->user->mobile}}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Update Order Status</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <form action="{{url('admin/order-status-update')}}" method="POST">
                @csrf
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <tbody>
                      <tr>
                        <th>
                          <input type="hidden" name="order_id" value="{{$orderDetails->id}}">
                          <select name="order_status" id="add_order_status_field" class="form-control">
                            <option value="tes">Choose a status</option>
                            @foreach ($orderStatus as $status)
                              <option value="{{$status->id}}" @if(isset($orderDetails->order_status)&&$orderDetails->order_status==$status->name)
                                  selected="selected"
                              @endif>{{$status->name}}</option>
                            @endforeach
                          </select>
                        </th>
                        <th @if (empty($orderDetails->courier_name)) class="shipped_field" style="display:none"
                        @endif><input type="text" class="form-control" placeholder="Courier Name" name="courier_name" value="{{!empty($orderDetails->courier_name)?$orderDetails->courier_name:''}}"></th>
                        <th @if (empty($orderDetails->tracking_number)) class="shipped_field" 
                          style="display:none"
                        @endif><input type="text" class="form-control" placeholder="Tracking Number" name="tracking_number" value="{{!empty($orderDetails->tracking_number)?$orderDetails->tracking_number:''}}"></th>
                        <th><button type="submit" class="btn btn-info btn-block">Update</button></th>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </form>
              @if ($orderStatusLogs->count()>0)
                <h4>Order Status Logs</h4>
                @foreach ($orderStatusLogs as $logs)
               
                <strong>{{$logs->order_status}}</strong><br>
                {{date("j F,Y H:i:s",strtotime($logs->created_at))}}<br>
                @endforeach 
              @endif

            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Product Details</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive-sm">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Image</th>
                    <th>Product Name</th>
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
                          <img src="{{asset('images/product/small/'.$productData->main_image)}}" alt="{{$product->product_name}}" class="img-fluid" width="100">
                          @else
                          <img src="{{asset('images/demo/demo-medium.jpeg')}}" alt="{{$product->product_name}}" width="100">
                          @endif
                        </a>
                      </td>
                      <td><a href="{{url('product/'.$productData->url)}}">{{$product->product_name}}</a><br><small>Product Code: <strong>{{$product->product_code}}</strong></small> <br><small>Size: <strong>{{$product->product_size}}</strong></small> | <small>color: <strong>{{$product->product_color}}</strong></small></td>
                      <td>{{$product->product_qty}}</td>
                      <td>${{$product->product_unit_price}}</td>
                      <td>${{ $product->product_unit_price-$product->product_discount_price}}*{{$product->product_qty}}=${{($product->product_unit_price-$product->product_discount_price)*$product->product_qty}}</td>
                      <td>${{$product->product_discount_price}}</td>
                    </tr>
                    @php
                        $totalPrice=$totalPrice+$product->product_discount_price;
                    @endphp
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
        <!-- /.row -->
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Billing Address</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <th>First Name</th>
                      <td>{{$orderDetails->billing_first_name}}</td>
                    </tr>
                    <tr>
                      <th>Last Name</th>
                      <td>{{$orderDetails->billing_last_name}}</td>
                    </tr>
                    <tr>
                      <th>Address 1</th>
                      <td>{{$orderDetails->billing_address_1}}</td>
                    </tr>
                    <tr>
                      <th>Address 2</th>
                      <td>{{$orderDetails->billing_address_2}}</td>
                    </tr>
                    <tr>
                      <th>City</th>
                      <td>{{$orderDetails->billing_city}}</td>
                    </tr>
                    <tr>
                      <th>State</th>
                      <td>{{$orderDetails->billing_state}}</td>
                    </tr>
                    <tr>
                      <th>Pincode</th>
                      <td>{{$orderDetails->billing_pincode}}</td>
                    </tr>
                    <tr>
                      <th>Country</th>
                      <td>{{$orderDetails->billing_country}}</td>
                    </tr>
                    <tr>
                      <th>Email</th>
                      <td>{{$orderDetails->billing_email}}</td>
                    </tr>
                    <tr>
                      <th>Mobile</th>
                      <td>{{$orderDetails->billing_mobile}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Delivery Address</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <tbody>
                @if ($orderDetails->delivery_method=="Flat Rate")
                    <tr>
                      <th>First Name</th>
                      <td>{{$orderDetails->delivery_first_name}}</td>
                    </tr>
                    <tr>
                      <th>Last Name</th>
                      <td>{{$orderDetails->delivery_last_name}}</td>
                    </tr>
                    <tr>
                      <th>Address 1</th>
                      <td>{{$orderDetails->delivery_address_1}}</td>
                    </tr>
                    <tr>
                      <th>Address 2</th>
                      <td>{{$orderDetails->delivery_address_2}}</td>
                    </tr>
                    <tr>
                      <th>City</th>
                      <td>{{$orderDetails->delivery_city}}</td>
                    </tr>
                    <tr>
                      <th>State</th>
                      <td>{{$orderDetails->delivery_state}}</td>
                    </tr>
                    <tr>
                      <th>Pincode</th>
                      <td>{{$orderDetails->delivery_pincode}}</td>
                    </tr>
                    <tr>
                      <th>Country</th>
                      <td>{{$orderDetails->delivery_country}}</td>
                    </tr>
                    <tr>
                      <th>Mobile</th>
                      <td>{{$orderDetails->delivery_mobile}}</td>
                    </tr>
                @else
                  <tr>
                    <th>Local Pickup: </th>
                    <td>Product will collect from the shop</td>
                  </tr>
                @endif
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- /.col -->
        </div>     
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
@endsection