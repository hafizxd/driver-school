<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use App\Driver;

class ImageController extends Controller
{
    public function store($id, Request $request){
        $this->validate($request, [
            'image' => 'required|mimes:jpg,jpeg,png'
        ]);
        $fileName = time() . '.png';
        $request->file('image')->storeAs('public/blog/' , $fileName);
        $Driver = Driver::where('id', $id)->first();

        $image = new Image();
        $image->driver_id = $id;
        $image->images    = $fileName;
        $image->save();

        return back();
    }


    public function destroy($id){
        Image::destroy($id);

        return back();
    }


    public function update($id, Request $request){
        $this->validate($request, [
            'image' => 'required|mimes:jpg,jpeg,png'
        ]);
        $fileName = time() . '.png';
        $request->file('image')->storeAs('public/blog/', $fileName);
        Image::find($id)->update([
            'images' => $fileName
        ]);

        return back();
    }
}
