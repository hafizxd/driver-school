<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Child;

class ChildController extends Controller
{
      public function show($user_id, $id){
          $Child = Child::find($id);

          return view ();
      }
}
