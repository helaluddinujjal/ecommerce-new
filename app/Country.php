<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    public function states(){
        return $this->hasMany('App\State','country_id')->select(['id', 'name','country_id']);
    }

    public static function getStates($country_id){
        $states=State::select('id','name')->where('country_id',$country_id)->get();
        return $states;
    }
    public static function getCities($state_id){
        $states=City::select('id','name')->where('state_id',$state_id)->get();
        return $states;
    }
    public static function flag($country_id){
        $emoji=Country::select('emoji')->where('id',$country_id)->first();
        return $emoji;
    }
}
