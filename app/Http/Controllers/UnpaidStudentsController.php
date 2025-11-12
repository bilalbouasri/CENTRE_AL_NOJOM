<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class UnpaidStudentsController extends Controller
{
    public function index(Request $request)
    {
        $currentMonth = date('n');
        $currentYear = date('Y');

        $selectedMonth = $request->get('month', $currentMonth);
        $selectedYear = $request->get('year', $currentYear);

        // Get all students with their subjects
        $students = Student::with(['subjects', 'monthlyPayments' => function ($query) use ($selectedMonth, $selectedYear) {
            $query->where('payment_month', $selectedMonth)
                ->where('payment_year', $selectedYear);
        }])->get();

        // Filter students who have unpaid subjects
        $unpaidStudents = $students->filter(function ($student) {
            $paidSubjectIds = $student->monthlyPayments->pluck('subject_id')->toArray();

            // Check if student has any subjects that haven't been paid for
            $unpaidSubjects = $student->subjects->filter(function ($subject) use ($paidSubjectIds) {
                return ! in_array($subject->id, $paidSubjectIds);
            });

            return $unpaidSubjects->count() > 0;
        })->map(function ($student) {
            $paidSubjectIds = $student->monthlyPayments->pluck('subject_id')->toArray();

            $student->unpaid_subjects = $student->subjects->filter(function ($subject) use ($paidSubjectIds) {
                return ! in_array($subject->id, $paidSubjectIds);
            });

            $student->paid_subjects = $student->subjects->filter(function ($subject) use ($paidSubjectIds) {
                return in_array($subject->id, $paidSubjectIds);
            });

            return $student;
        });

        $months = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December',
        ];

        $years = range(2020, 2030);

        return view('unpaid-students.index', compact(
            'unpaidStudents',
            'months',
            'years',
            'selectedMonth',
            'selectedYear'
        ));
    }
}
