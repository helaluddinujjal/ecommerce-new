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
                <li aria-current="page" class="breadcrumb-item active">Orders</li>
              </ol>
            </nav>
          </div>
          @include('layouts.frontend.customer-sidebar')
          <div id="customer-orders" class="col-lg-9">
            <div class="box">
              <h1>My orders</h1>
              <p class="lead">Your orders on one place.</p>
              <p class="text-muted">If you have any questions, please feel free to <a href="contact.html">contact us</a>, our customer service center is working for you 24/7.</p>
              <hr>
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Order Id</th>
                      <th>Order Products</th>
                      <th>Created Date</th>
                      <th>Delivery/Pickup<br> Date</th>
                      <th>Payment Method</th>
                      <th>Total</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach ($orders as $order)
                        <tr>
                            <th># {{$order->id}}</th>
                            <th>
                                @if (!empty($order->order_products))
                                    @foreach ($order->order_products as $product)
                                    {{$product->product_code}} <br>
                                    @endforeach  
                                @endif
                            </th>
                            <td>{{date('d-m-Y',strtotime($order->created_at))}}</td>
                            <td>
                              @if ($order->delivery_method=="Local Pickup")
                              {{date('d-m-Y h:i A',strtotime($order->delivery_pickup_dateTime))}} 
                              @else
                                 {{date('d-m-Y',strtotime($order->delivery_pickup_dateTime))}} 
                              @endif  
                            </td>
                            <td> {{$order->payment_method}}</td>
                            <td> {{$order->currency.$order->total}}</td>
                            <td><span class="badge badge-info">{{$order->order_status}}</span></td>
                            <td><a href="{{url('/orders/'.$order->id)}}" class="btn btn-primary btn-sm">View</a></td>
                        </tr>  
                      @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection