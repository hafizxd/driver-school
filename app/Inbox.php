<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    protected $table = "inbox";

    protected $fillable= ['isAlreadyNotified', 'description', 'images', 'order_id'];

    public function order(){
        return $this->belongsTo('App\Order');
    }

}
