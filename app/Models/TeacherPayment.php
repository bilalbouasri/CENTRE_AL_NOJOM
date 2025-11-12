<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeacherPayment extends Model
{
    protected $fillable = [
        'teacher_id',
        'payment_month',
        'payment_year',
        'amount',
        'payment_method',
        'payment_date',
        'notes',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function getMonthNameAttribute(): string
    {
        $months = [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ];

        return $months[$this->payment_month] ?? 'Unknown';
    }

    public function getMonthYearAttribute(): string
    {
        return "{$this->month_name} {$this->payment_year}";
    }

    public function getFormattedAmountAttribute(): string
    {
        return 'MAD '.number_format($this->amount, 2);
    }

    /**
     * Check if teacher has been paid for a specific month/year
     */
    public static function isPaid($teacherId, $month, $year): bool
    {
        return static::where('teacher_id', $teacherId)
            ->where('payment_month', $month)
            ->where('payment_year', $year)
            ->exists();
    }

    /**
     * Get payment amount for a specific month/year
     */
    public static function getPaymentAmount($teacherId, $month, $year): float
    {
        $payment = static::where('teacher_id', $teacherId)
            ->where('payment_month', $month)
            ->where('payment_year', $year)
            ->first();

        return $payment ? $payment->amount : 0;
    }
}
