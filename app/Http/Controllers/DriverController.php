<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Driver;

class DriverController extends Controller
{
    

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
