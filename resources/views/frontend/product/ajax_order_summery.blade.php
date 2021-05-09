<div id="order-summary" class="box">
    <div class="box-header">
      <h3 class="mb-0">Order summary</h3>
    </div>
    <p class="text-muted">Shipping and additional costs are calculated based on the values you have entered.</p>
    <div class="table-responsive">
      <table class="table">
        <tbody>
          <tr>
            <td>Order subtotal</td>
            @php
                if(Session::has('order_subtotal')){
                  $subtotal=Session::get('order_subtotal');
                }else{
                  $subtotal=0;
                }

                if(Session::has('coupon_amount')){
                  $couponAmount=Session::get('coupon_amount');
                }else{
                  $couponAmount=0;
                }
            @endphp
            <th>{{settings('site_currency')}}{{$subtotal}}</th>
          </tr>
          <tr>
            <td>Coupon Discount</td>
            <th>{{settings('site_currency')}}{{$couponAmount}}
            </th>
          </tr>
          @if (!empty($deliveryCharge))
          <tr>
            <td>Delivery Charge(+)</td>
            <th>{{settings('site_currency')}}{{$deliveryCharge['delivery_charges']}}</th>
          </tr>  
          @else
              
          @endif

          <tr class="total">
            <td>Total</td>
            <th>
              @php
              $grandTotal=$subtotal-$couponAmount;
              Session::put("grandTotal",$grandTotal)
          @endphp
              {{settings('site_currency')}}{{!empty($deliveryCharge)?$grandTotal+$deliveryCharge['delivery_charges']:$grandTotal}}
            </th>
          </tr>
        </tbody>
      </table>
    </div>
  </div>