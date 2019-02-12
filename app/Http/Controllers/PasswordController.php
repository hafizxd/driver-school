<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
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

     public function updateWeb(Request $request){
        $user = User::where('email', $request->email)->first();
        if(empty($user))  $user = Driver::where('email', $request->email)->first();

        $user->update([ 'password' => bcrypt($request->password )]);
        return view('changePasswordSuccess')->with(compact('user'));
     }


     /*

         ===== API =====

     */


     public function updateApi(Request $request){
        $user = User::where('email', $request->email)->first();
        if (empty($user)) $user = Driver::where('email', $request->email)->first();

        if (empty($user)){
            return response()->json([
                'message' => 'error'
            ]);
        }

        if(Hash::check($request->old_password, $user->password)){
            $user->update([ 'password' => bcrypt($request->new_password) ]);
            return response()->json([
                'message' => 'success'
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
     }
}
