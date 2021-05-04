<?php

namespace App\Http\Controllers\Frontend;

use App\Banner;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
class IndexController extends Controller
{
    public function index(Request $request){
        //get featured data
        Paginator::useBootstrap();
        $featuredData=Product::select('product_name','id','product_price','url','main_image','brand_id')->where(['is_featured'=>'Yes','status'=>1])->with('brand')->get();
        //$featuredDataChunk=array_chunk($featuredData,5);
        //dd($featuredDataChunk);
        //latest product
        $latestProducts=Product::select('product_name','id','product_price','url','main_image','brand_id')->orderBy('id','desc')->with('brand')->limit(30)->paginate(8);
       // dd($latestProducts);
       if ($request->ajax()) {
        $latestProducts=Product::select('product_name','id','product_price','url','main_image','brand_id')->orderBy('id','desc')->with('brand')->limit(20)->paginate(8);
        return view('frontend.product.ajax_home_latest_product')->with(compact('latestProducts'));
    }
       $banners=Banner::where('status',1)->get();
        return view('frontend.index')->with(compact('featuredData','latestProducts','banners'));
    }
}
