<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    //

    protected $table = "childs";

    protected $fillable = ['nama', 'sekolah'];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
