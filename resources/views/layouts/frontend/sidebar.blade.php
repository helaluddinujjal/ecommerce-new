@php
use App\Section;
use App\Brand;
use App\ProductFilter;
    $sections=Section::sections();
   // echo '<pre>';print_r($sections);die;

    $productFilter=ProductFilter::where('status',1)->get();
    $productBrand=Brand::where('status',1)->get();
@endphp
<div class="col-lg-3">
    <!--
    *** MENUS AND FILTERS ***
    _________________________________________________________
    -->
    <div class="card sidebar-menu mb-4">
      <div class="card-header">
        <h3 class="h4 card-title">Categories</h3>
      </div>
      <div class="card-body">
        <ul class="nav nav-pills flex-column category-menu">
            @php $i=0; @endphp
            @foreach ($sections as $section)
            @php  $i= ++$i;@endphp
                <li><a href="{{url($section['url'])}}" class="nav-link">{{$section['name']}} 
                  @if ($i % 2 == 0)
                  <span class='badge badge-secondary'>{{App\Product::countProduct('section_id',$section['id'])}}</span>
                  @else
                  <span class='badge badge-light'>{{App\Product::countProduct('section_id',$section['id'])}}</span>
                  @endif
                </a>
                <ul class="list-unstyled">
                    @foreach ($section['categories'] as $category)
                        <li><a href="{{url('/'.$section['url'].'/'.$category['url'])}}" class="nav-link">{{$category['category_name']}}</a></li>
                    @endforeach
                </ul>
                </li>
            @endforeach
        </ul>
      </div>
    </div>
    @php
        $filter_velue= Session::get('filter_velue');
    @endphp
    @if ($filter_velue!='false')
    <div class="card sidebar-menu mb-4">
      <div class="card-header">
        <h3 class="h4 card-title">Brands <a  clear="brand" href="javascript:void(0)" class="btn btn-sm btn-danger pull-right uncheckAll"><i class="fa fa-times-circle"></i> Clear</a></h3>
      </div>
      <div class="card-body">
        <form>
          <div class="form-group">
            @foreach ($productBrand as $brand)
              <div class="checkbox">
                <label>
                  <input class="brand" name="value" type="checkbox" value="{{$brand->id}}" autocomplete="off"> {{$brand->name}}  ({{ App\Product::countProduct('brand_id',$brand->id) }})
                </label>
              </div> 
            @endforeach
          </div>
        </form>
      </div>
    </div>
    @if ($productFilter->count()>0)
      @foreach ($productFilter as $filter)
        <div class="card sidebar-menu mb-4">
          <div class="card-header">
            <h3 class="h4 card-title">{{!empty($filter->title)?$filter->title:ucwords($filter->name)}} <a clear="{{$filter->name}}" href="javascript:void(0)" class="btn btn-sm btn-danger pull-right uncheckAll"><i class="fa fa-times-circle"></i> Clear</a></h3>
          </div>
          <div class="card-body">
            <form>
              <div class="form-group">
                @php
                  $filter_values=json_decode($filter->value);
                @endphp
                @if (!empty($filter_values))
                  @foreach ($filter_values as $filter_value)
                  
                  <div class="checkbox">
                    <label>
                      @if ($filter_value->status==1)
                        <input name="value" class="{{$filter->name}}" type="checkbox" value="{{$filter_value->name}}" autocomplete="off"><span class="colour white"></span> {{$filter_value->name}} ({{ App\Product::countProduct($filter->name,$filter_value->name) }})
                      @endif
                    </label>
                  </div> 
                  @endforeach
                @endif
              </div>
            </form>
          </div>
        </div>    
      @endforeach
    @endif
    @endif
  
    <!-- *** MENUS AND FILTERS END ***-->
    <div class="banner"><a href="#"><img src="{{asset('images/frontend/img/banner.jpg')}}" alt="sales 2014" class="img-fluid"></a></div>
  </div>