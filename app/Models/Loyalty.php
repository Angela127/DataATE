<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Get reward tiers from storage or default.
     */
    public static function getRewardTiers()
    {
        if (Storage::exists('loyalty_rules.json')) {
            return json_decode(Storage::get('loyalty_rules.json'), true);
        }

        // Default Rules
        return [
            3 => ['type' => 'discount', 'amount' => 10],
            6 => ['type' => 'discount', 'amount' => 15],
            9 => ['type' => 'discount', 'amount' => 20],
            12 => ['type' => 'discount', 'amount' => 25],
            15 => ['type' => 'free_hours', 'amount' => 12],
        ];
    }

    /**
     * Save reward tiers to storage.
     */
    public static function saveRewardTiers($tiers)
    {
        Storage::put('loyalty_rules.json', json_encode($tiers));
    }
}
