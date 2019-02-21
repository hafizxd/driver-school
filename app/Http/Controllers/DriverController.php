<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\RegisterDriver;
use App\Mail\ResetPassword;
use App\Mail\ConfirmMailDriver;
use App\Driver;
use App\Image;
use App\Inbox;
use App\Notification;
use File;

class DriverController extends Controller
{

    public function index(){
        $Drivers = Driver::where('role', 2)->orderBy('created_at', 'DESC')->Paginate(10);
        $DriversBlocked = Driver::where('role', 0)->orderBy('created_at', 'DESC')->Paginate(10);
        $DriversPending = Driver::where('role', 4)->orderBy('created_at', 'DESC')->Paginate(10);

        return view('Driver')->with(compact('Drivers', 'DriversBlocked', 'DriversPending'));
    }

    public function block($id){
        $Driver = Driver::where('id',$id)->first();
        if($Driver->role == 2){
            $Driver->role = 0;
        }  else {
            $Driver->role = 2;
        }
        $Driver->save();

        return back();
    }

    public function infoWeb($id){
        $Driver = Driver::where('id', $id)->first();

        return view('driverinfo')->with(compact('Driver'));
    }


    public function updateWeb(Request $request){
        $Driver = Driver::where('id', $request->id)->first();

        if(!empty($request->avatar)){
            $file = $request->file('avatar');
            $fileName = $Driver->name.sha1(time()) . "." . $file->getClientOriginalExtension();
            $request->file('avatar')->move("img/driver", $fileName);
        } else {
            $fileName = $Driver->avatar;
        }

        if(!empty($request->image)){
            $file = $request->image;
            $imageName = $Driver->name.sha1(time()) . "." . $file->getClientOriginalExtension();
            $request->file('image')->move("img/mobil", $imageName);
            $Driver->image->images = $imageName;
            $Driver->image->save();
        }

        Driver::findOrFail($request->id)->update([
            'name'             => $request->name,
            'email'            => $request->email,
            'avatar'           => $fileName,
            'tipe_mobil'       => $request->tipe_mobil,
            'max_penumpang'    => $request->max_penumpang,
            'gender_penumpang' => $request->gender_penumpang,
            'tujuan'           => $request->tujuan,
            'alamat'           => $request->alamat,
            'phone'            => $request->phone
        ]);

        return back();
    }


    public function accept($id){
        $driver = Driver::where('id', $id)->first();
        Mail::to($driver->email)->send(new RegisterDriver($driver));

        $driver->update([
            'role' => 2
        ]);

        return redirect('/driver');
    }


    public function decline($id){
        Driver::destroy($id);

        return redirect('/driver');
    }

    public function validateDriver(Request $request){
        $driver = Driver::where('email', $request->email)->first();
        $driver->update([ 'role' => 4 ]);

        return view('ValidationSuccess')->with(compact('driver'));
    }


    /*

        ===== API =====

    */

    public function store(Request $request){
        $driver = Driver::where('email', $request->email)->get();

        if($driver->count() > 0){
            return response()->json([
            'message' => 'false',
            'error'   => 'Email telah didaftarkan'
            ]);
        } else {
            $driver = $request;
            Mail::to($request->email)->send(new ConfirmMailDriver($driver));

            $driver = new Driver;
            $driver->name = $request->name;
            $driver->email = $request->email;
            $driver->nopol = $request->nopol;
            $driver->phone = $request->phone;
            $driver->tipe_mobil = $request->tipe_mobil;
            $driver->fcm_token = $request->fcm_token;

            $file     = $request->file('avatar');
            $filename = $driver->name.sha1(time()) . "." . $file->getClientOriginalExtension();
            $request->file('avatar')->move("img/driver", $filename);
            $driver->avatar = $filename;

            $driver->password = bcrypt($request->password);
            $driver->save();

            return response()->json([
            'message' => 'success',
            'driver_id' => $driver->id
            ], 200);
        }
    }

    public function login(Request $request){
        $driver = Driver::where('email', $request->email)->first();
        if(!empty($driver)){
            if(Hash::check($request->password, $driver->password)){
                (!empty($driver->max_penumpang) ? $isComplete = true : $isComplete = false);

                $driver->update([ 'fcm_token' => $request->fcm_token ]);

                if($driver->role == 2){
                    return response()->json([
                        'message' => 'success',
                        'driver_id' => $driver->id,
                        'isComplete' => $isComplete
                    ], 200);
                } else if($driver->role==4) {
                    return response()->json([
                        'message' => 'pending',
                        'driver_id' => $driver->id,
                        'isComplete' => $isComplete
                    ]);
                } else {
                    return response()->json([
                        'message' => 'false'
                    ]);
                }
            } else {
                return response()->json([
                    'message' => 'false',
                ], 200);
            }
        } else {
            return response()->json([
                'message' => 'false'
            ]);
        }
    }

    public function complete(Request $request){
        $driver = Driver::where('id', $request->id)->first();
        $images = new Image;

        $driver->max_penumpang = $request->max_penumpang;
        $driver->gender_penumpang = $request->gender_penumpang;
        $driver->alamat = $request->alamat;
        $driver->city = $request->city;

        $file     = $request->file('mobil');
        $filename = $driver->id.sha1(time()) . "." . $file->getClientOriginalExtension();
        $request->file('mobil')->move("img/mobil", $filename);
        $images->driver_id = $driver->id;
        $images->images = $filename;
        $images->save();

        $driver->save();

        return response()->json([
            'message' => 'success'
        ]);
    }

