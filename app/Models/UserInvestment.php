<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UserInvestment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'amount',
        'payment_proof',
        'payment_status',
        'daily_profit',
        'total_profit',
        'admin_notes',
        'start_date',
        'end_date',
        'status',
        'verified_at',
        'verified_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'daily_profit' => 'decimal:2',
        'total_profit' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'verified_at' => 'datetime',
    ];

    /**
     * Get the user who made this investment
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the investment product
     */
    public function product()
    {
        return $this->belongsTo(InvestmentProduct::class, 'product_id');
    }

    /**
     * Get the admin who verified the payment
     */
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Scope for pending payments
     */
    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }

    /**
     * Scope for verified payments
     */
    public function scopeVerified($query)
    {
        return $query->where('payment_status', 'verified');
    }

    /**
     * Scope for active investments
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Check if investment is active
     */
    public function isActive()
    {
        return $this->status === 'active' && $this->payment_status === 'verified';
    }

    /**
     * Check if investment duration has ended
     */
    public function hasEnded()
    {
        return Carbon::now()->isAfter($this->end_date);
    }

    /**
     * Calculate current total profit
     */
    public function calculateCurrentProfit()
    {
        if (!$this->isActive()) {
            return 0;
        }

        $startDate = Carbon::parse($this->start_date);
        $now = Carbon::now();
        $endDate = Carbon::parse($this->end_date);
        $calculationDate = $now->isAfter($endDate) ? $endDate : $now;
        $daysInvested = $startDate->diffInDays($calculationDate);

        return $this->daily_profit * $daysInvested;
    }

    /**
     * Get remaining days
     */
    public function getRemainingDays()
    {
        if (!$this->isActive()) {
            return 0;
        }

        $endDate = Carbon::parse($this->end_date);
        $remaining = Carbon::now()->diffInDays($endDate, false);
        
        return max(0, $remaining);
    }
}
