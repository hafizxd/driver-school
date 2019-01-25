<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

    protected $table = "images";

    protected $fillable = [
      'images', 'driver_id'
    ];


    protected function driver(){
        return $this->belongsTo('App\Driver');
    }
}
