<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $primaryKey = 'payment_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'payment_id',
        'customer_id',
        'staff_id',
        'amount',
        'receipt_path',
        'verification_status',
        'penalty',
        'deposit',
        'payment',
        'bank_name',
        'bank_account',
        'refund_amount',
    ];

    public function rental()
    {
        return $this->hasOne(Rental::class, 'payment_id', 'payment_id');
    }
    
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }
}