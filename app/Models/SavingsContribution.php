<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SavingsContribution extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'savings_goal_id',
        'user_id',
        'amount',
        'description',
        'contribution_date',
        'type'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'contribution_date' => 'date',
        'created_at' => 'datetime',
    ];

    /**
     * Get the savings goal that owns the contribution.
     */
    public function savingsGoal(): BelongsTo
    {
        return $this->belongsTo(SavingsGoal::class);
    }

    /**
     * Get the user that made the contribution.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include deposit contributions.
     */
    public function scopeDeposits($query)
    {
        return $query->where('type', 'deposit');
    }

    /**
     * Scope a query to only include withdrawal contributions.
     */
    public function scopeWithdrawals($query)
    {
        return $query->where('type', 'withdrawal');
    }

    /**
     * Get the effective amount (positive for deposits, negative for withdrawals).
     */
    public function getEffectiveAmountAttribute(): float
    {
        return $this->type === 'withdrawal' ? -1 * $this->amount : $this->amount;
    }
}
