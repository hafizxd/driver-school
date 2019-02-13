<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['plan', 'start_date', 'end_date'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function driver(){
        return $this->belongsTo('App\Driver');
    }

    // public function childs(){
    //     return $this->user->hasMany('App\Child');
    // }

    public function childs(){
        return $this->hasMany('App\Child');
    }

}
