<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryCharge extends Model
{
    use HasFactory;
    public static function deliveryCharges($country){
        if (!empty($country)) {
            $count=DeliveryCharge::where(['country'=>$country,'status'=>1])->count();
            if ($count>0) {
                $charge=DeliveryCharge::where('country',$country)->first();
                return ['delivery_charges'=>$charge->delivery_charges];
            }else{
                return false;
            }
        }else{
            return 'empty';
        }

    }
}
