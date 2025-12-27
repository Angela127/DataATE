<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $table = 'rental';

    protected $fillable = [
        'customer_id',
        'plate_no',
        'payment_id',
        'start_time',
        'end_time',
        'pick_up_location',
        'return_location',
        'destination',
        'car_condition_pickup',
        'car_description_pickup',
        'agreement_form',
        'car_condition_return',
        'car_description_return',
        'inspection_form',
        'rating',
        'return_feedback',
        'document_signed',
        'reject_status',
        'reject_reason',
        'verification_status',
        'payment_status',
        'pickup_lat', 'pickup_lng',
        'destination_lat', 'destination_lng',
        'return_lat', 'return_lng',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class, 'plate_no', 'plate_no');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'customer_id', 'id'); // Assuming customer_id maps to user->id based on controller usage
    }

    public function customer()
    {
         return $this->belongsTo(Customer::class, 'customer_id', 'user_id'); // If mapping to customer table
    }
}
