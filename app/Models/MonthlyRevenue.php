<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyRevenue extends Model
{
    use HasFactory;

    protected $fillable = [
        'month',
        'year',
        'total_revenue',
        'payment_count',
        'average_payment',
        'revenue_by_method',
        'notes',
    ];

    protected $casts = [
        'total_revenue' => 'decimal:2',
        'average_payment' => 'decimal:2',
        'revenue_by_method' => 'array',
    ];

    /**
     * Get the month name
     */
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

        return $months[$this->month] ?? 'Unknown';
    }

    /**
     * Get formatted month and year
     */
    public function getMonthYearAttribute(): string
    {
        return "{$this->month_name} {$this->year}";
    }

    /**
     * Get formatted total revenue
     */
    public function getFormattedRevenueAttribute(): string
    {
        return 'MAD '.number_format($this->total_revenue, 2);
    }

    /**
     * Get formatted average payment
     */
    public function getFormattedAveragePaymentAttribute(): string
    {
        return 'MAD '.number_format($this->average_payment, 2);
    }

    /**
     * Calculate and update monthly revenue for a specific month and year
     */
    public static function calculateForMonth(int $month, int $year): self
    {
        // Get all payments for the specified month and year
        $payments = Payment::where('payment_month', $month)
            ->where('payment_year', $year)
            ->get();

        $totalRevenue = $payments->sum('amount');
        $paymentCount = $payments->count();
        $averagePayment = $paymentCount > 0 ? $totalRevenue / $paymentCount : 0;

        // Calculate revenue by payment method
        $revenueByMethod = $payments->groupBy('payment_method')
            ->map(function ($methodPayments) {
                return [
                    'count' => $methodPayments->count(),
                    'amount' => $methodPayments->sum('amount'),
                ];
            })
            ->toArray();

        // Create or update the monthly revenue record
        return self::updateOrCreate(
            [
                'month' => $month,
                'year' => $year,
            ],
            [
                'total_revenue' => $totalRevenue,
                'payment_count' => $paymentCount,
                'average_payment' => $averagePayment,
                'revenue_by_method' => $revenueByMethod,
            ]
        );
    }

    /**
     * Calculate and update current month revenue
     */
    public static function calculateCurrentMonth(): self
    {
        $currentMonth = date('n');
        $currentYear = date('Y');

        return self::calculateForMonth($currentMonth, $currentYear);
    }

    /**
     * Get revenue for the last N months
     */
    public static function getLastMonths(int $months = 12): array
    {
        $revenues = [];
        $currentMonth = date('n');
        $currentYear = date('Y');

        for ($i = 0; $i < $months; $i++) {
            $month = $currentMonth - $i;
            $year = $currentYear;

            if ($month <= 0) {
                $month += 12;
                $year--;
            }

            $revenue = self::where('month', $month)
                ->where('year', $year)
                ->first();

            if (! $revenue) {
                // Calculate if not exists
                $revenue = self::calculateForMonth($month, $year);
            }

            $revenues[] = $revenue;
        }

        return $revenues;
    }

    /**
     * Get year-to-date revenue
     */
    public static function getYearToDate(): array
    {
        $currentYear = date('Y');
        $currentMonth = date('n');

        $revenues = self::where('year', $currentYear)
            ->where('month', '<=', $currentMonth)
            ->orderBy('month', 'asc')
            ->get();

        $totalRevenue = $revenues->sum('total_revenue');
        $totalPayments = $revenues->sum('payment_count');

        return [
            'revenues' => $revenues,
            'total_revenue' => $totalRevenue,
            'total_payments' => $totalPayments,
            'average_monthly_revenue' => $currentMonth > 0 ? $totalRevenue / $currentMonth : 0,
        ];
    }

    /**
     * Get revenue growth compared to previous month
     */
    public function getGrowthFromPreviousMonth(): ?array
    {
        $previousMonth = $this->month - 1;
        $previousYear = $this->year;

        if ($previousMonth <= 0) {
            $previousMonth = 12;
            $previousYear--;
        }

        $previousRevenue = self::where('month', $previousMonth)
            ->where('year', $previousYear)
            ->first();

        if (! $previousRevenue) {
            return null;
        }

        $revenueGrowth = $this->total_revenue - $previousRevenue->total_revenue;
        $growthPercentage = $previousRevenue->total_revenue > 0
            ? ($revenueGrowth / $previousRevenue->total_revenue) * 100
            : 0;

        return [
            'amount' => $revenueGrowth,
            'percentage' => $growthPercentage,
            'previous_revenue' => $previousRevenue->total_revenue,
        ];
    }
}
