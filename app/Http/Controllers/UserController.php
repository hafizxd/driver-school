<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function index(Request $request){
      $search_q = urlencode($request->input('search'));
      if(!empty($search_q)){
        $value = str_replace('+', ' ', $search_q);
        $user = User::where('name', 'like', '%' . $value . '%')->get();
      }else{
        $user = User::all();
        $value = "";
      }

      return view('user.user', ['user' => $user, 'value' => $value]);
    }

    public function show($id){
      $user = User::where('id', $id)->first();

      return view('user.profile', ['user' => $user]);
    }

    public function update(Request $request, $id){

      $this->validate($request, [
        'name'  => 'required',
        'email' => 'required'
      ]);

      if(!empty($request->avatar)){
        $this->validate($request, [
          'avatar' => 'mimes:jpg,jpeg,png'
        ]);
        $fileName = time() . '.png';
        $request->file('avatar')->storeAs('public/blog/', $fileName);
      }else{
        $file = User::where('id', $id)->first();
        $fileName = $file->avatar;
      }

      User::findOrFail($id)->update([
        'name'   => $request->name,
        'email'  => $request->email,
        'alamat' => $request->alamat,
        'avatar' => $fileName
      ]);

      return redirect(route ('user'));
    }










    public function store(Request $request){
        $user = new User;
        $user->name = $request->email;
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
