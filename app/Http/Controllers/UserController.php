<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ResetPassword;
use App\User;
use App\Child;
use App\Inbox;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use File;

class UserController extends Controller
{

    public function index(Request $request){
      $Users = User::where('role', 1)->orderBy('created_at', 'DESC')->Paginate(10);
      $UsersBlocked = User::where('role', 0)->orderBy('created_at', 'DESC')->Paginate(10);


      return view('User')->with(compact('Users', 'UsersBlocked'));
    }

    public function block($id){
        $User = User::find($id);
        if($User->role != 0){
            $User->role = 0;
        } else {
            $User->role = 1;
        }
        $User->save();

        session()->flash('block', 'Success');

        return back();
    }

    public function infoWeb($id){
      $User = User::where('id', $id)->first();

      return view('userInfo')->with(compact('User'));
    }


    public function update(Request $request){
      $User = User::where('id', $request->id)->first();

      if(!empty($request->avatar)){
        $file = $request->file('avatar');
        $fileName = $User->name.sha1(time()) . "." . $file->getClientOriginalExtension();
        $request->file('avatar')->move("img/user", $fileName);
      }else{
        $file = User::where('id', $request->id)->first();
        $fileName = $file->avatar;
      }

      User::findOrFail($request->id)->update([
          'name'             => $request->name,
          'email'            => $request->email,
          'avatar'           => $fileName,
          'address'          => $request->address,
          'phone'            => $request->phone
      ]);

      $Childs = Child::where('user_id', $request->id)->get();

      $i = 1;

      foreach ($Childs as $Key => $Child) {
            $Child->update([
              'name' => $request->child[$i]
            ]);
            $i += 1;
      }

      session()->flash('updateSuccess', 'Update Profil Success');

     return redirect()->back();
    }

    public function nameSearch(Request $request){
        return User::where('name','LIKE', '%'.$request->name.'%')->orWhere('email', 'LIKE', '%'.$request->name.'%')->get();
    }


    /*

      ====== API ======

    */


    public function store(Request $request){
      $user = User::where('email', $request->email)->get();

      if($user->count() > 0){
        return response()->json([
          'message' => 'false',
          'error'   => 'Email telah didaftarkan'
        ]);
      } else {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        $user->fcm_token = $request->fcm_token;
        $user->save();

        return response()->json([
          'message' => 'success',
          'user_id' => $user->id
        ], 200);
      }

    }

    public function login(Request $request){
        $user = User::where('email', $request->email)->where('role', 1)->first();
        if(Hash::check($request->password, $user->password)){
            $user->update(['fcm_token' => $request->fcm_token]);
            return response()->json([
                'message' => 'success',
                'user_id' => $user->id
            ], 200);
        } else {
            return response()->json([
                'message' => 'false'
            ], 200);
        }
    }

    public function complete(Request $request){
        $user = User::where('id', $request->id)->first();

        $file     = $request->file('avatar');
        $filename = $user->name.sha1(time()) . "." . $file->getClientOriginalExtension();
        $request->file('avatar')->move("img/user", $filename);
        $user->avatar = $filename;

        $user->save();

        return response()->json([
          'message' => 'success',
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
              'address' => $user->address,
              'avatar' => "img/user/" . $user->avatar
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function resetpassword(Request $request){
        $user = User::where('email', $request->email)->first();
        if(empty($user)){
            return response()->json([
                'message' => 'Email belum terdaftar'
            ], 200);
        } else {
            Mail::to($request->email)->send(new ResetPassword($user));
            return response()->json([
                'message' => 'success',
                'user_id' => $user->id
            ], 200);
        }
    }

    public function updateUser(Request $request){
        $user = User::where('id',$request->userId);

        $user->address = $request->address;
        $user->phone = $request->phone;

        if(!empty($request->file('image'))){

          $file     = $request->file('avatar');
          $filename = $user->name.sha1(time()) . "." . $file->getClientOriginalExtension();
          $request->file('avatar')->move("img/user", $filename);
          $user->avatar = $filename;
        }else if(!empty($request->avatar)){
            $user->avatar = $request->avatar;
        }

        $user->save();

        return response()->json([
            'message' => 'success'
        ], 200);
    }

    public function logout(Request $request){
        $user = User::where('id', $request->id)->first();
        if(!empty($user)){
            $user->fcm_token = "";
            $user->save();
            return response()->json([
              'message' => 'success'
            ], 200);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function tellParent (Request $request){
      $inbox = new  Inbox;
      $inbox->user_id = $request->userId;
      $inbox->description = $request->description;
      $inbox->images = $request->images;
      $inbox->save();
      return response()->json([
        'message' => 'success'
      ]);
    }

    public function notifications(Request $request){
      
    }

}
