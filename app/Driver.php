<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{

    protected $fillable = [
      'name', 'email', 'role', 'avatar', 'tipe_mobil', 'max_penumpang', 'gender_penumpang', 'tujuan', 'alamat', 'phone'
    ];


    public function image(){
      return $this->hasOne('App\Image');
    }
}
