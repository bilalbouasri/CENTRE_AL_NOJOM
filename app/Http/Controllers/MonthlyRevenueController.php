<?php

namespace App\Http\Controllers;

use App\Models\MonthlyRevenue;
use App\Models\Payment;
use Illuminate\Http\Request;

class MonthlyRevenueController extends Controller
{
    /**
     * Display a listing of monthly revenues
     */
    public function index()
    {
        $revenues = MonthlyRevenue::orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->paginate(12);

        $yearToDate = MonthlyRevenue::getYearToDate();
        $currentMonthRevenue = MonthlyRevenue::calculateCurrentMonth();

        return view('monthly-revenues.index', compact(
            'revenues',
            'yearToDate',
            'currentMonthRevenue'
        ));
    }

    /**
     * Show the form for creating a new monthly revenue record
     */
    public function create()
    {
        return view('monthly-revenues.create');
    }

    /**
     * Store a newly created monthly revenue record
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer|min:2020|max:2030',
            'notes' => 'nullable|string',
        ]);

        // Check if record already exists
        $existingRevenue = MonthlyRevenue::where('month', $validated['month'])
            ->where('year', $validated['year'])
            ->first();

        if ($existingRevenue) {
            return redirect()->back()->with('error', __('A revenue record already exists for this month and year.'));
        }

        // Calculate revenue for the specified month
        $revenue = MonthlyRevenue::calculateForMonth($validated['month'], $validated['year']);
        $revenue->update(['notes' => $validated['notes']]);

        return redirect()->route('monthly-revenues.index')
            ->with('success', __('Monthly revenue record created successfully.'));
    }

    /**
     * Display the specified monthly revenue
     */
    public function show(MonthlyRevenue $monthlyRevenue)
    {
        $monthlyRevenue->load([]); // No relationships needed for now

        // Get detailed payments for this month
        $payments = Payment::where('payment_month', $monthlyRevenue->month)
            ->where('payment_year', $monthlyRevenue->year)
            ->with('student')
            ->orderBy('payment_date', 'desc')
            ->paginate(20);

        $growthData = $monthlyRevenue->getGrowthFromPreviousMonth();

        return view('monthly-revenues.show', compact(
            'monthlyRevenue',
            'payments',
            'growthData'
        ));
    }

    /**
     * Show the form for editing the specified monthly revenue
     */
    public function edit(MonthlyRevenue $monthlyRevenue)
    {
        return view('monthly-revenues.edit', compact('monthlyRevenue'));
    }

    /**
     * Update the specified monthly revenue
     */
    public function update(Request $request, MonthlyRevenue $monthlyRevenue)
    {
        $validated = $request->validate([
            'notes' => 'nullable|string',
        ]);

        $monthlyRevenue->update($validated);

        return redirect()->route('monthly-revenues.show', $monthlyRevenue)
            ->with('success', __('Monthly revenue record updated successfully.'));
    }

    /**
     * Remove the specified monthly revenue
     */
    public function destroy(MonthlyRevenue $monthlyRevenue)
    {
        $monthlyRevenue->delete();

        return redirect()->route('monthly-revenues.index')
            ->with('success', __('Monthly revenue record deleted successfully.'));
    }

    /**
     * Recalculate monthly revenue for a specific month
     */
    public function recalculate(MonthlyRevenue $monthlyRevenue)
    {
        $recalculated = MonthlyRevenue::calculateForMonth(
            $monthlyRevenue->month,
            $monthlyRevenue->year
        );

        return redirect()->route('monthly-revenues.show', $monthlyRevenue)
            ->with('success', __('Monthly revenue recalculated successfully.'));
    }

    /**
     * Show year-to-date summary
     */
    public function yearToDate()
    {
        $yearToDate = MonthlyRevenue::getYearToDate();
        $last12Months = MonthlyRevenue::getLastMonths(12);

        return view('monthly-revenues.year-to-date', compact(
            'yearToDate',
            'last12Months'
        ));
    }

    /**
     * Show revenue comparison between months
     */
    public function comparison()
    {
        $last6Months = MonthlyRevenue::getLastMonths(6);
        $comparisonData = [];

        foreach ($last6Months as $index => $revenue) {
            $growth = $revenue->getGrowthFromPreviousMonth();
            $comparisonData[] = [
                'revenue' => $revenue,
                'growth' => $growth,
            ];
        }

        return view('monthly-revenues.comparison', compact('comparisonData'));
    }

    /**
     * Export monthly revenues to CSV
     */
    public function export(Request $request)
    {
        $year = $request->get('year', date('Y'));

        $revenues = MonthlyRevenue::where('year', $year)
            ->orderBy('month', 'asc')
            ->get();

        $filename = "monthly_revenues_{$year}.csv";
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($revenues) {
            $file = fopen('php://output', 'w');

            // Add BOM for UTF-8
            fwrite($file, $bom = (chr(0xEF).chr(0xBB).chr(0xBF)));

            // Headers
            fputcsv($file, [
                'Month',
                'Year',
                'Total Revenue (MAD)',
                'Payment Count',
                'Average Payment (MAD)',
                'Notes',
            ]);

            // Data
            foreach ($revenues as $revenue) {
                fputcsv($file, [
                    $revenue->month_name,
                    $revenue->year,
                    $revenue->total_revenue,
                    $revenue->payment_count,
                    $revenue->average_payment,
                    $revenue->notes,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
