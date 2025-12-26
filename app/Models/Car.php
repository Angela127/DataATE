<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    //table name
    protected $table = 'car';
    
    protected $primaryKey = 'plate_no';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'plate_no',
        'model',
        'production_year',
        'engine',
        'engine_cc',
        'fuel_type',
        'transmission',
        'drive_type',
        'top_speed',
        'max_power',
        'max_torque',
        'price_hour',
        'availability_status',
        'active_status',
        'fuel_level',
        'car_mileage',
        'image_path',
    ];
}
