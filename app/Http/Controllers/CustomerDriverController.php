<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Driver;
use App\User;

class CustomerDriverController extends Controller
{
    public function indexcustomer(){
      $customer = User::where('role', 2)->orderBy('created_at', 'DESC')->get();
      return view ('customerdriver.customer')->compact('customer');
    }

    public function showcustomer($id){
      $customer = Customer::where('id', $id)->first();

      return view ('customerdriver.profilecustomer', ['customers' => $customer]);
    }




    public function indexdriver(){
      $driver = Driver::orderBy('name')->get();
      return view ('customerdriver.driver', ['drivers' => $driver]);
    }

    public function showdriver($id){
      $driver = Driver::where('id', $id)->first();

      return view ('customerdriver.profiledriver', ['drivers' => $driver]);
    }
}
