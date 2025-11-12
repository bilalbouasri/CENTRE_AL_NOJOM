<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\MonthlyRevenue;
use App\Models\Student;
use App\Models\StudentMonthlyPayment;
use App\Models\Subject;
use App\Models\Teacher;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $totalClasses = Classes::count();
        $totalSubjects = Subject::count();

        // Get recent payments with student relationship using StudentMonthlyPayment model
        $recentPayments = StudentMonthlyPayment::with('student')
            ->orderBy('payment_date', 'desc')
            ->take(5)
            ->get();

        // Calculate monthly revenue using StudentMonthlyPayment model
        $currentMonth = date('n');
        $currentYear = date('Y');
        $monthlyRevenue = StudentMonthlyPayment::where('payment_month', $currentMonth)
            ->where('payment_year', $currentYear)
            ->sum('amount');

        // Get monthly revenue data for dashboard
        $currentMonthRevenue = MonthlyRevenue::calculateCurrentMonth();
        $last6MonthsRevenue = MonthlyRevenue::getLastMonths(6);
        $yearToDate = MonthlyRevenue::getYearToDate();

        return view('dashboard', compact(
            'totalStudents',
            'totalTeachers',
            'totalClasses',
            'totalSubjects',
            'recentPayments',
            'monthlyRevenue',
            'currentMonthRevenue',
            'last6MonthsRevenue',
            'yearToDate'
        ));
    }
}
