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

        return view('orderInfo')->with(compact('Order'));
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




    /* 
    
    ====== API ========
    
    */




    public function userOrder(Request $request){

        //driverId, userId, destination, pickupPoint, longContract,  price

        $order = new Order;
        $order->user_id = $request->userId;
        $order->driver_id = $request->driverId;
        $order->destination = $request->destination;
        $order->pickup_point = $request->pickupPoint;
        $order->plan = $request->longContract;
        $order->price = $request->price;
        $order->save();

        return response()->json([
            'message' => 'success'
        ]);
        
    }

    public function searchByOrderId(Request $request){
        $order = Order::where('id', $request->id)->first();
        
        if(!$order){
            return response()->json([
                'message' => 'false'
            ]);
        } else {
            return response()->json([
                'message' => 'success',
                'userId' => $order->user_id,
                'driverId' => $order->driver_id,
                'destination' => $order->destination,
                'pickupPoint' => $order->pickup_point,
                'longContract' => $order->plan,
                'price' => $order->price
            ]);
        }

    }

    public function cekLangganan(Request $request){
        $orders = Order::where('user_id', $request->id)->get();

        if(empty($orders)){
            return response()->json([
                'messages' => 'false'
            ]);
        } else {
            foreach($orders as $order){
                $variable['user_id'] = $order->user_id;
                $variable['driver_id'] = $order->driver_id;
                $result[] = $variable;
            }
            return response()->json(
                $result
            );

        }
    }

    public function pendingView(Request $request){
        $orders = Order::where('driver_id', $request->id)->where('status', 0)->get();
        if(count($orders) <= 0 ){
            return response()->json([
                'message' => 'fails'
            ]);
        } else {
            foreach($orders as $order){
                $var['userId'] = $order->user_id;
                $var['orderId'] = $order->id;
                $result[] = $var;
            }
            return response()->json(
                $result
            );
        }
    }

    public function validateOrder(Request $request){
        $order = Order::where('id', $request->orderId)->first();
        $order->status = $request->isAccept;
        $order->reason = $request->reason;
        $order->save();
        return response()->json([
            'message' => 'success'
        ]);
    }


}
