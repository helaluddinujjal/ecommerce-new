<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<style>
    #invoice{
    padding: 30px;
}

.invoice {
    position: relative;
    background-color: #FFF;
    min-height: 680px;
    padding: 15px
}

.invoice header {
    padding: 10px 0;
    margin-bottom: 20px;
    border-bottom: 1px solid #3989c6
}

.invoice .company-details {
    text-align: right
}

.invoice .company-details .name {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .contacts {
    margin-bottom: 20px
}

.invoice .invoice-to {
    text-align: left
}

.invoice .invoice-to .to {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .invoice-details {
    text-align: right
}

.invoice .invoice-details .invoice-id {
    margin-top: 0;
    color: #3989c6
}

.invoice main {
    padding-bottom: 50px
}

.invoice main .thanks {
    margin-top: -100px;
    font-size: 2em;
    margin-bottom: 50px
}

.invoice main .notices {
    padding-left: 6px;
    border-left: 6px solid #3989c6
}

.invoice main .notices .notice {
    font-size: 1.2em
}

.invoice table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    margin-bottom: 20px
}

.invoice table td,.invoice table th {
    padding: 15px;
    background: #eee;
    border-bottom: 1px solid #fff
}

.invoice table th {
    white-space: nowrap;
    font-weight: 400;
    font-size: 16px
}

.invoice table td h3 {
    margin: 0;
    font-weight: 400;
    color: #3989c6;
    font-size: 1.2em
}

.invoice table .qty,.invoice table .total,.invoice table .unit {
    text-align: right;
    font-size: 1.2em
}

.invoice table .no {
    color: #fff;
    font-size: 1.6em;
    background: #3989c6
}

.invoice table .unit {
    background: #ddd
}

.invoice table .total {
    background: #3989c6;
    color: #fff
}

.invoice table tbody tr:last-child td {
    border: none
}

.invoice table tfoot td {
    background: 0 0;
    border-bottom: none;
    white-space: nowrap;
    text-align: right;
    padding: 10px 20px;
    font-size: 1.2em;
    border-top: 1px solid #aaa
}

.invoice table tfoot tr:first-child td {
    border-top: none
}

.invoice table tfoot tr:last-child td {
    color: #3989c6;
    font-size: 1.4em;
    border-top: 1px solid #3989c6
}

.invoice table tfoot tr td:first-child {
    border: none
}

.invoice footer {
    width: 100%;
    text-align: center;
    color: #777;
    border-top: 1px solid #aaa;
    padding: 8px 0
}

@media print {
    .invoice {
        font-size: 11px!important;
        overflow: hidden!important
    }

    .invoice footer {
        position: absolute;
        bottom: 10px;
        page-break-after: always
    }

    .invoice>div:last-child {
        page-break-before: always
    }
}
</style>
<!------ Include the above in your HEAD tag ---------->

<div id="invoice">

    <div class="toolbar hidden-print">
        <div class="text-right">
            <button id="printInvoice" class="btn btn-info"><i class="fa fa-print"></i> Print</button>
            <a href="{{url('admin/order-pdf/'.$orderDetails->id)}}" class="btn btn-info"><i class="fa fa-file-pdf-o"></i> Export as PDF</a>
        </div>
        <hr>
    </div>
    <div class="invoice overflow-auto">
        <div style="min-width: 600px">
            <header>
                <div class="row">
                    <div class="col">
                        <a target="_blank" href="{{url('/')}}">
                            <img src="{{asset('images/frontend/img/logo.png')}}" data-holder-rendered="true"/>
                            </a>
                    </div>
                    <div class="col invoice-details">
                        <h1 class="invoice-id">INVOICE Order #{{$orderDetails->id}}</h1>
                        <div class="barcode" style="display: inline-block">
                            {!! DNS1D::getBarcodeSVG($orderDetails->id, "C39", 2, 33) !!}
                        </div>
                        <div class="date">Date of Invoice: {{date('d/m/Y',strtotime($orderDetails->created_at))}}</div>
                    </div>
                </div>
            </header>
            <main>
                <div class="row contacts">
                    <div class="col invoice-to">
                        <div class="text-gray-light">Billing Details:</div>
                        <h2 class="to">{{$orderDetails->billing_first_name}} {{$orderDetails->billing_last_name}}</h2>
                        <div class="address">{{$orderDetails->billing_address_1}} {{$orderDetails->billing_address_2}}</div>
                        <div class="address">{{$orderDetails->billing_city}},{{$orderDetails->billing_state}}</div>
                        <div class="address">{{$orderDetails->billing_pincode}},{{$orderDetails->billing_country}}</div>
                        <div class="email"><a href="call:{{$orderDetails->billing_mobile}}">{{$orderDetails->billing_mobile}}</a></div>
                        <div class="email"><a href="mailto:{{$orderDetails->billing_email}}">{{$orderDetails->billing_email}}</a></div>
                    </div>
                    <div class="col invoice-details">
                        @if ($orderDetails->delivery_method=="Flat Rate")
                            <div class="text-gray-light">Delivery Details:</div>
                            <h2 class="to">{{$orderDetails->delivery_first_name}} {{$orderDetails->delivery_last_name}}</h2>
                            <div class="address">{{$orderDetails->delivery_address_1}} {{$orderDetails->delivery_address_2}}</div>
                            <div class="address">{{$orderDetails->delivery_city}},{{$orderDetails->delivery_state}}</div>
                            <div class="address">{{$orderDetails->delivery_pincode}},{{$orderDetails->delivery_country}}</div>
                            <div class="email"><a href="call:{{$orderDetails->delivery_mobile}}">{{$orderDetails->delivery_mobile}}</a></div>
                        @else
                            <div class="text-gray-light">Delivery Method:</div>
                            <h2 class="to">{{$orderDetails->delivery_method}} </h2>
                            <div class="address">Product will collect from the shop. </div>
                        @endif
                        
                    </div>
                </div>
                <div class="row contacts">
                    <div class="col invoice-to">
                        <h4 class="text-gray-light">Payment Method:</h4>
                        <div class="address">{{$orderDetails->payment_method}}</div>
                    </div>
                    @if ($orderDetails->delivery_method=="Flat Rate")
                        <div class="col invoice-details">
                            <h4 class="text-gray-light">Delivery Method:</h4>
                            <div class="address">{{$orderDetails->delivery_method}}</div>
                        </div>
                    @endif
                </div>
                <table border="0" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class="text-left">Item</th>
                            <th class="text-right">Quantity</th>
                            <th class="text-right">Unit Price</th>
                            <th class="text-right">Discount(-)</th>
                            <th class="text-right">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $x=0;
                            $total=0;
                        @endphp
                        @foreach ($orderDetails->order_products as $item)
                            <tr>
                                <td class="no">{{++$x}}</td>
                                <td class="text-left"><h3>{{$item->product_name}}</h3>{{$item->product_code}}|{{$item->product_color}}|{{$item->product_size}} <br>
                                    <div class="barcode" style="display: inline-block">
                                        {!! DNS1D::getBarcodeSVG($item->product_code, "C39", 1, 33) !!}
                                    </div>
                                </td>
                                <td class="qty">{{$item->product_qty}}</td>
                                <td class="unit">${{$item->product_unit_price}}</td>
                                <td class="qty">${{($item->product_unit_price-$item->product_discount_price)*$item->product_qty}}</td>
                                <td class="total">${{$item->product_discount_price*$item->product_qty}}</td>
                            </tr>
                            @php
                                $total=$total+($item->product_discount_price*$item->product_qty);
                            @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"></td>
                            <td colspan="2">SUBTOTAL</td>
                            <td>${{$total}}</td>
                        </tr>
                        @if ($orderDetails->coupon_amount>0)
                            <tr>
                                <td colspan="3"></td>
                                <td colspan="2">Coupon Amount (-)</td>
                                <td>${{$orderDetails->coupon_amount}}</td>
                            </tr>
                        @endif
                        @if ($orderDetails->delivery_method=="Flat Rate")
                            <tr>
                                <td colspan="3"></td>
                                <td colspan="2">Delivery Charge (+)</td>
                                <td>${{$orderDetails->delivery_charges}}</td>
                            </tr>
                        @endif
                        <tr>
                            <td colspan="3"></td>
                            <td colspan="2">GRAND TOTAL</td>
                            <td>${{$orderDetails->total}}</td>
                        </tr>
                    </tfoot>
                </table>
                <div class="thanks">Thank you for order!</div>
            </main>
            <footer>
                <h2 class="name">
                    <a target="_blank" href="{{url('/')}}">
                        <img src="{{asset('images/frontend/img/logo.png')}}" data-holder-rendered="true"/>
                    </a>
                </h2>
                <div>455 Foggy Heights, AZ 85004, US</div>
                <div>(123) 456-789</div>
                <div>company@example.com</div>
            </footer>
        </div>
        <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
        <div></div>
    </div>
</div>
<script>
     $('#printInvoice').click(function(){
            Popup($('.invoice')[0].outerHTML);
            function Popup(data) 
            {
                window.print();
                return true;
            }
        });
</script>