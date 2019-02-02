<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Driver;

class PasswordController extends Controller
{
     public function reset(Request $request){
        $user = User::where('email', $request->email)->first();
        if(empty($user))  $user = Driver::where('email', $request->email)->first();

        return view('changePassword')->with(compact('user'));
     }

     public function update(Request $request){
        $user = User::where('email', $request->email)->first();
        if(empty($user))  $user = Driver::where('email', $request->email)->first();

        $user->update([ 'password' => bcrypt($request->password )]);
        return view('changePasswordSuccess')->with(compact('user'));
     }
}
