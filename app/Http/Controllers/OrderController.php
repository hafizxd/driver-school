<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Order;

class OrderController extends Controller
{

    public function index(){
        $orders = Order::where('status', 1)->orderBy('created_at', 'DESC')->get();
        $ordersBelum = Order::where('status', 0)->orderBy('created_at', 'DESC')->get();

        return view('order')->with(compact('orders', 'ordersBelum'));
    }


    public function show($id){
        $Order = Order::where('id', $id)->first();

        return view('orderInfo')->with(compact('Order', 'TimeStart'));
    }


    public function update(Request $request){
        Order::find($request->id)->update([
            'plan'       => $request->plan,
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date
        ]);

        $Order = Order::where('id', $request->id)->first();

        $Order->user->update([
            'name' => $request->pelanggan,
        ]);

        $Order->driver->update([
            'name' => $request->supir
        ]);

        foreach ($Order->childs as $key => $child) {
            $child->name = $request->childs[++$key];
            $child->save();
        }

        return back();
    }


}
