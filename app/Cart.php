<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Cart extends Model
{
    use HasFactory;

    public function product(){
        return $this->belongsTo('App\Product');
    }

    public static function userCartItem(){
        if (Auth::check()) {
            $userCart=Cart::with(['product'=>function($query){
                $query->select('id','category_id','product_name','product_color','product_code','main_image','url');
            }])->where('user_id',Auth::user()->id)->orderBy('id','Desc')->get();
        } else {
            $userCart=Cart::with(['product'=>function($query){
                $query->select('id','product_name','product_color','product_code','main_image','url');
            }])->where('session_id',Session::get('session_id'))->orderBy('id','Desc')->get();
        }
        return $userCart;
    }

    public static function getProductAttrPrice($product_id,$size){
        $AttrPrice=ProductAttribute::select('price')->where(['product_id'=>$product_id,'size'=>$size])->first();
        return $AttrPrice->price;
    }
    public static function getCartRelatedProduct($productArray){
        //related product
       $catSecIds=[];
       foreach ($productArray as $key=>$proId) {
          $productDetail= Product::select('category_id','section_id','id')->where('id',$proId->product_id)->first();
          $catSecIds[$key]['category_id']=$productDetail->category_id;
          $catSecIds[$key]['section_id']=$productDetail->section_id;
          $catSecIds[$key]['product_id']=$productDetail->id;
         // $catSecIds[$key]['brand_name']=$productDetail->brand->name;
       }
       $catIds = collect($catSecIds)->pluck('category_id')->toArray();
       $secIds = collect($catSecIds)->pluck('section_id')->toArray();
       $productIds = collect($catSecIds)->pluck('product_id')->toArray();
       //$brandName = collect($catSecIds)->pluck('brand_name')->toArray();
     // echo "<pre>";print_r($catIds);die;
      $relatedProducts=Product::with('brand')->select('id','main_image','product_name','product_price','url','brand_id')->whereIn('category_id',$catIds)->whereIn('section_id',$secIds)->whereNotIn('id',$productIds)->inRandomOrder()->limit(3)->get();
      return $relatedProducts;
    }

}
