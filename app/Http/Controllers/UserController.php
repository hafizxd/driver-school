<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    public function index(){

    }

    public function store(Request $request){
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json([
            'user_id' => $user->id,
            'success' => 'true'
        ]);

    }

    public function login(Request $request){
        $user = User::where('email', $request->email)->where('role', '!=', 0)->first();

        if(Hash::check($request->password, $user->password)){
            return response()->json([
                'user_id' => $user->id,
                'success' => 'true'
            ], 200);
        } else {
            return response()->json([
                'success' => 'false'
            ], 401);
        }
    }

    public function infoApi(Request $request){
        $user = User::where('id', $request->id)->first();
        return response()->json([
            'user_id' => $user->id,
            'name'    => $user->name,
            'email'   => $user->email
        ]);
    }
    
    public function infoWeb(){

    }
}
