<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
      protected $table = "notifications";

      protected $fillable = ['foreign_id', 'message', 'type', 'role', 'second_id'];
}
