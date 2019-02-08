<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Driver;
use App\User;
use Faker\Factory as Faker;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        // $faker = Faker::create();
        // dd($faker->image($dir = null, $width = 400 , $height = 200, 'cats', false));

        $Users = User::where('role', 1)->orderBy('created_at', 'DESC')->paginate(5);
        $UsersBlocked = User::where('role', 0)->orderBy('created_at', 'DESC')->paginate(5);

        $Drivers = Driver::where('role', 2)->orderBy('created_at', 'DESC')->paginate(5);
        $DriversBlocked = Driver::where('role', 0)->orderBy('created_at', 'DESC')->paginate(5);
        $DriversPending = Driver::where('role', 4)->orderBy('created_at', 'DESC')->paginate(5);

        return view('home')->with(compact('Users', 'UsersBlocked', 'Drivers', 'DriversBlocked', 'DriversPending'));
    }
}
