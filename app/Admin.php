<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guard='admin';
    protected $fillable = [
        'name', 'email', 'password','status','type','mobile','image','created_at','updated_at'
    ];
    protected $hidden = [
        'password','remember_token'
    ];
}
