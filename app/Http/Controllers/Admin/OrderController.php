<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Order;
use App\OrderStatus;
use App\OrderStatusLog;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function orders(){
        Session::forget('page');
        Session::put('page','admin-order');
        $orders=Order::with('order_products','user')->get();
        return view('admin.order.orders')->with(compact('orders'));
    }
    public function orderDetails($id){
        $orderDetails=Order::with('order_products','user')->where('id',$id)->first();
        $orderStatus=OrderStatus::where('status',1)->get();
        $orderStatusLogs=OrderStatusLog::where('order_id',$id)->orderBy('id','DESC')->get();
        return view('admin.order.order-details')->with(compact('orderDetails','orderStatus','orderStatusLogs'));
    }
    public function updateOrderStatus(Request $request){
        if ($request->isMethod('post')) {
            $this->validate($request,[
                'order_status'=>'required|not_in:0',
            ]);
            $statusData=getOrderStatusName($request->order_status,['name','status']);
            if ($statusData==false ||$statusData->status==0) {
                toast('Status value is not valid','error');
                return redirect()->back();
            }else {
                if ($statusData->name=="Shipped") {
                    if (!empty($request->courier_name)&&!empty($request->tracking_number)) {
                        $courier_name=$request->courier_name;
                        $tracking_number=$request->tracking_number;
                        Order::where('id',$request->order_id)->update(['courier_name'=>$courier_name,'tracking_number'=>$tracking_number]);
                    }else{
                        toast('Courier Name and Tracking number field are required','error');
                        return redirect()->back();
                    }
                }
                Order::where('id',$request->order_id)->update(['order_status'=>$statusData->name]);
                toast("Order status has been updated",'success');
                $orderDetails=Order::with('order_products')->where('id',$request->order_id)->first();
                $orderId= $orderDetails->id;
                $user=User::select('first_name','last_name','email')->where('id',$orderDetails->user_id)->first();
                $email=$user->email;
                $subject="Order Status Updated-".config('app.name');
                $msg="Your order #[order_id] status has been updated to [status]";
                  $msg= str_replace("[order_id]",$orderId,$msg);
                  $msg= str_replace("[status]",$orderDetails->order_status,$msg);
                  $name=$user->first_name.' '.$user->last_name;
                  $orderDetails=Order::with('order_products')->where('id',$orderId)->first();
                  $msgData=[
                      'msg'=>$msg,
                      'name'=>$name,
                      'order_id'=>$orderId,
                      'orderDetails'=>$orderDetails,
                      "status"=>true,
                  ];
                  Mail::send('mail.order', $msgData, function ($message) use($email,$subject,$name){
                    $message->to($email, $name)->subject($subject);
                  });
                  $logs=new OrderStatusLog();
                  $logs->order_id=$orderId;
                  $logs->order_status=$orderDetails->order_status;
                  $logs->save();
                return redirect()->back();
            }
        }
    }

    //order-invoice
    public function orderInvoice($id){
        $orderDetails=Order::with('order_products')->where('id',$id)->first();
        return view('admin.order.order-invoice')->with(compact('orderDetails'));
    }
    //order-invoice
    public function orderPdf($id){
        $orderDetails=Order::with('order_products')->where('id',$id)->first();
       
        $pdf= PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('admin.order.order-pdf', compact('orderDetails'));
        //$pdf = PDF::loadView('admin.order.order-pdf', compact('orderDetails'));
       // return $pdf->setPaper('A4', 'landscape')->stream();
        return $pdf->setPaper('A4', 'landscape')->download('#'.$orderDetails->id.' invoice.pdf');
    }

    public function viewOrdersCharts(){
        $current_month_orders=Order::whereYear('created_at',date('Y'))->whereMonth('created_at',date('m'))->count();
        $last_month_orders=Order::whereYear('created_at',date('Y'))->whereMonth('created_at',date('m',strtotime('-1 month')))->count();
        $last_2_last_month_orders=Order::whereYear('created_at',date('Y'))->whereMonth('created_at',date('m',strtotime('-2 month')))->count();
        $last_3_last_month_orders=Order::whereYear('created_at',date('Y'))->whereMonth('created_at',date('m',strtotime('-3 month')))->count();
        $orderCount=[$current_month_orders,$last_month_orders,$last_2_last_month_orders,$last_3_last_month_orders];
        return view('admin.order.view-orders-charts')->with(compact('orderCount'));
    }
}
