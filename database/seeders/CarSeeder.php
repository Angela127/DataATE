<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        // 先清空原有資料，避免重複（開發階段這樣做比較乾淨）
        Car::truncate();

        // 這裡開始「把全部 car model upload 上去」
        // 先用你現在的 4 輛車當示範，之後你可以繼續補更多真實 data

        Car::create([
            'plate_no' => 'ABC 4321',
            'model' => 'Honda Beat 110',
            'price_hour' => 1.00,
            'availability_status' => false, // Not Available
            'fuel_level' => 3,
            'car_mileage' => 100,
            'image_path' => 'image/car-beat-110.png',
        ]);

        Car::create([
            'plate_no' => 'JJY 8722',
            'model' => 'Perodua Axia 2014',
            'price_hour' => 3.00,
            'availability_status' => true, // Available
            'fuel_level' => 3,
            'car_mileage' => 100,
            'image_path' => 'image/car-axia-2014.png',
        ]);

        Car::create([
            'plate_no' => 'JXM 1109',
            'model' => 'Perodua Bezza 2013',
            'price_hour' => 6.00,
            'availability_status' => true, // Available
            'fuel_level' => 6,
            'car_mileage' => 200,
            'image_path' => 'image/car-bezza-2013.png',
        ]);

        Car::create([
            'plate_no' => 'LSY 8955',
            'model' => 'Honda Dash 125',
            'price_hour' => 2.00,
            'availability_status' => true, // Available
            'fuel_level' => 3,
            'car_mileage' => 150,
            'image_path' => 'image/car-dash-125.png',
        ]);

         Car::create([
            'plate_no' => 'xxz 2711',
            'model' => 'Honda Dash 125',
            'price_hour' => 2.00,
            'availability_status' => false, // Not Available
            'fuel_level' => 3,
            'car_mileage' => 150,
            'image_path' => 'image/car-dash-125.png',
        ]);

        // TODO: 接下來就是你 teammate 說的「research 真的 data」
        // 例如你可以再加幾輛 Myvi / Bezza / Saga / City 等
        // Car::create([...]);
        // Car::create([...]);
    }
}