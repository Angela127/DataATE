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
        'price_hour',
        'availability_status',
        'fuel_level',
        'car_mileage',
    ];
}
