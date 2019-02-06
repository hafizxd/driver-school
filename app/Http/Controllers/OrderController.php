<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Order;
use App\Child;

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

        //driverId, userId, destination, pickupPoint, longContract,  price, note, namaAnak

        $order = new Order;
        $order->user_id = $request->userId;
        $order->driver_id = $request->driverId;
        $order->destination = $request->destination;
        $order->pickup_point = $request->pickupPoint;
        $order->plan = $request->longContract;
        $order->price = $request->price;
        $order->note = $request->note;
        $order->nama_anak = $request->namaAnak;
        $order->start_date = $request->start_date;
        $order->end_date = $request->end_date;
        $order->save();

        foreach($request->namaAnak as $key => $child){
            Child::create([
                'name'    => $child,
                'user_id' => $order->user->id
            ]);
        }

        return response()->json([
            'message' => 'success'
        ]);

    }

    public function searchByOrderId(Request $request){
        $order = Order::where('id', $request->id)->first();

        if(!$order){
            return response()->json([
                'message' => 'error'
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
                'messages' => 'error'
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

    public function pendingView($id){
        $orders = Order::where('driver_id', $id)->where('status', 0)->get();

        if(count($orders) <= 0){
            return response()->json([
                'message' => 'error'
            ]);
        }

        foreach ($orders as $orderInfo) {
            foreach ($orderInfo->childs as $key => $child) {
                $children[$key] = $child->name;
            }

            $varUser['name'] = $orderInfo->user->name;
            $varUser['email'] = $orderInfo->user->email;
            $varUser['phone'] = $orderInfo->user->phone;
            $varUser['address'] = $orderInfo->user->address;
            $varUser['avatar'] = "/img/user/". $orderInfo->user->avatar;
            $users[] = $varUser;

            $varOrder['driverId'] =  $orderInfo->driver_id;
            $varOrder['userId'] =  $orderInfo->user_id;
            $varOrder['price'] =  $orderInfo->price;
            $varOrder['longContract'] =  $orderInfo->plan;
            $varOrder['note'] =  $orderInfo->note;
            $varOrder['pickupPoint'] =  $orderInfo->pickup_point;
            $varOrder['destination'] =  $orderInfo->destination;
            $varOrder['createdAt'] =  $orderInfo->start_date;
            $varOrder['expiratedAt'] =  $orderInfo->end_date;
            $varOrder['children'] = $children;
            $order[] = $varOrder;

        }

        foreach ($users as $key => $user) {
            $varDriver['user'] = $user;
            $varDriver['order'] = $order[$key];
            $drivers[$key] = $varDriver;
        }

        return response()->json([
            'message' => 'success',
            'orders'   => $drivers,
        ]);
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

    public function order(Request $request){
        $orders = Order::where('driver_id', $request->id)->where('status', 1)->get();

        if(count($orders) <= 0){
            return response()->json([
                'message' => 'error'
            ]);
        }

        foreach ($orders as $orderInfo) {
            foreach ($orderInfo->childs as $key => $child) {
                $children[$key] = $child->name;
            }

            $varUser['name'] = $orderInfo->user->name;
            $varUser['email'] = $orderInfo->user->email;
            $varUser['phone'] = $orderInfo->user->phone;
            $varUser['address'] = $orderInfo->user->address;
            $varUser['avatar'] = "/img/user/". $orderInfo->user->avatar;
            $users[] = $varUser;

            $varOrder['driverId'] =  $orderInfo->driver_id;
            $varOrder['userId'] =  $orderInfo->user_id;
            $varOrder['price'] =  $orderInfo->price;
            $varOrder['longContract'] =  $orderInfo->plan;
            $varOrder['note'] =  $orderInfo->note;
            $varOrder['pickupPoint'] =  $orderInfo->pickup_point;
            $varOrder['destination'] =  $orderInfo->destination;
            $varOrder['createdAt'] =  $orderInfo->start_date;
            $varOrder['expiratedAt'] =  $orderInfo->end_date;
            $varOrder['children'] = $children;
            $order[] = $varOrder;

        }

        foreach ($users as $key => $user) {
            $varDriver['user'] = $user;
            $varDriver['order'] = $order[$key];
            $drivers[$key] = $varDriver;
        }

        return response()->json([
            'message' => 'success',
            'orders'   => $drivers,
        ]);
    }


}
