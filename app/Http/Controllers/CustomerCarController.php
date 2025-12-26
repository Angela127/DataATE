<?php

namespace App\Http\Controllers;

use App\Models\Car;

class CustomerCarController extends Controller
{
    public function index()
    {
        $cars = Car::where('active_status', true)
                   ->where('availability_status', true)
                   ->get();

        return view('cars.index', compact('cars'));
    }

    public function show($plate_no)
    {
        $car = Car::where('plate_no', $plate_no)
                  ->where('active_status', true)
                  ->firstOrFail();

        return view('cars.show', compact('car'));
    }
}