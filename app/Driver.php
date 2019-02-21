<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{

    protected $fillable = [
      'name', 'email', 'role', 'avatar', 'tipe_mobil', 'max_penumpang', 'gender_penumpang', 'tujuan', 'alamat', 'phone', 'city'
    ];


    public function image(){
      return $this->hasOne('App\Image');
    }

    public function orders(){
        return $this->hasMany('App\Order');
    }

    public function user(){
      return $this->orders->user();
    }
}
