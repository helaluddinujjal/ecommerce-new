{{-- //nav Pagination --}}
<div class="box info-bar">
  <div class="row">
    <div class="col-md-12 col-lg-4 products-showing">Showing <strong id="firstItem">{{!empty($productDetails->firstItem())?$productDetails->firstItem():0}}</strong> to <strong id="lastItem">{{$productDetails->lastItem()}}</strong> of <strong id="totalItem">{{$productDetails->total()}}</strong> products</div>
    <div class="col-md-12 col-lg-7 products-number-sort">
      <form class="form-inline d-block d-lg-flex justify-content-end flex-column flex-md-row" id="productForm">
        <div class="products-sort-by mt-2 mt-lg-0"><strong>Sort by</strong>
          <input type="hidden" id="sec_url" value="{{$sec}}">
          <input type="hidden" id="cat_url" value="{{$cat}}">
          <select name="sort-by" id="sort-by" class="form-control">
            <option value="">Default</option>
            <option @if (isset($sort_by)&&$sort_by=='id__Desc')
                selected
            @endif value="id__Desc">Latest</option>
            <option value="product_name__Asc" @if (isset($sort_by)&&$sort_by=='product_name__Asc')
            selected
        @endif>Product Name A-Z</option>
            <option value="product_name__Desc" @if (isset($sort_by)&&$sort_by=='product_name__Desc')
            selected
        @endif>Product Name Z-A</option>
            <option value="product_price__Asc" @if (isset($sort_by)&&$sort_by=='product_price__Asc')
            selected
        @endif>Price(Low-High)</option>
            <option value="product_price__Desc" @if (isset($sort_by)&&$sort_by=='product_price__Desc')
            selected
        @endif>Price(High-Low)</option>
          </select>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="row products">
  @if ($productDetails->count()>0)
  @foreach ($productDetails as $proDetail)   
  @php
  $path=public_path('images/product/small/'.$proDetail->main_image);
  if (!empty($proDetail->main_image)&&file_exists($path)) {
    $imgUrl=asset('images/product/small/'.$proDetail->main_image);
  }else {
    $imgUrl=asset('images/demo/demo-small.jpeg');
  }
  @endphp
      <div class="col-lg-4 col-md-6">
      <div class="product">
          <div class="flip-container">
          <div class="flipper">
              <div class="front"><a href="{{url('product/'.$proDetail->url)}}"><img src="{{$imgUrl}}" alt="" class="img-fluid"></a></div>
              <div class="back"><a href="{{url('product/'.$proDetail->url)}}"><img src="{{$imgUrl}}" alt="" class="img-fluid"></a></div>
          </div>
          </div><a href="{{url('product/'.$proDetail->url)}}" class="invisible"><img src="{{$imgUrl}}" alt="" class="img-fluid"></a>
          <div class="text">
          <h3><a href="{{url('product/'.$proDetail->url)}}">{{$proDetail->product_name}}</a></h3>
          <p class="price"> 
            @php
                $discount_data= App\Product::getDiscountPrice($proDetail->id);
            @endphp
            @if ($discount_data['price']>0)
            <sup><span class="badge badge-info">{{$discount_data['percentage']}}</span></sup><del class="text-danger">${{$proDetail->product_price}}</del> ${{$discount_data['price']}}
            @else
              ${{$proDetail->product_price}}
            @endif
          </p>
          <p class="buttons"><a href="{{url('product/'.$proDetail->url)}}" class="btn btn-outline-secondary">View detail</a><a href="basket.html" class="btn btn-primary"><i class="fa fa-shopping-cart"></i>Add to cart</a></p>
          </div>
          <!-- /.text-->
          @if (!empty($proDetail->brand->name))
              <div class="ribbon sale">
                <div class="theribbon">{{$proDetail->brand->name}}</div>
                <div class="ribbon-background"></div>
              </div> 
          @endif
          @if (App\Product::countProductStock($proDetail->id)<1)
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
  @else
  <div class="col-lg-12 col-md-12">
    <div class="product d-flex vh-100">
      <h2 class="text-muted m-auto">Product is not available</h2>
    </div>
  </div>    
  @endif
   
   <!-- /.products-->
  </div>
  {{-- //pagignation --}}
  <div class="pages">
    <nav id="products" aria-label="Page navigation example" class="d-flex justify-content-center">
      @if (isset($_GET['sort-by'])&&!empty($_GET['sort-by']))
        {{$productDetails->appends(['sort-by'=>$_GET['sort-by']])->links()}}
      @else
      @if ($productDetails->total()>$productDetails->perPage())
        {{$productDetails->links()}}      
      @endif
      @endif
    </nav>
  </div>