<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'voucher_code',
        'description',
        'discount_percent',
        'free_hours',
        'expiry_date',
        'status',
    ];

    protected $casts = [
        'expiry_date' => 'date',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('status', 'active')
              ->where('expiry_date', '>=', now()->startOfDay());
    }

    public function scopePast(Builder $query): void
    {
        $query->where(function ($q) {
            $q->where('status', '!=', 'active')
              ->orWhere('expiry_date', '<', now()->startOfDay());
        });
    }
}
