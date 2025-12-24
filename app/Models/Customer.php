<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Customer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'customer_id',
        'user_id',
        'username',
        'nationality',
        'matric_staff_no',
        'ic_passport',
        'gender',
        'faculty',
        'residential_college',
        'address',
        'phone',
        'emergency_contact_name',
        'relationship',
        'emergency_phone',
        'license_no',
        'license_expiry',
        'license_image',
        'identity_card_image',
        'matric_staff_image',
        'balance',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'license_expiry' => 'date',
            'balance' => 'decimal:2',
        ];
    }

    /**
     * Get the user that owns the customer profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the loyalty history for the customer.
     */
    public function loyalties(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Loyalty::class);
    }

    /**
     * Get the current loyalty status (latest record).
     */
    public function currentLoyalty(): ?Loyalty
    {
        return $this->loyalties()->latest()->first();
    }

    /**
     * Assign a sequential customer ID if not provided.
     */
    protected static function booted(): void
    {
        static::creating(function (Customer $customer): void {
            if (! $customer->customer_id) {
                $nextNumber = (Customer::max('id') ?? 0) + 1;
                $customer->customer_id = sprintf('C%06d', $nextNumber);
            }
        });
    }
}
