<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Child;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index(Request $request){
      $Users = User::where('role', 1)->orderBy('created_at', 'DESC')->get();
      $UsersBlocked = User::where('role', 0)->orderBy('created_at', 'DESC')->get();

      return view('User')->with(compact('Users', 'UsersBlocked'));
    }

    public function show($id){
      $Users = User::where('id', $id)->first();

      return view('UserInfo')->with(compact('Users'));
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

    


    /*
    
      ====== API ======

    */ 

    
    public function store(Request $request){
      
      $user = User::where('email', $request->email)->get();

      if($user->count() > 0){
        return response()->json([
          'success' => 'false',
          'error'   => 'Email telah didaftarkan'
        ]);
      } else {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json([
          'success' => 'true',
          'user_id' => $user->id
        ], 200);
      }
    
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
                'success' => 'false'
            ], 401);
        }
    }

    public function complete(Request $request){
        $user = User::where('id', $request->id)->first();
        $child = new Child;    

        $child->user_id = $user->id;
        $child->name = $request->name;

        $file     = $request->file('avatar');
        $filename = $user->name.sha1(time()) . "." . $file->getClientOriginalExtension();
        $request->file('avatar')->move("img/user", $filename);
        $user->avatar = $filename;
        
        $child->save();
        $user->save();

        return response()->json([
          'success' => 'true',
          'user_id' => $user->id
        ]);
    }

    public function info(Request $request){
        $user = User::where('id', $request->id)->first();
        if(!empty($user)){
            return response()->json([
              'name' => $user->name,
              'email' => $user->email,
              'phone' => $user->phone,
              'nama_anak' => $user->child->name,
              'avatar' => "img/user/" . $user->avatar
            ]);
        }
    }
    
}
