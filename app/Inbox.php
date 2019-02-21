<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    protected $table = "inbox";

    public function order(){
        return $this->belongsTo('App\Order');
    }

}
