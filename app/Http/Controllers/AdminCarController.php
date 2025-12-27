<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class AdminCarController extends Controller
{
    public function index(Request $request)
{
    $query = Car::orderBy('created_at', 'desc');

    if ($search = $request->input('q')) {
        $query->where(function ($q) use ($search) {
            $q->where('plate_no', 'like', '%' . $search . '%')
              ->orWhere('model', 'like', '%' . $search . '%');
        });
    }

    $cars = $query->get();

    return view('admin.cars.index', compact('cars'));
}

    public function create()
    {
        return view('admin.cars.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plate_no'            => 'required|string|max:10|unique:car,plate_no',
            'model'               => 'required|string|max:255',
            'production_year'     => 'nullable|integer|min:1900|max:'.date('Y'),
            'engine'              => 'nullable|string|max:100',
            'engine_cc'           => 'nullable|integer|min:0',
            'fuel_type'           => 'nullable|string|max:50',
            'transmission'        => 'nullable|string|max:50',
            'drive_type'          => 'nullable|string|max:50',
            'top_speed'           => 'nullable|integer|min:0',
            'max_power'           => 'nullable|integer|min:0',
            'max_torque'          => 'nullable|integer|min:0',
            'price_hour'          => 'required|numeric|min:0',
            'fuel_level'          => 'required|integer|min:0|max:100',
            'car_mileage'         => 'required|integer|min:0',
            'availability_status' => 'required|boolean',
            'active_status'       => 'required|boolean',
            'image'               => 'nullable|image|max:2048',
        ]);

        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('cars', 'public')
            : null;

        Car::create([
            'plate_no'            => $validated['plate_no'],
            'model'               => $validated['model'],
            'production_year'     => $validated['production_year'] ?? null,
            'engine'              => $validated['engine'] ?? null,
            'engine_cc'           => $validated['engine_cc'] ?? null,
            'fuel_type'           => $validated['fuel_type'] ?? null,
            'transmission'        => $validated['transmission'] ?? null,
            'drive_type'          => $validated['drive_type'] ?? null,
            'top_speed'           => $validated['top_speed'] ?? null,
            'max_power'           => $validated['max_power'] ?? null,
            'max_torque'          => $validated['max_torque'] ?? null,
            'price_hour'          => $validated['price_hour'],
            'fuel_level'          => $validated['fuel_level'],
            'car_mileage'         => $validated['car_mileage'],
            'availability_status' => $validated['availability_status'],
            'active_status'       => $validated['active_status'],
            'image_path'          => $imagePath,
        ]);

        return redirect()->route('admin.cars.index')
                         ->with('success', 'Car created.');
    }

    public function edit($plate_no)
    {
        $car = Car::findOrFail($plate_no);

        return view('admin.cars.edit', compact('car'));
    }

    public function update(Request $request, $plate_no)
    {
        $car = Car::findOrFail($plate_no);

        $validated = $request->validate([
            'model'               => 'required|string|max:255',
            'production_year'     => 'nullable|integer|min:1900|max:'.date('Y'),
            'engine'              => 'nullable|string|max:100',
            'engine_cc'           => 'nullable|integer|min:0',
            'fuel_type'           => 'nullable|string|max:50',
            'transmission'        => 'nullable|string|max:50',
            'drive_type'          => 'nullable|string|max:50',
            'top_speed'           => 'nullable|integer|min:0',
            'max_power'           => 'nullable|integer|min:0',
            'max_torque'          => 'nullable|integer|min:0',
            'price_hour'          => 'required|numeric|min:0',
            'fuel_level'          => 'required|integer|min:0|max:100',
            'car_mileage'         => 'required|integer|min:0',
            'availability_status' => 'required|boolean',
            'active_status'       => 'required|boolean',
            'image'               => 'nullable|image|max:2048',
        ]);

        $imagePath = $car->image_path;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cars', 'public');
        }

        $car->update([
            'model'               => $validated['model'],
            'production_year'     => $validated['production_year'] ?? null,
            'engine'              => $validated['engine'] ?? null,
            'engine_cc'           => $validated['engine_cc'] ?? null,
            'fuel_type'           => $validated['fuel_type'] ?? null,
            'transmission'        => $validated['transmission'] ?? null,
            'drive_type'          => $validated['drive_type'] ?? null,
            'top_speed'           => $validated['top_speed'] ?? null,
            'max_power'           => $validated['max_power'] ?? null,
            'max_torque'          => $validated['max_torque'] ?? null,
            'price_hour'          => $validated['price_hour'],
            'fuel_level'          => $validated['fuel_level'],
            'car_mileage'         => $validated['car_mileage'],
            'availability_status' => $validated['availability_status'],
            'active_status'       => $validated['active_status'],
            'image_path'          => $imagePath,
        ]);

        return redirect()->route('admin.cars.index')
                         ->with('success', 'Car updated.');
    }

    public function destroy($plate_no)
    {
        $car = Car::findOrFail($plate_no);
        $car->delete();

        return redirect()->route('admin.cars.index')
                         ->with('success', 'Car deleted.');
    }
}