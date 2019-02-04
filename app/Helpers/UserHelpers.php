<?php 

use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Auth;

if (!function_exists('getRole')) {
    function getRole()
    {
        return Auth::user()->role;
    }
}