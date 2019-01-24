<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Driver;

class DriverController extends Controller
{
    public function index(){
        $Drivers = Driver::where('role', 2)->orderBy('created_at', 'DESC')->get();
        $DriversBlocked = Driver::where('role', 0)->orderBy('created_at', 'DESC')->get();

        return view('Driver')->with(compact('Drivers', 'DriversBlocked'));
    }


    public function infoWeb($id){
        $Driver = Driver::where('id', $id)->first();

        return view('driverinfo')->with(compact('Driver'));
    }


    public function update(Request $request){
        $Driver   = Driver::where('id', $request->id)->first();

        if(!empty($request->avatar)){
            $fileName = time() . '.png';
            $request->file('avatar')->storeAs('public/blog/', $fileName);
        } else {
            $fileName = $Driver->avatar;
        }

        if(!empty($request->image)){
            $imageName = time() . 'img.png';
            $request->file('image')->storeAs('public/blog/', $imageName);
        } else {
            $imageName = $Driver->image->images;
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

        $Driver->image->update([
          'images' => $imageName
        ]);

        return back();
    }

    /*

        ===== API =====

    */

    public function store(Request $request){
        $driver = Driver::where('email', $request->email)->get();

        if($driver->count() > 0){
            return response()->json([
            'success' => 'false',
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
            'success' => 'true',
            'user_id' => $driver->id
            ], 200);
        }
    }

    public function login(Request $request){
        $driver = Driver::where('email', $request->email)->where('role', 2)->first();
        if(!empty($driver)){
            if(Hash::check($request->password, $driver->password)){
                return response()->json([
                    'success' => 'true',
                    'user_id' => $driver->id
                ], 200);
            } else {
                return response()->json([
                    'success' => 'false',
                ], 401);
            }
        } else {
            return response()->json([
                'success' => 'false'
            ]);
        }
    }

    public function complete(Request $request){
        $driver = Driver::where('id', $request->id)->first();

        $driver->max_penumpang = $request->max_penumpang;
        $driver->gender_penumpang = $request->gender_penumpang;
        $driver->alamat = $request->alamat;
        $driver->tujuan = $request->tujuan;

        $driver->save();

        return response()->json([
            'success' => 'true'
        ]);
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
              'max_penumpang' => $driver->mac_penumpang,
              'tujuan' => $driver->tujuan,
              'alamat' => $driver->alamat,
              'gender_penumpang' => $driver->gender_penumpang,
              'avatar' => "img/user/" . $driver->avatar
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
