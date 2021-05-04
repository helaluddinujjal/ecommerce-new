<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function orders(){
        $orders=Order::with('order_products')->where('user_id',Auth::user()->id)->get();
        return view('frontend.order.orders')->with(compact('orders'));
    }
    public function orderDetails($id){
        $orderDetails=Order::with('order_products')->where('id',$id)->first();
        return view('frontend.order.order-details')->with(compact('orderDetails'));
    }
}
