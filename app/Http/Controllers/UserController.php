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
