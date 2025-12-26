<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $table = 'rental';

      public function car()
    {
        return $this->belongsTo(Car::class, 'plate_no', 'plate_no');
    }

    public function customer()
    {
        // Assuming 'customer_id' in rental table stores the string ID (e.g. C001)
        // and 'customer_id' in customers table is that string ID.
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'payment_id');
    }
    
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
        'receipt_path',
    ];
}
