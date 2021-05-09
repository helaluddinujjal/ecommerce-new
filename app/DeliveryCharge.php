<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class DeliveryCharge extends Model
{
    use HasFactory;
    public static function deliveryCharges($country){
        if (!empty($country)) {
            //get delivery charge by country
            if (settings('delivery_charge_type')=="Country") {
                $count=DeliveryCharge::where(['country'=>$country,'status'=>1])->count();
                if ($count>0) {
                    $charge=DeliveryCharge::where('country',$country)->first();
                    return ['delivery_charges'=>$charge->delivery_charges];
                }else{
                    return false;
                }
            } else {
                //get delivery charge by weight
                $count=DeliveyChargeByWeight::where(['country'=>$country,'status'=>1])->count();
                if ($count>0) {
                    $charge=DeliveyChargeByWeight::select('delivery_charges_by_weight')->where(['country'=>$country,'status'=>1])->first();
                    //total weight
                    $totalWeight=Session::get('total_weight');
                    //check settincgs is empty or not
                    if (!empty($charge->delivery_charges_by_weight)) {
                        //unserialize from json
                        $chargeArr=unserialize($charge->delivery_charges_by_weight);
                        foreach ($chargeArr as $key => $value) {
                            //if site weight measerement kg then convert into gram
                            if (settings('weight_measurement')=='kg') {
                                $value['from']=$value['from']*1000;
                                $value['to']=$value['to']*1000;
                            }
                            //check condition with product total weight
                            if ($value['to']==='+1' && $totalWeight>$value['from']) {
                                return ['delivery_charges'=>$value['delivery_charges']];
                            }else if($value['to']==='-1' && $totalWeight<$value['from']) {
                                return ['delivery_charges'=>$value['delivery_charges']];
                           }else if ($totalWeight>=$value['from'] && $totalWeight<=$value['to']) {
                                return ['delivery_charges'=>$value['delivery_charges']];
                            }
                        }
                        return ['delivery_charges'=>0];
                    }else{
                        //if all condition not set then delivery charge will be 0
                        return ['delivery_charges'=>0];
                    }
                    return ['delivery_charges'=>$charge->delivery_charges];
                }else{
                    return false;
                }
            }
            
  
        }else{
            return 'empty';
        }

    }
}
