<div class="content" id="order-review" style="display: none">
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th colspan="2">Product</th>
            <th>Quantity</th>
            <th>Unit price</th>
            <th>Product/Category<br> Discount</th>
            <th colspan="2">Total</th>
          </tr>
        </thead>
        <tbody>
            @php
                $totalPrice=0;
                $totalWeight=0;
            @endphp
            @if ($cartDatas->count()>0)
                @foreach ($cartDatas as $data)
                @php
                    $discountData=App\Product::getAttrDiscountPrice($data->product_id,$data->size)
                @endphp
                <tr>
                    <td>
                     <a href="{{url('product',$data->product->url)}}">
                        @php
                        $image_path=public_path('images/product/small/'.$data->product->main_image);
                    @endphp
                    @if (!empty($data->product->main_image)&&file_exists($image_path))
                    <img src="{{asset('images/product/small/'.$data->product->main_image)}}" alt="{{$data->product_name}}" class="img-fluid">
                    @else
                    <img src="{{asset('images/demo/demo-medium.jpeg')}}" alt="{{$data->product->product_name}}">
                    @endif
                        </a></td>
                        
                    <td><a href="{{url('product/'.$data->product->url)}}">{{$data->product->product_name}}</a><br><small>Product Code: <strong>{{$data->product->product_code}}</strong></small> <br><small>Size: <strong>{{$data->size}}</strong></small> | <small>color: <strong>{{$data->product->product_color}}</strong></small></td>
                    <td>
                      {{$data->quantity}}
                    </td>
                    <td>{{settings('site_currency')}}{{$discountData['attr_price']}}</td>
                    <td>{{settings('site_currency')}}{{$discountData['dis_price']}}*{{$data->quantity}}={{settings('site_currency')}}{{$discountData['dis_price']*$data->quantity}}
                        @if ($discountData['percentage']>0)
                             <sup><span class="badge badge-info">{{$discountData['percentage']}}</span></sup>
                        @endif
                        
                    </td>
                    <td>{{settings('site_currency')}}{{$discountData['final_price']*$data->quantity}}</td>
                    
                  </tr>
                  @php
                      $totalPrice=$totalPrice+($discountData['final_price']*$data->quantity);
                      $totalWeight=$totalWeight+($discountData['attr_weight']*$data->quantity);
                  @endphp
                @endforeach
                @else
                <tr>
                    <td colspan="5"><h4 class="text-center">Cart is empty</h4></td>
                </tr>
            @endif
        </tbody>
        <tfoot>
          <tr>
            <th colspan="5">Total</th>
            <th colspan="2" id="cartTotalPrice">{{settings('site_currency')}}{{$totalPrice}}</th>
            @php
                Session::put('order_subtotal',$totalPrice);
                Session::put('total_weight',$totalWeight);
            @endphp
          </tr>
        </tfoot>
      </table>
    </div>
    <!-- /.table-responsive-->
  </div>