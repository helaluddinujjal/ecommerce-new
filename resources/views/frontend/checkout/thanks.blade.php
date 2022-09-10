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
                        <li class="breadcrumb-item active">Thanks</li>
                    </ol>
                    </nav>
                    @include('include.session_msg')
                </div>
            </div>
            <div class="row">
                @include('layouts.frontend.sidebar')
                <div id="basket" class="col-lg-9">
                    <div class="jumbotron text-center">
                        <h1 class="display-3">Thank You!</h1>
                        <p class="lead"><strong>Your order has been placed successfully.</strong> Your order id {{Session::get('orderId')}} and total amount is {{settings('site_currency').Session::get('payTatal')}} </p>
                        <p class="lead"><strong>Please check your email</strong> You will get order information in shortly.</p>
                        <hr>

                        <p class="lead">
                            <a class="btn btn-primary btn-sm" href="{{url('/')}}" role="button">Continue to Shopping</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{Session::forget('orderId')}}
{{Session::forget('grandTotal')}}
{{Session::forget('payTotal')}}
{{Session::forget('coupon_code')}}
{{Session::forget('coupon_amount')}}
@endsection
