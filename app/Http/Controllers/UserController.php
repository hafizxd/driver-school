<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function index(Request $request){
      $Users = User::where('role', 1)->orderBy('created_at', 'DESC')->Paginate(10);
      $UsersBlocked = User::where('role', 0)->orderBy('created_at', 'DESC')->Paginate(10);

      return view('User')->with(compact('Users', 'UsersBlocked'));
    }

    public function show($id){
      $Users = User::where('id', $id)->first();

      return view('UserInfo')->with(compact('Users'));
    }

    public function update(Request $request, $id){
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
        'avatar' => $fileName,
        'name'   => $request->name,
        'email'  => $request->email,
        'wilayah'=> $request->wilayah,
        'phone'  => $request->phone
      ]);

      return back();
    }



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
