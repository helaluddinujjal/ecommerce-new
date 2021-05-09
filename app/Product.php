<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category(){
        return $this->belongsTo('App\Category','category_id');
    }
    public function section(){
        return $this->belongsTo('App\Section','section_id');
    }
    public function brand(){
        return $this->belongsTo('App\Brand','brand_id');
    }
    public function attributes(){
        return $this->hasMany('App\ProductAttribute');
    }
    public function images(){
        return $this->hasMany('App\ProductImage');
    }
    public static function countProduct($name,$value){

        echo $totalProduct=Product::where($name,$value)->count();
    }
    public function productViews(){
        return $this->hasMany('App\ProductView');
    }
    public function showProduct(){
        if(auth()->id()==null){
            return $this->productViews()
            ->where('ip', '=',  request()->ip())->exists();
        }

        return $this->productViews()
        ->where(function($productViewsQuery) { $productViewsQuery
            ->where('session_id', '=', request()->getSession()->getId())
            ->orWhere('user_id', '=', (auth()->check()));})->exists();  
    }
    public static function getProductDetails($id){
        $productDetails=Product::with(['brand'=>function($query){
            $query->select('name','id');
        }])->select('product_name','product_price','main_image','id','brand_id')->where('id',$id)->first();
        return $productDetails;
    } 
    
    public static function countProductStock($id){
        $totalStock=ProductAttribute::where('product_id',$id)->sum('stock');
        return $totalStock;
    }
    
    public static function getDiscountPrice($product_id){
        $proDetails=Product::select('category_id','product_price','product_discount')->where('id',$product_id)->first();
        $catDetails=Category::select('discount')->where('id',$proDetails->category_id)->first();
        $discountData=[];
        if ($proDetails->product_discount>0) {
            $discountPrice=$proDetails->product_price-($proDetails->product_price*$proDetails->product_discount)/100;
            $discountData=['price'=> $discountPrice,'percentage'=>$proDetails->product_discount. '% Off'];
        } elseif ($catDetails->discount>0){
            $discountPrice =$proDetails->product_price-($proDetails->product_price*$catDetails->discount)/100;
            $discountData=['price'=> $discountPrice,'percentage'=>$catDetails->discount. '% Off'];
        }else{
            $discountData=['price'=> 0,'percentage'=>0];
        }
        return $discountData;
        
    }
    public static function getAttrDiscountPrice($product_id,$size){
        $attrProDetails=ProductAttribute::select('price','stock','weight')->where(['product_id'=>$product_id,'size'=>$size])->first();
        $proDetails=Product::select('category_id','product_discount')->where('id',$product_id)->first();
        $catDetails=Category::select('discount')->where('id',$proDetails->category_id)->first();
        $discountData=[];
        if ($proDetails->product_discount>0) {
            $finalPrice=$attrProDetails->price-($attrProDetails->price*$proDetails->product_discount)/100;
            $discount_price=$attrProDetails->price-$finalPrice;
            $discountData=['attr_price'=>$attrProDetails->price,'attr_stock'=>$attrProDetails->stock,'attr_weight'=>$attrProDetails->weight,'final_price'=> $finalPrice,'percentage'=>$proDetails->product_discount. '% Off','dis_price'=>$discount_price];
        } elseif ($catDetails->discount>0){
            $finalPrice =$attrProDetails->price-($attrProDetails->price*$catDetails->discount)/100;
            $discount_price=$attrProDetails->price-$finalPrice;
            $discountData=['attr_price'=>$attrProDetails->price,'attr_weight'=>$attrProDetails->weight,'final_price'=> $finalPrice,'percentage'=>$catDetails->discount. '% Off','attr_stock'=>$attrProDetails->stock,'dis_price'=>$discount_price];
        }else{
            $discountData=['attr_price'=>$attrProDetails->price,'final_price'=> $attrProDetails->price,'percentage'=>0,'attr_stock'=>$attrProDetails->stock,'attr_weight'=>$attrProDetails->weight,'dis_price'=>0];
        }
        return $discountData;
        
    }

}
