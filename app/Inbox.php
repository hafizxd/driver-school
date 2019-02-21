<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    protected $table = "inbox";

    protected $fillable= ['isAlreadyNotified'];

    public function order(){
        return $this->belongsTo('App\Order');
    }

}
