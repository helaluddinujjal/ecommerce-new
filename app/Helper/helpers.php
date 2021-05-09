<?php

use App\Cart;
use App\City;
use App\Country;
use App\OrderStatus;
use App\Product;
use App\SiteSetting;
use App\State;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

function totalCartItem(){
    if(Auth::check()){
        $itemsCount=Cart::where('user_id',Auth::user()->id)->sum('quantity');
    }else{
        $session_id=Session::get('session_id');
        $itemsCount=Cart::where('session_id',$session_id)->sum('quantity');
    }
    return $itemsCount;
}

function getCountryName($id){
    if (is_numeric($id)) {
        $count=Country::where('id',$id)->count();
        if ($count>0) {
            $country=Country::select('name')->where('id',$id)->first();
            return $country->name;
        } else {
            return false;
        }
        
    }else {
        return false;
    }
}
function getStateName($id){
    if (is_numeric($id)) {
        $count=State::where('id',$id)->count();
        if ($count>0) {
            $state=State::select('name')->where('id',$id)->first();
            return $state->name;
        } else {
            return false;
        }
        
    }else {
        return $id;
    }
}
function getCityName($id){
    if (is_numeric($id)) {
        $count=City::where('id',$id)->count();
        if ($count>0) {
            $city=City::select('name')->where('id',$id)->first();
            return $city->name;
        } else {
            return false;
        }
        
    }else {
        return $id;
    }
}
function getProductData($id,$data){
        $count=Product::where('id',$id)->count();
        if ($count>0) {
            $data=Product::select($data)->where('id',$id)->first();
            return $data;
        } else {
            return false;
        }
        
}
function getOrderStatusName($id,$data){
        if (is_numeric($id)) {
            $count=OrderStatus::where('id',$id)->count();
            if ($count>0) {
                $data=OrderStatus::select($data)->where('id',$id)->first();
                return $data;
            } else {
                return false;
            }
        }else {
            return false;
        }
        
}
//get Site settings data
function settings($data){
    $siteSetting=SiteSetting::select($data)->where('id',1)->first();
    if (!empty($siteSetting)) {
        return $siteSetting->$data;
    }else{
        if ($data=='site_currency') {
            return "$";
        }
        if ($data=='delivery_charge_type') {
            return "Country";
        }
        if ($data=='weight_measurement') {
            return "g";
        }
    }
}
?>