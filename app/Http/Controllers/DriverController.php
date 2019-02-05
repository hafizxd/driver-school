<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\RegisterDriver;
use App\Mail\ResetPassword;
use App\Driver;
use App\Image;
use File;

class DriverController extends Controller
{

    public function index(){
        $Drivers = Driver::where('role', 2)->orderBy('created_at', 'DESC')->get();
        $DriversBlocked = Driver::where('role', 0)->orderBy('created_at', 'DESC')->get();
        $DriversPending = Driver::where('role', 4)->orderBy('created_at', 'DESC')->get();

        return view('Driver')->with(compact('Drivers', 'DriversBlocked', 'DriversPending'));
    }

    public function block($id){
        $Driver = Driver::find($id);
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
        Driver::where('id', $id)->update([
            'role' => 2
        ]);

        $driver = Driver::where('id', $id)->first();
        Mail::to($driver->email)->send(new RegisterDriver($driver));

        return redirect('/driver');
    }


    public function decline($id){
        Driver::destroy($id);

        return redirect('/driver');
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
            $driver = new Driver;
            $driver->name = $request->name;
            $driver->email = $request->email;
            $driver->nopol = $request->nopol;
            $driver->phone = $request->phone;
            $driver->tipe_mobil = $request->tipe_mobil;

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
                if($driver->role == 2){
                    return response()->json([
                        'message' => 'success',
                        'driver_id' => $driver->id
                    ], 200);
                } else {
                    return response()->json([
                        'message' => 'pending'
                    ]);
                }
            } else {
                return response()->json([
                    'message' => 'false',
                ], 401);
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
        $driver->tujuan = $request->tujuan;

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

        $imagePath = 'img/driver/' . $driver->avatar;
        if(File::exists($imagePath)) File::delete($imagePath);

        $fileName = $driver->id.sha1(time()) . "." . $request->file('avatar')->getClientOriginalExtension();
        $request->file('avatar')->move('img/driver', $fileName);

        $driver->update([
            'phone'  => $request->phone,
            'max_penumpang' => $request->max_penumpang,
            'gender_penumpang' => $request->gender_penumpang,
            'alamat' => $request->alamat,
            'tujuan' => $request->tujuan,
            'avatar' => $fileName
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
            ], 401);
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
            return response()->json([
              'name' => $driver->name,
              'email' => $driver->email,
              'phone' => $driver->phone,
              'nopol' => $driver->nopol,
              'tipe_mobil' => $driver->tipe_mobil,
              'max_penumpang' => $driver->max_penumpang,
              'tujuan' => $driver->tujuan,
              'alamat' => $driver->alamat,
              'gender_penumpang' => $driver->gender_penumpang,
              'avatar' => "img/user/" . $driver->avatar,
              'foto_mobil' => "img/mobil/" . $driver->image->images
            ]);
        } else {
            return response()->json([
                'message' => 'fails'
            ]);
        }
    }

    public function allDriver(){
        $drivers = Driver::get();

        foreach($drivers as $driver){
            $variable['name'] = $driver->name;
            $variable['tujuan'] = $driver->tujuan;
            $variable['max_penumpang'] = $driver->max_penumpang;
            $result[] = $variable;
        }
        return response()->json(
            $result
        );
    }

}
