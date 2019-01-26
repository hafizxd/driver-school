<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

class OrderController extends Controller
{
    
    public function index(){
        $orders = Order::all();

        return view('order')->with('orders');
    }


}
