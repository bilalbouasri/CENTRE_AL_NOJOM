<?php

namespace App\Console\Commands;

use App\Models\MonthlyRevenue;
use Illuminate\Console\Command;

class CalculateMonthlyRevenue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'revenue:calculate 
                            {--month= : Specific month to calculate (1-12)}
                            {--year= : Specific year to calculate}
                            {--all : Calculate for all months in current year}
                            {--current : Calculate current month only}
                            {--last : Calculate last month only}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate monthly revenue for specified period';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $options = $this->options();

        if ($options['all']) {
            $this->calculateAllMonths();
        } elseif ($options['current']) {
            $this->calculateCurrentMonth();
        } elseif ($options['last']) {
            $this->calculateLastMonth();
        } elseif ($options['month'] || $options['year']) {
            $this->calculateSpecificMonth();
        } else {
            $this->calculateCurrentMonth();
        }

        $this->info('Monthly revenue calculation completed successfully.');
    }

    /**
     * Calculate revenue for all months in current year
     */
    protected function calculateAllMonths()
    {
        $currentYear = date('Y');
        $this->info("Calculating revenue for all months in {$currentYear}...");

        $bar = $this->output->createProgressBar(12);

        for ($month = 1; $month <= 12; $month++) {
            $revenue = MonthlyRevenue::calculateForMonth($month, $currentYear);
            $this->info("  {$revenue->month_name}: MAD ".number_format($revenue->total_revenue, 2));
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
    }

    /**
     * Calculate revenue for current month
     */
    protected function calculateCurrentMonth()
    {
        $this->info('Calculating revenue for current month...');
        $revenue = MonthlyRevenue::calculateCurrentMonth();
        $this->info("  {$revenue->month_year}: MAD ".number_format($revenue->total_revenue, 2)." ({$revenue->payment_count} payments)");
    }

    /**
     * Calculate revenue for last month
     */
    protected function calculateLastMonth()
    {
        $lastMonth = date('n') - 1;
        $year = date('Y');

        if ($lastMonth <= 0) {
            $lastMonth = 12;
            $year--;
        }

        $this->info("Calculating revenue for last month ({$lastMonth}/{$year})...");
        $revenue = MonthlyRevenue::calculateForMonth($lastMonth, $year);
        $this->info("  {$revenue->month_year}: MAD ".number_format($revenue->total_revenue, 2)." ({$revenue->payment_count} payments)");
    }

    /**
     * Calculate revenue for specific month and year
     */
    protected function calculateSpecificMonth()
    {
        $month = $this->option('month') ?: date('n');
        $year = $this->option('year') ?: date('Y');

        if ($month < 1 || $month > 12) {
            $this->error('Invalid month. Must be between 1 and 12.');

            return;
        }

        if ($year < 2020 || $year > 2030) {
            $this->error('Invalid year. Must be between 2020 and 2030.');

            return;
        }

        $this->info("Calculating revenue for {$month}/{$year}...");
        $revenue = MonthlyRevenue::calculateForMonth($month, $year);
        $this->info("  {$revenue->month_year}: MAD ".number_format($revenue->total_revenue, 2)." ({$revenue->payment_count} payments)");
    }
}
