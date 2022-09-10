<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Softon\Indipay\Facades\Indipay;

class PayUMoneyController extends Controller
{
    public function payumoney(){
        $order_id=Session::get('orderId');
        $grandTotal=Session::get('grandTotal');
        $orderDetails=Order::where('id',$order_id)->first();
        $parameters = [
            'order_id' => $order_id,
            //'hash' => '1233221223322',
            'firstname' => $orderDetails->billing_first_name,
            'lastname' => $orderDetails->billing_last_name,
            'email' => $orderDetails->billing_email,
            'phone' => $orderDetails->billing_mobile,
            'productinfo' => $order_id,
            'txnid' => $order_id,
            'amount' => $grandTotal,
            'service_provider' => '',
            'zipcode' => $orderDetails->billing_pincode,
            'city' => $orderDetails->billing_city,
            'state' => $orderDetails->billing_state,
            'country' => $orderDetails->billing_country,
            'address1' => $orderDetails->billing_address_1,
            'address2' => $orderDetails->billing_address_2,
            'curl'=>url('payumoney/response'),
          ];
          $order = Indipay::prepare($parameters);
          return Indipay::process($order);
    }

    public function payumoneyResponse(Request $response){
        $response = Indipay::prepare($response);
        // $response['status']='success';
        // $response['unmappedstatus']='captured';
        if ($response['status']='success' && $response['unmappedstatus']='captured' ) {
            $orderId=Session::get('orderId');
            Order::where('id',$orderId)->update(['order_status' => 'Paid','payment_status'=>1]);
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
              toast("Order has been completed !!",'success');
              return redirect('thanks');
        }else{
            Order::where('id',$orderId)->update(['order_status' => 'Payment Fail','payment_status'=>2]);
            toast("Trunsection UnSuccessful! Something went wrong!",'error');
            return view('frontend.checkout.fail');
        }
    }

    public function payumoneyVerify($id=null){
        if ($id>0) {
            //check single order
            $orders=Order::where('id',$id)->first();
        }else{
            //check multiple last 5 orders status
            $orders=Order::where('payment_gateway','Payumoney')->take(5)->orderBy('id','Desc')->get();
        }
        foreach ($orders as $key => $order) {
            $key = 'gtKFFx';
            $salt = 'eCwWELxi';

            $command = "verify_payment";
            $var1 =$order->id;
            $hash_str = $key  . '|' . $command . '|' . $var1 . '|' . $salt ;
            $hash = strtolower(hash('sha512', $hash_str));
            $r = array('key' => $key , 'hash' =>$hash , 'var1' => $var1, 'command' => $command);

            $qs= http_build_query($r);
            $wsUrl = "https://test.payu.in/merchant/postservice?form=2";
            $c = curl_init();
            curl_setopt($c, CURLOPT_URL, $wsUrl);
            curl_setopt($c, CURLOPT_POST, 1);
            curl_setopt($c, CURLOPT_POSTFIELDS, $qs);
            curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
            $o = curl_exec($c);
            if (curl_errno($c)) {
              $sad = curl_error($c);
              throw new Exception($sad);
            }
            curl_close($c);

            $valueSerialized = @unserialize($o);
            if($o === 'b:0;' || $valueSerialized !== false) {
              print_r($valueSerialized);
            }
            $o = json_decode($o);
           // echo "<pre>"; print_r($o); die;

            //get check and update

           if (!empty($o->transaction_details)) {
            foreach($o->transaction_details as $key => $val){
                if(($val->status=="success")&&($val->unmappedstatus=="captured")){
                    if($order->order_status == "Payment Cancelled"){
                        Order::where(['id' => $order->id])->update(['order_status' => 'Paid','payment_status'=>1]);
                    } else if($order->order_status == "Payment Fail"){
                        Order::where(['id' => $order->id])->update(['order_status' => 'Paid','payment_status'=>1]);
                    } else if($order->order_status == "New"){
                        Order::where(['id' => $order->id])->update(['order_status' => 'Paid','payment_status'=>1]);
                    } else if($order->order_status == "Pending"){
                        Order::where(['id' => $order->id])->update(['order_status' => 'Paid','payment_status'=>1]);
                    }
                }else{
                    if($order->order_status == "Paid"){
                        Order::where(['id' => $order->id])->update(['order_status' => 'Payment Cancelled','payment_status'=>3]);
                    } else if($order->order_status == "New"){
                        Order::where(['id' => $order->id])->update(['order_status' => 'Payment Cancelled','payment_status'=>3]);
                    }
                }
            }
           }
        }

    }
}
