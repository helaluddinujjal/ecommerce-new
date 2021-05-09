@if (count($latestProducts)>0)
                    @foreach ($latestProducts as $product)
                    @php
                      $path=public_path('images/product/small/'.$product->main_image);
                    @endphp
                    <div class="col-lg-3 col-md-4 addProduct">
                      <div class="product">
                        <div class="flip-container">
                          <div class="flipper">
                            <div class="front"><a href="{{url('/product/'.$product->url)}}"><img src="{{!empty($product->main_image)&& file_exists($path)?asset('images/product/small/'.$product->main_image):asset('images/demo/demo-small.png')}}" alt="{{$product->product_name}}" class="img-fluid"></a></div>
                            <div class="back"><a href="{{url('/product/'.$product->url)}}"><img src="{{!empty($product->main_image)&& file_exists($path)?asset('images/product/small/'.$product->main_image):asset('images/demo/demo-small.png')}}" alt="{{$product->product_name}}" class="img-fluid"></a></div>
                          </div>
                        </div><a href="{{url('/product/'.$product->url)}}" class="invisible"><img src="{{!empty($product->main_image)&& file_exists($path)?asset('images/product/small/'.$product->main_image):asset('images/demo/demo-small.png')}}" alt="{{$product->product_name}}" class="img-fluid"></a>
                        <div class="text">
                          <h3><a href="{{url('/product/'.$product->url)}}">{{$product->product_name}}</a></h3>
                          <p class="price"> 
                            @php
                               $discount_data= App\Product::getDiscountPrice($product->id);
                            @endphp
                            @if ($discount_data['price']>0)
                            <sup><span class="badge badge-info">{{$discount_data['percentage']}}</span></sup><del class="text-danger">{{settings('site_currency')}}{{$product->product_price}}</del> {{settings('site_currency')}}{{$discount_data['price']}}
                            @else
                              {{settings('site_currency')}}{{$product->product_price}}
                            @endif
                          </p>
                          <p class="buttons">
                            <a href="{{url('/product/'.$product->url)}}" class="btn btn-outline-secondary">View detail</a>
                            <a href="{{url('/product/'.$product->url)}}" class="btn btn-primary"><i class="fa fa-shopping-cart"></i>Add to cart</a></p>
                        </div>
                        @if (!empty($product->brand->name))
                            <div class="ribbon sale">
                              <div class="theribbon">{{$product->brand->name}}</div>
                              <div class="ribbon-background"></div>
                            </div> 
                        @endif
                        @if (App\Product::countProductStock($product->id)<1)
                          <div class="ribbon red">
                            <div class="theribbon">Sold</div>
                            <div class="ribbon-background"></div>
                          </div> 
                        @endif
                        <!-- /.text-->
                      </div>
                      <!-- /.product            -->
                    </div>
                    @endforeach
                    <div class="pages col-md-12" id="home_pagi">
                      @if ($latestProducts->total()>$latestProducts->perPage())
                      <p class="loadMore"><a href="{{$latestProducts->toArray()['next_page_url']}}"  @if ($latestProducts->toArray()['total']==$latestProducts->toArray()['to'])
                        class="d-none"
                        @else
                        class="btn btn-primary btn-lg"
                      @endif><i class="fa fa-chevron-down"></i> Load more</a></p>     
                        @endif
                    </div>
                  @endif