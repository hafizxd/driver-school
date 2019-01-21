<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Driver;

class DriverController extends Controller
{
    public function index(){
      $Drivers = Driver::where('role', 2)->orderBy('created_at', 'DESC')->get();
      $DriversBlocked = Driver::where('role', 0)->orderBy('created_at', 'DESC')->get();

      return view('driver')->with(compact('Drivers', 'DriversBlocked'));
    }

    public function show($id){
      $Drivers = Driver::where('id', $id)->first();

      return view('profiledriver')->with(compact('Drivers'));
    }

    public function login(Request $request){
        $user = Driver::where('email', $request->email)->where('role', 2)->first();
        if(Hash::check($request->password, $user->password)){
            return response()->json([
                'success' => 'true',
                'user_id' => $user->id
            ], 200);
        } else {
            return response()->json([
                'success' => 'false',

            ], 401);
        }
    }
}
