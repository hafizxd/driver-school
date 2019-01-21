<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    public function customers(){
      return $this->hasMany('App\Models\Customer');
    }
}
