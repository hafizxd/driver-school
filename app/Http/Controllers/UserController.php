<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Child;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;


class UserController extends Controller
{
    public function index(Request $request){
      $Users = User::where('role', 1)->orderBy('created_at', 'DESC')->Paginate(10);
      $UsersBlocked = User::where('role', 0)->orderBy('created_at', 'DESC')->Paginate(10);

      return view('User')->with(compact('Users', 'UsersBlocked'));
    }

    public function infoWeb($id){
      $User = User::where('id', $id)->first();

      return view('userInfo')->with(compact('User'));
    }

    public function update(Request $request){
      $user = User::where('id', $request->id)->first();
      $user->name = $request->name;
      $user->email = $request->email;
      $user->address = $request->alamat;
      $user->phone = $request->phone;

      if(!empty($request->avatar)){
        $file     = $request->file('avatar');
        $filename = $user->name.sha1(time()) . "." . $file->getClientOriginalExtension();
        $request->file('avatar')->move("img/user", $filename);
        $user->avatar = $filename;
      }

      $user->save();

      $User = User::where('id', $request->id)->first();
      $Childs = Child::where('user_id', $User->id)->get();
      $i = 0;
      $n = 0;
      foreach ($request->child as $Key => $Child) {
          $n += 1;
        for ($i; $i < $n; $i++) {
          print($i);
            // $Childs[1]->update([
            //   'nama' => $Child
            // ]);
        }
        $i += 1;
      }

    //  return redirect()->back();
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
              'nama_anak' => $user->getChild->name,
              'avatar' => "img/user/" . $user->avatar
            ]);
        }
    }

}
