<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Driver;

class DriverController extends Controller
{
    public function index(){
        $Drivers = Driver::where('role', 2)->orderBy('created_at', 'DESC')->get();
        $DriversBlocked = Driver::where('role', 0)->orderBy('created_at', 'DESC')->get();

        return view('Driver')->with(compact('Drivers', 'DriversBlocked'));
    }


    public function show($id){
        $Drivers = Driver::where('id', $id)->first();

        return view('DriverInfo')->with(compact('Drivers'));
    }


    public function update(Request $request, $id){
        if(!empty($request->avatar)){
            $this->validate($request, [
              'avatar' => 'mimes:jpg,jpeg,png'
            ]);
            $fileName = time() . '.png';
            $request->file('avatar')->storeAs('public/blog/', $fileName);
        } else {
            $Driver   = Driver::where('id', $id)->first();
            $fileName = $Driver->avatar;
        }

        Driver::findOrFail($id)->update([
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


    public function login(Request $request){
        $user = Driver::where('email', $request->email)->where('role', 2)->first();
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
