<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryAddress extends Model
{
    use HasFactory;
    protected $fillable=['user_id','first_name','last_name','address_1','address_2','country','state','city','pincode','mobile'];
}
