<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentMonthlyPayment extends Model
{
    protected $fillable = [
        'student_id',
        'subject_id',
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

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
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
}
