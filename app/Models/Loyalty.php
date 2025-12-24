<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loyalty extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'type',
        'description',
        'rental_counter',
        'no_of_stamp',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
