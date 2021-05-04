@extends('layouts.frontend.layouts')
@push('style')
<link rel="stylesheet" href="{{asset('vendor/datetimepicker-master/jquery.datetimepicker.css')}}">
@endpush
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
                <li class="breadcrumb-item"><a href="{{url('/cart')}}">Cart</a></li>
                  <li class="breadcrumb-item active">Checkout-Address</li>  
              </ol>
            </nav>
            @include('include.session_msg')
          </div>
          <div id="checkout" class="col-lg-9">
            <div class="box">
              <form method="post" action="" id="checkoutForm">
                @csrf
                <h1 id="checkout-hidding">Checkout - Address</h1>
                <div class="nav flex-column flex-md-row nav-pills text-center"><a href="checkout1.html" class="nav-link flex-sm-fill text-sm-center active" id="billing-menu"> <i class="fa fa-map-marker">                  </i>Address</a><a href="#" class="nav-link flex-sm-fill text-sm-center disabled" id="delivery-menu"> <i class="fa fa-truck">                       </i>Delivery Method</a><a href="#" class="nav-link flex-sm-fill text-sm-center disabled" id="payment-menu"> <i class="fa fa-money">                      </i>Payment Method</a><a href="#" class="nav-link flex-sm-fill text-sm-center disabled" id="review-menu"> <i class="fa fa-eye">                     </i>Order Review</a></div>

                {{-- billing-address --}}
                @include('frontend.checkout.billing_address') 
                {{-- end billing address --}}

                {{-- delivery address --}}
                @include('frontend.checkout.delivery_method')
                {{--end delivery-address --}}

                {{-- payment method --}}
                @include('frontend.checkout.payment_method')
                {{-- end payment method --}}

                {{-- start order review --}}
                @include('frontend.checkout.order_review')
                {{-- end order review --}}
                <div class="box-footer d-flex justify-content-between"><a href="{{url('cart')}}" class="btn btn-outline-secondary" id="checkout-prev"><i class="fa fa-chevron-left"></i>Back to <span id="prev-text">Basket</span></a>
                  <button type="button" class="btn btn-primary" id="checkout-next">Continue to <span id="next-text">Delivery Method</span><i class="fa fa-chevron-right"></i></button>
                </div>
              </form>
            </div>
            <!-- /.box-->
          </div>
          <!-- /.col-lg-9-->
          <div class="col-lg-3">
            <div class="order_summery">
              @include('frontend.product.ajax_order_summery')
            </div>
          </div>
          <!-- /.col-md-3-->
        </div>
      </div>
    </div>
  </div>
  @include('include.session_msg')
@endsection
@push('script')
<script src="{{asset('js/frontend/jquery.validate.min.js')}}"></script>
<script src="{{asset('js/frontend/custom.jquery.validate.js')}}"></script>

{{-- date range picker --}}
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>

<script src="{{asset('vendor/datetimepicker-master/build/jquery.datetimepicker.full.min.js')}}"></script>

<script>
  //convert to json
  var localPickupSettings = {!! json_encode($localPickupSettings) !!};
  var deliveryPickupSettings = {!! json_encode($deliveryPickupSettings) !!};
  if (localPickupSettings==null) {
    localPickupSettings=''
  }
  if (deliveryPickupSettings==null) {
    deliveryPickupSettings=''
  }
  //click activity
  $(".shipping-method").on('click',function(){
    $("#local_pickup_date_time").val('')
    setTimeout(function(){
      //delively pickup settings
      var value=$('.delivery_method:checked').val()
      $("#local_pick_date").slideDown('slow')
      if (value=="Flat Rate") {
        const date = new Date()
        var timezone=convertTZ(date, deliveryPickupSettings.timezone?deliveryPickupSettings.timezone:'Europe/Berlin');
        var now=timezone.getHours()
        if (deliveryPickupSettings.cutOffDay==1) {
          var minDate = timezone.getTime() + 24 * 60 * 60 * 1000;
          if (deliveryPickupSettings.shopCloseTime) {
            if (now>deliveryPickupSettings.shopCloseTime.split(':')[0]) {
              minDate = minDate + 24 * 60 * 60 * 1000;
            }
          }
        }else{
          var minDate =0;
          if (deliveryPickupSettings.shopCloseTime) {
            if (now>deliveryPickupSettings.shopCloseTime.split(':')[0]) {
                minDate = timezone.getTime() + 24 * 60 * 60 * 1000;
              }
          }
        }
            $('#local_pickup_date_time').datetimepicker({
              ownerDocument: document,
              contentWindow: window,
              scrollMonth : false,
              scrollInput : false,
              inline:false,
              format: 'Y-m-d H:i',
              formatTime: 'h:i A',
              formatDate: 'Y-m-d',
              minDate:minDate,
              minTime:deliveryPickupSettings.shopOpenTime?deliveryPickupSettings.shopOpenTime:false,
              maxTime:deliveryPickupSettings.shopCloseTime?deliveryPickupSettings.shopCloseTime:false,
              timepicker: deliveryPickupSettings.timeFieldShow==1?true:false,
              datepicker: true,
              scrollTime: false,
              disabledWeekDays: deliveryPickupSettings.weekend?deliveryPickupSettings.weekend:[],
              disabledDates : deliveryPickupSettings.holiday?deliveryPickupSettings.holiday:[],
            })
      }else{
        //localpickup settings
    const date = new Date()
    var timezone=convertTZ(date, localPickupSettings.timezone?localPickupSettings.timezone:'Europe/Berlin');
    var now=timezone.getHours()
    if (localPickupSettings.cutOffDay==1) {
      var minDate = timezone.getTime() + 24 * 60 * 60 * 1000;
      if (localPickupSettings.shopCloseTime) {
        if (now>localPickupSettings.shopCloseTime.split(':')[0]) {
           minDate = minDate + 24 * 60 * 60 * 1000;
        }
      }
    }else{
      var minDate =0;
      if (localPickupSettings.shopCloseTime) {
        if (now>localPickupSettings.shopCloseTime.split(':')[0]) {
            minDate = timezone.getTime() + 24 * 60 * 60 * 1000;
          }
      }
    }
        $('#local_pickup_date_time').datetimepicker({
          ownerDocument: document,
          contentWindow: window,
          scrollMonth : false,
          scrollInput : false,
          inline:false,
          format: 'Y-m-d H:i',
          formatTime: 'h:i A',
          formatDate: 'Y-m-d',
          minDate:minDate,
          minTime:localPickupSettings.shopOpenTime?localPickupSettings.shopOpenTime:false,
          maxTime:localPickupSettings.shopCloseTime?localPickupSettings.shopCloseTime:false,
          timepicker: localPickupSettings.timeFieldShow==1?true:false,
          datepicker: true,
          scrollTime: false,
          disabledWeekDays: localPickupSettings.weekend?localPickupSettings.weekend:[],
          disabledDates : localPickupSettings.holiday?localPickupSettings.holiday:[],
        })
      }
      
    },300)
    
    
  })
  
  function convertTZ(date, tzString) {
    return new Date((typeof date === "string" ? new Date(date) : date).toLocaleString("en-US", {timeZone: tzString}));   
}
  </script>
@endpush