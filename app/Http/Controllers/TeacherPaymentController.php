<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\TeacherPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherPaymentController extends Controller
{
    /**
     * Display a listing of teacher payments.
     */
    public function index(Request $request)
    {
        $month = $request->get('month', date('n'));
        $year = $request->get('year', date('Y'));

        $teacherPayments = TeacherPayment::with('teacher')
            ->where('payment_month', $month)
            ->where('payment_year', $year)
            ->get();

        $teachers = Teacher::with(['classes.students', 'subjects'])->get();
        $teacherEarnings = [];

        foreach ($teachers as $teacher) {
            $earnings = $teacher->getClassBasedEarningsBySubject($month, $year);
            $totalEarnings = array_sum(array_column($earnings, 'teacher_earnings'));
            $isPaid = $teacher->isPaidForMonth($month, $year);
            $paidAmount = $teacher->getPaymentAmountForMonth($month, $year);

            $teacherEarnings[] = [
                'teacher' => $teacher,
                'earnings_by_subject' => $earnings,
                'total_earnings' => $totalEarnings,
                'is_paid' => $isPaid,
                'paid_amount' => $paidAmount,
            ];
        }

        return view('teacher-payments.index', compact('teacherEarnings', 'teacherPayments', 'month', 'year'));
    }

    /**
     * Show the form for creating a new teacher payment.
     */
    public function create(Request $request)
    {
        $teacherId = $request->get('teacher_id');
        $month = $request->get('month', date('n'));
        $year = $request->get('year', date('Y'));

        $teacher = Teacher::find($teacherId);
        if (! $teacher) {
            return redirect()->route('teacher-payments.index')
                ->with('error', 'Teacher not found.');
        }

        $earnings = $teacher->getClassBasedEarningsBySubject($month, $year);
        $totalEarnings = array_sum(array_column($earnings, 'teacher_earnings'));

        return view('teacher-payments.create', compact('teacher', 'totalEarnings', 'month', 'year'));
    }

    /**
     * Store a newly created teacher payment.
     */
    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'payment_month' => 'required|integer|between:1,12',
            'payment_year' => 'required|integer',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // Check if payment already exists for this teacher, month, year
        $existingPayment = TeacherPayment::where('teacher_id', $request->teacher_id)
            ->where('payment_month', $request->payment_month)
            ->where('payment_year', $request->payment_year)
            ->first();

        if ($existingPayment) {
            return redirect()->route('teacher-payments.index')
                ->with('error', 'Payment already recorded for this teacher for the selected month.');
        }

        try {
            DB::transaction(function () use ($request) {
                TeacherPayment::create($request->all());
            });

            return redirect()->route('teacher-payments.index')
                ->with('success', 'Teacher payment recorded successfully.');
        } catch (\Exception $e) {
            return redirect()->route('teacher-payments.index')
                ->with('error', 'Failed to record teacher payment: '.$e->getMessage());
        }
    }

    /**
     * Display the specified teacher payment.
     */
    public function show(TeacherPayment $teacherPayment)
    {
        $teacherPayment->load('teacher');

        return view('teacher-payments.show', compact('teacherPayment'));
    }

    /**
     * Show the form for editing the specified teacher payment.
     */
    public function edit(TeacherPayment $teacherPayment)
    {
        $teacherPayment->load('teacher');
        $earnings = $teacherPayment->teacher->getClassBasedEarningsBySubject(
            $teacherPayment->payment_month,
            $teacherPayment->payment_year
        );
        $totalEarnings = array_sum(array_column($earnings, 'teacher_earnings'));

        return view('teacher-payments.edit', compact('teacherPayment', 'totalEarnings'));
    }

    /**
     * Update the specified teacher payment.
     */
    public function update(Request $request, TeacherPayment $teacherPayment)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        try {
            $teacherPayment->update($request->all());

            return redirect()->route('teacher-payments.index')
                ->with('success', 'Teacher payment updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('teacher-payments.index')
                ->with('error', 'Failed to update teacher payment: '.$e->getMessage());
        }
    }

    /**
     * Remove the specified teacher payment.
     */
    public function destroy(TeacherPayment $teacherPayment)
    {
        try {
            $teacherPayment->delete();

            return redirect()->route('teacher-payments.index')
                ->with('success', 'Teacher payment deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('teacher-payments.index')
                ->with('error', 'Failed to delete teacher payment: '.$e->getMessage());
        }
    }
}
