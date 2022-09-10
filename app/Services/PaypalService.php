<?php
namespace App\Services;

use App\Order;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

class PaypalService
{
    private $client;

    function __construct()
    {
        $environment = new SandboxEnvironment(env('PAYPAL_CLIENT_ID'), env('PAYPAL_SECRET'));
        $this->client = new PayPalHttpClient($environment);

    }

    public function createOrder($orderId)
    {
        $request = new OrdersCreateRequest();
        //$request->headers["prefer"] = "return=representation";
        //$request->body = $this->checkoutData($orderId);
        $request->body = $this->simpleCheckoutData($orderId);
        return $this->client->execute($request);
    }

    public function captureOrder($paypalOrderId)
    {
        $request = new OrdersCaptureRequest($paypalOrderId);

        return $this->client->execute($request);
    }

    private function simpleCheckoutData($orderId)
    {
        $order = Order::find($orderId);

        return [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "reference_id" => 'webmall_'. uniqid(),
                "amount" => [
                    "value" => $order->total,
                    "currency_code" => get_currency_code()
                ]
            ]],
            "application_context" => [
                "cancel_url" => route('paypal.cancel', $orderId),
                "return_url" => route('paypal.success', $orderId)
            ]
            ];
    }


    private function checkoutData($orderId)
    {
        $order = Order::with('order_products')->find($orderId);
        $orderItems = [];
        foreach($order->order_products as $item) {

            $orderItems[] = [
                'name' => $item->product_name,
               // 'description' => \Str::limit($item->description, 100),
                'quantity' => $item->product_qty,
                'unit_amount' => [
                    'currency_code' => 'USD',
                    'value' => $item->product_discount_price
                ],
                'tax' =>
                [
                    'currency_code' => 'USD',
                    'value' => '0',
                ],
                'category' => 'PHYSICAL_GOODS',

            ];

        }



        $checkoutData = [
            'intent' => 'CAPTURE',
            'application_context' =>
            [
                'return_url' => route('paypal.success', $orderId),
                'cancel_url' => route('paypal.cancel', $orderId),
                'brand_name' => config('app.name'),
                'locale' => 'en-US',
                'landing_page' => 'BILLING',
                'shipping_preference' => 'SET_PROVIDED_ADDRESS',
                'user_action' => 'PAY_NOW',
            ],
            'purchase_units' => [
                [
                    'reference_id' =>  uniqid(),
                   // 'description' => 'some order description for the order',
                    'custom_id' => 'CUST-HighFashions',
                    'soft_descriptor' => 'HighFashions',
                    'items' => $orderItems,
                    'shipping' =>
                    [
                        'method' => 'Paypal',
                        'name' =>
                        [
                            'full_name' => $order->billing_first_name,
                        ],
                        'address' =>
                        [
                            'address_line_1' => $order->billing_address_1,
                            'address_line_2' => $order->billing_address_2,
                            'city' => $order->billing_city,
                            'state' => $order->billing_state,
                            'postal_code' => $order->billing_pincode,
                            'country' => $order->billing_country,
                            'country_code'=>'',
                        ],
                    ],
                    'amount' =>
                    [
                        'currency_code' => get_currency_code(),
                        'value' => $order->total,
                        'breakdown' =>
                        [
                            'item_total' =>
                            [
                                'currency_code' => get_currency_code(),
                                'value' => $order->order_products->sum('product_discount_price'),
                            ],
                            'shipping' =>
                            [
                                'currency_code' => get_currency_code(),
                                'value' => '0',
                            ],
                            'handling' =>
                            [
                                'currency_code' => get_currency_code(),
                                'value' => '0',
                            ],
                            'tax_total' =>
                            [
                                'currency_code' => get_currency_code(),
                                'value' => '0',
                            ],
                            'shipping_discount' =>
                            [
                                'currency_code' => get_currency_code(),
                                'value' => '0',
                            ],
                        ],
                    ],
                ]
            ],

        ];

        return $checkoutData;
    }
}