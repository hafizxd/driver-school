<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function driver(){
      return $this->belongsTo('App\Models\Driver');
    }

    public function user(){
      return $this->belongsTo('App\User');
    }
}
