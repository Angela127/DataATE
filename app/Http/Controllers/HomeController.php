<?php

namespace App\Http\Controllers;

use App\Models\Car;

class HomeController extends Controller
{
    public function index()
    {

        $cars = Car::all();

        return view('mainpage', [
            'cars' => $cars,
        ]);
    }
}