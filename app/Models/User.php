<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the categories for the user.
     */
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Get the income categories for the user.
     */
    public function incomeCategories(): HasMany
    {
        return $this->hasMany(Category::class)->where('type', 'income');
    }

    /**
     * Get the expense categories for the user.
     */
    public function expenseCategories(): HasMany
    {
        return $this->hasMany(Category::class)->where('type', 'expense');
    }

    /**
     * Get the transactions for the user.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get the income transactions for the user.
     */
    public function incomes(): HasMany
    {
        return $this->hasMany(Transaction::class)->where('type', 'income');
    }

    /**
     * Get the expense transactions for the user.
     */
    public function expenses(): HasMany
    {
        return $this->hasMany(Transaction::class)->where('type', 'expense');
    }

    /**
     * Get the balance for the user.
     */
    public function getBalanceAttribute(): float
    {
        $incomes = $this->incomes()->sum('amount');
        $expenses = $this->expenses()->sum('amount');

        return $incomes - $expenses;
    }

    /**
     * Get the budget for the user.
     */
    public function budget(): HasOne
    {
        return $this->hasOne(Budget::class)->where('period', 'monthly')->latest();
    }

    /**
     * Get the budget for the current month.
     *
     * Use this method to retrieve the budget, but avoid using the magic property directly.
     * Instead, do: $budget = $user->budget()->first(); $amount = $budget ? $budget->amount : 1000.00;
     */

    /**
     * Get the savings goals for the user.
     */
    public function savingsGoals(): HasMany
    {
        return $this->hasMany(SavingsGoal::class);
    }

    /**
     * Get the active savings goals for the user.
     */
    public function activeSavingsGoals(): HasMany
    {
        return $this->hasMany(SavingsGoal::class)->where('status', 'active');
    }

    /**
     * Get the completed savings goals for the user.
     */
    public function completedSavingsGoals(): HasMany
    {
        return $this->hasMany(SavingsGoal::class)->where('status', 'completed');
    }

    /**
     * Get the savings contributions for the user.
     */
    public function savingsContributions(): HasMany
    {
        return $this->hasMany(SavingsContribution::class);
    }
}
