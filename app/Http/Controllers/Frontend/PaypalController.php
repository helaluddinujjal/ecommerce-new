<?php

namespace App\Http\Controllers\Frontend;
use App\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PaypalService;

class PaypalController extends Controller
{
    private $paypalService;

    function __construct(PaypalService $paypalService){

        $this->paypalService = $paypalService;
 
    }
    public function payment($orderId)
{
    $response = $this->paypalService->createOrder($orderId); 

    if($response->statusCode !== 201) {
        abort(500);
    }
    $order = Order::find($orderId);
    $order->payment_status = 2;
    $order->paypal_orderid = $response->result->id;
    $order->save();

    foreach ($response->result->links as $link) {
        if($link->rel == 'approve') {
            return redirect($link->href);
        }
    }
}

    public function success($orderId){
        $order = Order::find($orderId);

        $response = $this->paypalService->captureOrder($order->paypal_orderid);

        if ($response->result->status == 'COMPLETED') {
            $order->payment_status = 1;
            $order->save();
            return redirect('thanks');

        }
        $order = Order::find($orderId);
        $order->payment_status=3;
        $order->save();
        $msg="Your order [order_id] has been successfully placed with Laravel Project.We will intimate you once your order is shipped";
            $msg= str_replace("[order_id]",$orderId,$msg);
            $orderDetails=Order::with('order_products')->where('id',$orderId)->first();
            
            //reduce stock from product attribute
            foreach ($orderDetails->order_products as $order) {
                Product::reduceStock($order->product_id,$order->size,$order->quantity);
            }
            $email=$orderDetails->billing_email;
            $name=$orderDetails->billing_first_name.' '.$orderDetails->billing_last_name;
            $msgData=[
                'msg'=>$msg,
                'name'=>$name,
                'order_id'=>$orderId,
                'orderDetails'=>$orderDetails,
            ];
            $subject="Order Placed-".config('app.name');;
            Mail::send('mail.order', $msgData, function ($message) use($email,$subject,$name){
              $message->to($email, $name)->subject($subject);
            });
        toast("Trunsection UnSuccessful! Something went wrong!",'error');
        return redirect('/');
 

    }
    
     public function cancel($orderId)
     {
        $order = Order::find($orderId);
        $order->payment_status=2;
        $order->save();
        toast("Payment UnSuccessful! Your payment has been cancled",'error');
        return redirect('/');
     }
}
