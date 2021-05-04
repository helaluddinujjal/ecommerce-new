<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductView extends Model
{
    use HasFactory;
    public function productView()
    {
        return $this->belongsTo('App\Product');
    }

    public static function createProductViewLog($product) {
        $productViews=ProductView::where('product_id',$product->id)->where(function($query){
            $query->where('user_id',\Auth::id());
            $query->orWhere('ip',\Request::getClientIp());
            $query->orWhere('session_id',\Request::getSession()->getId());
        })->first();
        if (!empty($productViews)) {
            $productViews->touch();
        }else{
            $productViews= new ProductView();
            $productViews->product_id = $product->id;
            $productViews->product_slug = $product->url;
            $productViews->url = \Request::url();
            $productViews->session_id = \Request::getSession()->getId();
            $productViews->user_id = (\Auth::check())?\Auth::id():null; 
            $productViews->ip = \Request::getClientIp();
            $productViews->user_agent = \Request::header('User-Agent');
            $productViews->save();
        }
       
       
    }
}
