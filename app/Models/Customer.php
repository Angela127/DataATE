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
        'documents_status',
        'documents_rejection_reason',
        'documents_submitted_at',
        'documents_approved_at',
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
            'documents_submitted_at' => 'datetime',
            'documents_approved_at' => 'datetime',
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
     * Get the vouchers for the customer.
     */
    public function vouchers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Voucher::class);
    }

    public function activeVouchers()
    {
        return $this->vouchers()->active();
    }

    /**
     * Check if all required documents are uploaded.
     */
    public function hasUploadedAllDocuments(): bool
    {
        return !empty($this->license_image) 
            && !empty($this->identity_card_image) 
            && !empty($this->matric_staff_image);
    }

    /**
     * Check if documents are approved.
     */
    public function isDocumentsApproved(): bool
    {
        return $this->documents_status === 'approved';
    }

    /**
     * Check if customer can rent a car.
     */
    public function canRentCar(): bool
    {
        return $this->hasUploadedAllDocuments() && $this->isDocumentsApproved();
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
