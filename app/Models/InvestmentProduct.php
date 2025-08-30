<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestmentProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'min_amount',
        'max_amount',
        'daily_rate',
        'duration_days',
        'is_active',
        'image',
    ];

    protected $casts = [
        'min_amount' => 'decimal:2',
        'max_amount' => 'decimal:2',
        'daily_rate' => 'float',
        'is_active' => 'boolean',
    ];

    /**
     * Get all active investment products
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get user investments for this product
     */
    public function userInvestments()
    {
        return $this->hasMany(UserInvestment::class, 'product_id');
    }

    /**
     * Calculate daily profit for a given amount
     */
    public function calculateDailyProfit($amount)
    {
        return ($amount * $this->daily_rate) / 100;
    }

    /**
     * Calculate total profit for a given amount and duration
     */
    public function calculateTotalProfit($amount, $duration = null)
    {
        $duration = $duration ?? $this->duration_days;
        $dailyProfit = $this->calculateDailyProfit($amount);
        return $dailyProfit * $duration;
    }
}
