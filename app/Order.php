<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $dates = ['delivery_pickup_dateTime'];
    public function order_products(){
        return $this->hasMany("App\OrdersProduct",'order_id');
    }
    public function user(){
        return $this->belongsTo("App\User",'user_id');
    }
}
