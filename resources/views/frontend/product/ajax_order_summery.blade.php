@php
$getCountries = App\Country::get();
@endphp
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
                        if (Session::has('order_subtotal')) {
                            $subtotal = Session::get('order_subtotal');
                        } else {
                            $subtotal = 0;
                        }

                        if (Session::has('coupon_amount')) {
                            $couponAmount = Session::get('coupon_amount');
                        } else {
                            $couponAmount = 0;
                        }
                    @endphp
                    <th>{{ settings('site_currency') }}{{ $subtotal }}</th>
                </tr>
                <tr>
                    <td>Coupon Discount</td>
                    <th>{{ settings('site_currency') }}{{ $couponAmount }}
                    </th>
                </tr>
                @if (!empty($deliveryCharge))
                    <tr>
                        <td>Delivery Charge(+)</td>
                        <th>{{ settings('site_currency') }}{{ $deliveryCharge['delivery_charges'] }}</th>
                    </tr>
                @else
                @endif

                <tr class="total">
                    <td>Total</td>
                    <th>
                        @php
                            $grandTotal = $subtotal - $couponAmount;
                            Session::put('grandTotal', $grandTotal);
                        @endphp
                        {{ settings('site_currency') }}{{ !empty($deliveryCharge) ? $grandTotal + $deliveryCharge['delivery_charges'] : $grandTotal }}
                    </th>
                </tr>
                <tr>
                    <td colspan="2">
                        <h4>Check available country and pincode</h4>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <form action="javascript:void(0)" method="post" id="check_country_pincode">
                        <div class="form-group">
                            <select class="form-control" name="country_ch_pin" id="country_ch_pin">
                                <option value="">Select a country</option>
                                @foreach ($getCountries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input ch_pincode" type="checkbox" id="ch_pincode_cod"
                                value="ch_cod">
                            <label class="form-check-label" for="ch_cod">Pincode for Cash on Delivery</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input ch_pincode" type="checkbox" id="ch_pincode_prepaid"
                                value="ch_prepaid">
                            <label class="form-check-label" for="ch_prepaid">Pincode for Prepaid</label>
                        </div>
                        <div class="input-group">
                            <input class="form-control d-none" placeholder="Pincode.." value="" id="pincode_box"/><span
                                class="input-group-append">
                                <button id="ch_country_pincode_submit" type="submit" class="btn btn-primary"><i
                                        class="fa fa-paper-plane"></i></button></span>
                        </div>
                        <div id="show_msg_ch"></div>
                    </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