    public function updateProfile(Request $request){
        $driver = Driver::find($request->driverId);

        $driver->update([
            'phone'  => $request->phone,
            'max_penumpang' => $request->max_penumpang,
            'gender_penumpang' => $request->gender_penumpang,
            'alamat' => $request->alamat,
            'tujuan' => $request->tujuan,
            'city' => $request->city
        ]);

        return response()->json([
            'message'   => 'success'
        ], 200);
    }

    public function updateMobil(Request $request){
        $driver = Driver::find($request->driverId);

        $imagePath = 'img/mobil/' . $driver->image->images;
        if(File::exists($imagePath)) File::delete($imagePath);

        $imageName = $driver->image->id.sha1(time()) . '.' . $request->file('carImage')->getClientOriginalExtension();
        $request->file('carImage')->move('img/mobil', $imageName);

        $driver->update([
            'tipe_mobil' => $request->carType,
            'nopol'      => $request->nopol,
        ]);

        $img = $driver->image;
        $img->update(['images' => $imageName]);

        return response()->json([
            'message' => 'success',
        ], 200);
    }

    public function resetpassword(Request $request){
        $user = Driver::where('email', $request->email)->first();
        if(empty($user)){
            return response()->json([
                'message' => 'Email tidak terdaftar'
            ], 200);
        } else {
            Mail::to($request->email)->send(new ResetPassword($user));

            return response()->json([
                'message' => 'success'
            ], 200);
        }
    }

    public function info(Request $request){
        $driver = Driver::where('id', $request->id)->first();
        if(!empty($driver)){
            if(!empty($driver->image)){
                return response()->json([
              'id' => $driver->id,
              'name' => $driver->name,
              'email' => $driver->email,
              'phone' => $driver->phone,
              'nopol' => $driver->nopol,
              'tipe_mobil' => $driver->tipe_mobil,
              'max_penumpang' => $driver->max_penumpang,
              'tujuan' => $driver->tujuan,
              'alamat' => $driver->alamat,
              'gender_penumpang' => $driver->gender_penumpang,
              'city' => $driver->city,
              'avatar' => "img/driver/" . $driver->avatar,
              'foto_mobil' => "img/mobil/" . $driver->image->images
            ]);
            } else {
                return response()->json([
                  'id' => $driver->id,
                  'name' => $driver->name,
                  'email' => $driver->email,
                  'phone' => $driver->phone,
                  'nopol' => $driver->nopol,
                  'tipe_mobil' => $driver->tipe_mobil,
                  'max_penumpang' => $driver->max_penumpang,
                  'tujuan' => $driver->tujuan,
                  'alamat' => $driver->alamat,
                  'gender_penumpang' => $driver->gender_penumpang,
                  'city' => $driver->city,
                  'avatar' => "img/driver/" . $driver->avatar
                ]);
                }
        } else {
            return response()->json([
                'message' => 'fails'
            ]);
        }
    }

    public function allDriver(){
        $drivers = Driver::all();

        if(empty($drivers)){
            abort(404);
        } else {
            foreach($drivers as $driver){
                $variable['id'] = $driver->id,
                $variable['name'] = $driver->name;
                $variable['email'] = $driver->email;
                $variable['phone'] = $driver->phone;
                $variable['nopol'] = $driver->nopol;
                $variable['tipe_mobil'] = $driver->tipe_mobil;
                $variable['max_penumpang'] = $driver->max_penumpang;
                $variable['tujuan'] = $driver->tujuan;
                $variable['alamat'] = $driver->alamat;
                $variable['gender_penumpang'] = $driver->gender_penumpang;
                $variable['city'] = $driver->city;
                $variable['avatar'] = "img/driver/".$driver->avatar;
                ( !empty($driver->image) ? $variable['foto_mobil'] = "img/mobil/".$driver->image->images : $variable['foto_mobil'] = null );

                $result[] = $variable;
            }
        }

        return response()->json(
            $result
        );
    }

    public function logout(Request $request){
        $driver = Driver::where('id', $request->id)->first();
        if(!empty($driver)){
            $driver->fcm_token = "";
            $driver->save();
            return response()->json([
                'message' => 'success'
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

    public function notification(Request $request){
        $notifications = Notification::where('role', 2)->get();

        foreach ($notifications as $key => $notification) {
           $variable['created_at'] = $notification->created_at;
           $variable['message']    = $notification->message;
           $variable['type']       = $notification->type;
           $variable['id']         = $notification->second_id;
           $result[] = $variable;
        }

        return response()->json([
            $result
        ]);
    }

    public function updatePassword(Request $request){
        $driver = Driver::where('email', $request->email)->first();
        if(Hash::check($request->old_password, $driver->password)){
            $driver->password = bcrypt($request->new_password);
            $driver->save();
            return response()->json([
                'message' => 'true'
            ]);
        } else {
            return response()->json([
                'message' => 'error'
            ]);
        }
    }

}
