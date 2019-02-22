<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Order;
use App\Child;
use App\Notification;

class OrderController extends Controller
{

    public function __construct(){
        $ordersPending = Order::where('status', '!=', 1)->get();
        $ordersActive  = Order::where('status', 1)->get();

        foreach ($ordersPending as $key => $order) {
            $currentDate = Carbon::now();
            if($order->start_date > $currentDate){
                Order::destroy($order->id);
            }
        }
        foreach ($ordersActive as $key => $order) {
            $currentDate = Carbon::now();
            if($order->start_date > $currentDate){
                $order->update([ 'active', 1 ]);
            }
        }
    }

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
        Order::where('id',$request->id)->update([
            'destination' => $request->destination,
            'pickup_point'   => $request->pickup_point,
            'note' => $request->note
        ]);

        return back();
    }

    public function cancelWeb(Request $request){
        $order = Order::where('id', $request->id)->first();
        $order->delete();
        return redirect()->route('order');
    }

    public function orderSearch(Request $request){
        // return Order::where('user_id', 'LIKE', '%'.$request->name.'%')->orWhere('destination', 'LIKE', '%'.$request->name.'%')->get();
        return DB::table('orders')
               ->select('orders.user_id', 'users.name AS user_name', 'drivers.name AS driver_name', 'orders.destination', 'orders.id AS order_id')
               ->join('users', 'orders.user_id', '=', 'users.id')
               ->join('drivers', 'orders.driver_id', '=', 'drivers.id')
               ->where('users.name', 'LIKE', '%'.$request->name.'%')
               ->orWhere('orders.destination', 'LIKE', '%'.$request->name.'%')
               ->get();
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
        $order->note = $request->note;
        $order->start_date = $request->start_date;
        $order->end_date = $request->end_date;
        $order->save();

        foreach($request->children as $key => $child){
            Child::create([
                'name'     => $child,
                'user_id'  => $order->user->id,
                'order_id' => $order->id
            ]);
        }

        $order = Order::where('user_id', $request->userId)->where('driver_id', $request->driverId)->where('plan', $request->longContract)->first();

        $this->notif(' ',
            'Ada pesanan masuk dari user ' . $order->user->name,
            array($order->driver->fcm_token),
            'biasa',
            $order->id);

        Notification::create([
            'foreign_id'  => $order->driver->id,
            'message'     => 'Ada pesanan masuk dari user ' . $order->user->name,
            'type'        => 'biasa',
            'role'        => 2,
            'second_id'   => $order->id
        ]);

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
                 foreach ($order->childs as $key => $child) {
                     $children[$key] = $child->name;

                }


                 $temp = array(
                     'message' => 'success',
                     'driverId' => $order->driver_id,
                     'userId' => $order->user_id,
                     'orderId' => $order->id,
                     'price' => $order->price,
                     'longContract' => $order->plan,
                     'note'      => $order->note,
                     'pickupPoint' => $order->pickup_point,
                     'destination' => $order->destination,
                     'createdAt' => $order->start_date,
                     'expiredAt' => $order->end_date,
                     'children' => $children
                 );



            return response()->json(
                $temp
            );
        }

    }

    public function cekLangganan(Request $request){

        $orders = Order::where('user_id', $request->id)->where('status', 1)->get();

        if(count($orders) <= 0){
            return response()->json([
                'message' => 'error'
            ]);
        }

        foreach ($orders as $orderInfo) {
            foreach ($orderInfo->childs as $key => $child) {
                $children[$key] = $child->name;
            }

            $varDriver['name'] = $orderInfo->driver->name;
            $varDriver['email'] = $orderInfo->driver->email;
            $varDriver['phone'] = $orderInfo->driver->phone;
            $varDriver['nopol'] = $orderInfo->driver->nopol;
            $varDriver['tipe_mobil'] = $orderInfo->driver->tipe_mobil;
            $varDriver['max_penumpang'] = $orderInfo->driver->max_penumpang;
            $varDriver['tujuan'] = $orderInfo->driver->tujuan;
            $varDriver['alamat'] = $orderInfo->driver->alamat;
            $varDriver['gender_penumpang'] = $orderInfo->driver->gender_penumpang;
            $varDriver['tujuan'] = $orderInfo->driver->tujuan;
            $varDriver['avatar'] = "/img/driver/". $orderInfo->driver->avatar;
            $varDriver['foto_mobil'] = "/img/mobil/". $orderInfo->driver->image->images;
            $drivers[] = $varDriver;

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

        foreach ($order as $key => $orderrr) {
            $varResult['driver'] = $drivers[$key];
            $varResult['order'] = $orderrr;
            $result[$key] = $varResult;
        }

        return response()->json([
            'message' => 'success',
            'orders'  =>  $result,
        ]);
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

            $varOrder['orderId'] = $orderInfo->id;
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

        if($request->isAccept == 0){
            $this->notif(' ',
                'Pesanan anda kepada driver ' . $order->driver->name . ' telah ditolak oleh driver.',
                array($order->user->fcm_token),
                'biasa',
                $order->id);

            Notification::create([
                'foreign_id'  => $order->user->id,
                'message'     => 'Pesanan anda kepada driver ' . $order->driver->name . ' telah ditolak oleh driver.',
                'type'        => 'biasa',
                'role'        => 1,
                'second_id'   => $order->id
            ]);

            $order->status = 2;
            $order->reason = $request->reason;
            $order->save();
        } else {
            $seatUsed = 0;
            $orders = $order->driver->orders;
            foreach ($orders as $key => $order) {
                if($order->status == 1){
                    foreach ($order->childs as $key => $childs) {
                        $seatUsed += 1;
                    }
                }
            }

            $availableSeat = $order->driver->max_penumpang - $seatUsed;
            dd($availableSeat);
            if($availableSeat < $order->childs){
                return reaponse()->json([
                    'message' => 'sudah penuh'
                ]);
            }

            $this->notif(' ',
                'Pesanan anda kepada driver ' . $order->driver->name . ' telah diterima oleh driver.',
                array($order->user->fcm_token),
                'accepted_order_by_driver',
                $order->id);

            Notification::create([
                'foreign_id'  => $order->user->id,
                'message'     => 'Pesanan anda kepada driver ' . $order->driver->name . ' telah diterima oleh driver.',
                'type'        => 'accepted_order_by_driver',
                'role'        => 1,
                'second_id'   => $order->id
            ]);

            $order->price  = $request->price;
            $order->pickupTime = $request->pickupTime;

            $order->save();
        }

        return response()->json([
            'message' => 'success'
        ]);
    }

    public function userValidateOrder(Request $request){
        $order = Order::where('id', $request->orderId)->first();

        if($request->isAccept == 0){
            $this->notif(' ',
                'Pesanan user ' . $order->user->name . ' kepada anda telah dibatalkan.',
                array($order->driver->fcm_token),
                'biasa',
                $order->id);

            Notification::create([
                'foreign_id'  => $order->driver->id,
                'message'     => 'Pesanan user ' . $order->user->name . ' kepada anda telah dibatalkan.',
                'type'        => 'biasa',
                'role'        => 2,
                'second_id'   => $order->id
            ]);

            Order::destroy($order->id);
        } else {
            $startDate = $order->start_date;
            $endDate   = $order->end_date;

            $this->notif(' ',
                'Pesanan user ' . $order->user->name . ' kepada anda telah diterima oleh user. Sekarang kontrak anda akan berjalan mulai tanggal ' . $startDate->toFormattedDateString . ' sampai tanggal ' . $endDate->toFormattedDateString . '.',
                array($order->driver->fcm_token),
                'biasa',
                $order->id);

            Notification::create([
                'foreign_id'  => $order->driver->id,
                'message'     => 'Pesanan user ' . $order->user->name . ' kepada anda telah diterima oleh user. Sekarang kontrak anda akan berjalan mulai tanggal ' . $startDate->toFormattedDateString . ' sampai tanggal ' . $endDate->toFormattedDateString . '.',
                'type'        => 'biasa',
                'role'        => 2,
                'second_id'   => $order->id
            ]);

            $order->update([ 'status' => 1 ]);
        }

        return response()->json([
            'message' => 'success'
        ]);
    }

    public function userCancelOrder(Request $request){
        $order = Order::where('id', $orderId)->first();

        $this->notif(' ',
            'User ' . $order->user->name . ' meminta pemberhentian kontrak dengan anda.',
            array($order->driver->fcm_token),
            'request_cancel_order',
            $order->id);

        Notification::create([
            'foreign_id'  => $order->driver->id,
            'message'     => 'User ' . $order->user->name . ' meminta pemberhentian kontrak dengan anda.',
            'type'        => 'request_cancel_order',
            'role'        => 2,
            'second_id'   => $order->id
        ]);

        $order->update([ 'reason', $request->reason ]);

        return response()->json([
            'message' => 'success'
        ]);
    }

    public function driverCancelOrder(Request $request){
        $order = Order::where('id', $request->orderId)->first();

        if ($request->isAccept == 0){
            $this->notif(' ',
                'Driver ' . $order->driver->name . ' menolak permintaan pemberhentian kontrak anda.',
                array($order->user->fcm_token),
                'biasa',
                $order->id);

            Notification::create([
                'foreign_id'  => $order->user->id,
                'message'     => 'Driver ' . $order->driver->name . ' menolak permintaan pemberhentian kontrak anda.',
                'type'        => 'biasa',
                'role'        => 1,
                'second_id'   => $order->id
            ]);
        } else {
            $this->notif(' ',
                'Driver ' . $order->driver->name . ' telah menerima permintaan pemberhentian kontrak anda. Sekarang kontrak anda dengan driver ' . $order->driver->name . ' telah berhenti.',
                array($order->user->fcm_token),
                'biasa',
                $order->id);

            Notification::create([
                'foreign_id'  => $order->user->id,
                'message'     => 'Driver ' . $order->driver->name . ' telah menerima permintaan pemberhentian kontrak anda. Sekarang kontrak anda dengan driver ' . $order->driver->name . ' telah berhenti.',
                'type'        => 'biasa',
                'role'        => 1,
                'second_id'   => $order->id
            ]);

            Order::destroy($order->id);
        }

        return response()->json([
            'message' => 'success'
        ]);
    }

    public function notif($title, $message, $token, $type, $orderId){
            define( 'API_ACCESS_KEY', 'AAAAmsazadk:APA91bGJWNJeVIzrzKTbcXUMHzNT3bT5KyVq8Q_aO0_Cb97N59cjkPE9N3wPOvwJI_uD63AhcWJz1ScyVkBz12TKDUDzpUqSEohZU5Xsw6Ag6rIg_3xkcVwAEttZcNh9J9WNPwNZF0xO' );
        $msg = array
        (
            "message" 	=> $message,
            "title"		=> $title
        );

        $fields = array
        (
            'registration_ids' 	=> $token,
            'data'			=> $msg
        );

        $headers = array
        (
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );

        return response()->json( $result );
    }

    public function order(Request $request){
        $orders = Order::where('driver_id', $request->driverId)->where('status', 1)->get();

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

    public function pickArea(){
        $areas = array("JAKARTA", "BOGOR", "DEPOK", "TANGERANG", "BEKASI", "BANDUNG", "BALI", "SURABAYA", "MAKASSAR", "PALEMBANG", "MEDAN", "BALIKPAPAN", "YOGYAKARTA", "SEMARANG", "MANADO", "SOLO", "SAMARINDA", "MALANG", "BATAM", "SIDOARJO", "PADANG", "PONTIANAK", "BANJARMASIN", "PEKANBARU", "JAMBI", "BANDAR LAMPUNG", "GRESIK", "MATARAM", "SUKABUMI", "PEMATANGSIANTAR", "TASIKMALAYA", "SERANG", "CIREBON", "TEGAL", "SALATIGA", "MAGELANG", "PURWOKERTO", "KEDIRI", "MADIUN", "KARAWANG", "JEMBER", "PASURUAN", "MOJOKERTO", "BANDA ACEH", "PEKALONGAN", "BUKIT TINGGI", "CILACAP", "SUMEDANG", "GARUT", "BELITUNG", "MADURA", "PROBOLINGGO", "PURWAKARTA", "BANYUWANGI", "SUBANG", "PADANGSIDEMPUAN", "METRO", "PANGKAL PINANG", "TANJUNG PINANG", "DURI", "SABANG", "KUDUS", "KEBUMEN", "UNGARAN", "TOMOHON", "BITUNG", "GORONTALO", "PALU", "GIANYAR", "TABANAN", "JOMBANG", "MERAUKE", "KENDARI", "PALOPO");
        foreach($areas as $area){
            $result[] = $area;
        }
        return response()->json(
            $result
        );
    }

    public function kirimWoe($token, $title, $message){

        define( 'API_ACCESS_KEY', 'AAAA-qBl5vM:APA91bFC7xt4sPPm9hiIEoVO2eNWFvK6CmYhbjpAslrmG_9CmQ-cpsS_lWGBHd0soaSdc0Pj4zO6psrJW7UnYlL0ekvqrsj4k6hrzWIJgy4bmLfa3R1kjAjkDMUJ42WXX0LjPj6OBnCw' );

        $msg = array
        (
            "message" 	=> $message,
            "title"		=> $title
        );

        $fields = array
        (
            'registration_ids' 	=> $token,
            'data'			=> $msg
        );

        $headers = array
        (
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
        echo $result;

        return response()->json( $result );
    }

}
