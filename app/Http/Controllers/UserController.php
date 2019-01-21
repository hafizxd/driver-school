<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    
    public function store(Request $request){
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();
        return response()->json([
            'success' => 'true',
            'user_id' => $user->id
        ], 200);
    }

    public function login(Request $request){
        $user = User::where('email', $request->email)->where('role', 1)->first();
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
