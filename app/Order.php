<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    public function users(){
        return $this->hasMany('App\User');
    }

    public function drivers(){
        return $this->hasMany('App\Drivers');
    }

}
