<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
      $user = User::all();
      return view('user.user', ['user' => $user]);
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

      if(!empty($request->profile_img)){
        $fileName = time() . '.png';
        $request->file('profile_img')->storeAs('public/blog/', $fileName);
      }else{
        $file = User::where('id', $id)->first();
        $fileName = $file->profile_img;
      }

      User::findOrFail($id)->update([
        'name'  => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'profile_img' => $fileName
      ]);

      return redirect(route ('user'));
    }
}
