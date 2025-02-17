<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class HomeRouteController extends Controller
{

    public function home_menu()
    {
        return view('dashboard'); 
    }
}
