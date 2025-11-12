<?php

namespace App\Http\Controllers;

use App\Models\StudentMonthlyPayment;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function subjectPayments(Request $request)
    {
        $month = $request->get('month', date('n'));
        $year = $request->get('year', date('Y'));

        $subjects = Subject::with(['teachers'])->get();
        $subjectPayments = [];

        foreach ($subjects as $subject) {
            $totalPayments = StudentMonthlyPayment::where('subject_id', $subject->id)
                ->where('payment_month', $month)
                ->where('payment_year', $year)
                ->sum('amount');

            $subjectPayments[] = [
                'subject' => $subject,
                'total_payments' => $totalPayments,
                'teacher_earnings' => [],
            ];

            // Calculate earnings for each teacher assigned to this subject
            foreach ($subject->teachers as $teacher) {
                $teacherEarnings = $totalPayments * $teacher->monthly_percentage / 100;
                $subjectPayments[count($subjectPayments) - 1]['teacher_earnings'][] = [
                    'teacher' => $teacher,
                    'earnings' => $teacherEarnings,
                ];
            }
        }

        return view('reports.subject-payments', compact('subjectPayments', 'month', 'year'));
    }

    public function teacherEarnings(Request $request)
    {
        $month = $request->get('month', date('n'));
        $year = $request->get('year', date('Y'));

        $teachers = Teacher::with(['subjects', 'classes.students'])->get();
        $teacherEarnings = [];

        foreach ($teachers as $teacher) {
            $earnings = $teacher->getClassBasedEarningsBySubject($month, $year);
            $totalEarnings = array_sum(array_column($earnings, 'teacher_earnings'));

            $teacherEarnings[] = [
                'teacher' => $teacher,
                'earnings_by_subject' => $earnings,
                'total_earnings' => $totalEarnings,
            ];
        }

        return view('reports.teacher-earnings', compact('teacherEarnings', 'month', 'year'));
    }
}
