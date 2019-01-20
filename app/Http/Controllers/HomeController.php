<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Driver;
use App\User;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $Users = User::where('role', 1)->orderBy('created_at', 'DESC')->get();
        $UsersBlocked = User::where('role', 0)->orderBy('created_at', 'DESC')->get();

        $Drivers = Driver::where('role', 2)->orderBy('created_at', 'DESC')->get();
        $DriversBlocked = Driver::where('role', 0)->orderBy('created_at', 'DESC')->get();
        
        return view('home')->with(compact('Users', 'UsersBlocked', 'Drivers', 'DriversBlocked'));
    }
}
