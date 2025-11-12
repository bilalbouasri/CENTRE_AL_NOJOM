<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentMonthlyPayment;
use App\Models\StudentMonthlyPaymentSummary;
use App\Models\Subject;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = StudentMonthlyPaymentSummary::with(['student'])->get();

        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        $students = Student::all();
        $subjects = Subject::all();

        return view('payments.create', compact('students', 'subjects'));
    }

    public function createBulk(Request $request)
    {
        $studentId = $request->get('student_id');

        if (! $studentId) {
            return redirect()->route('students.index')->with('error', 'Please select a student first.');
        }

        $student = Student::with(['subjects', 'monthlyPayments'])->findOrFail($studentId);
        $allSubjects = Subject::all();
        $currentMonth = date('n');
        $currentYear = date('Y');

        return view('payments.create-bulk', compact('student', 'allSubjects', 'currentMonth', 'currentYear'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:cash,card,bank_transfer',
            'payment_month' => 'required|integer|between:1,12',
            'payment_year' => 'required|integer|min:2020|max:2030',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // Get subject fee for validation
        $subject = Subject::find($validated['subject_id']);
        if ($subject && $subject->fee_amount > 0 && $validated['amount'] != $subject->fee_amount) {
            return redirect()->back()->with('error', __('Payment amount must match the subject fee of MAD :amount.', ['amount' => number_format($subject->fee_amount, 2)]));
        }

        // Check if payment already exists for this student, subject, month and year
        $existingPayment = StudentMonthlyPayment::where('student_id', $validated['student_id'])
            ->where('subject_id', $validated['subject_id'])
            ->where('payment_month', $validated['payment_month'])
            ->where('payment_year', $validated['payment_year'])
            ->first();

        if ($existingPayment) {
            return redirect()->back()->with('error', __('A payment already exists for this student and subject for the selected month and year.'));
        }

        StudentMonthlyPayment::create($validated);

        // Redirect back to the student page
        return redirect()->route('students.show', $validated['student_id'])->with('success', __('Monthly payment recorded successfully.'));
    }

    public function storeBulk(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subjects' => 'required|array|min:1',
            'subjects.*' => 'exists:subjects,id',
            'total_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:cash,card,bank_transfer',
            'payment_month' => 'required|integer|between:1,12',
            'payment_year' => 'required|integer|min:2020|max:2030',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $student = Student::findOrFail($validated['student_id']);
        $selectedSubjects = $validated['subjects'];
        $totalAmount = $validated['total_amount'];
        $amountPerSubject = $totalAmount / count($selectedSubjects);

        // Check for existing payments and validate amounts
        $errors = [];
        $subjectsToProcess = [];
        foreach ($selectedSubjects as $subjectId) {
            $subject = Subject::find($subjectId);

            // Check if payment already exists for this specific subject
            $existingPayment = StudentMonthlyPayment::where('student_id', $validated['student_id'])
                ->where('subject_id', $subjectId)
                ->where('payment_month', $validated['payment_month'])
                ->where('payment_year', $validated['payment_year'])
                ->first();

            if ($existingPayment) {
                $errors[] = "A payment already exists for {$subject->getName()} for {$validated['payment_month']}/{$validated['payment_year']}.";

                continue;
            }

            // Validate amount against subject fee if set
            if ($subject->fee_amount > 0 && abs($amountPerSubject - $subject->fee_amount) > 0.01) {
                $errors[] = 'Amount per subject (MAD '.number_format($amountPerSubject, 2).") does not match the fee for {$subject->getName()} (MAD ".number_format($subject->fee_amount, 2).').';
            } else {
                $subjectsToProcess[] = $subjectId;
            }
        }

        if (! empty($errors)) {
            return redirect()->back()->with('error', implode(' ', $errors));
        }

        // First, enroll student in any selected subjects they're not already enrolled in
        $student = Student::findOrFail($validated['student_id']);
        $subjectsToEnroll = array_diff($selectedSubjects, $student->subjects->pluck('id')->toArray());

        if (! empty($subjectsToEnroll)) {
            $student->subjects()->attach($subjectsToEnroll);
        }

        // Create payments for each selected subject that doesn't already have a payment
        foreach ($subjectsToProcess as $subjectId) {
            StudentMonthlyPayment::create([
                'student_id' => $validated['student_id'],
                'subject_id' => $subjectId,
                'amount' => $amountPerSubject,
                'payment_method' => $validated['payment_method'],
                'payment_month' => $validated['payment_month'],
                'payment_year' => $validated['payment_year'],
                'payment_date' => $validated['payment_date'],
                'notes' => $validated['notes'],
            ]);
        }

        // Create or update payment summary
        $summary = StudentMonthlyPaymentSummary::updateOrCreate(
            [
                'student_id' => $validated['student_id'],
                'payment_month' => $validated['payment_month'],
                'payment_year' => $validated['payment_year'],
            ],
            [
                'total_amount' => $totalAmount,
                'payment_method' => $validated['payment_method'],
                'payment_date' => $validated['payment_date'],
                'notes' => $validated['notes'],
            ]
        );

        $processedCount = count($subjectsToProcess);
        $enrolledCount = count($subjectsToEnroll);
        $message = __('Payments recorded successfully for :count subjects.', ['count' => $processedCount]);

        if ($enrolledCount > 0) {
            $message .= __(' Student was enrolled in :count new subjects.', ['count' => $enrolledCount]);
        }

        if ($processedCount < count($selectedSubjects)) {
            $message .= __(' Some subjects were already paid and were skipped.');
        }

        return redirect()->route('students.show', $validated['student_id'])->with('success', $message);
    }

    public function show(StudentMonthlyPaymentSummary $payment)
    {
        $payment->load(['student']);

        return view('payments.show', compact('payment'));
    }

    public function edit(StudentMonthlyPaymentSummary $payment)
    {
        $students = Student::all();

        return view('payments.edit', compact('payment', 'students'));
    }

    public function update(Request $request, StudentMonthlyPaymentSummary $payment)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'total_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:cash,card,bank_transfer',
            'payment_month' => 'required|integer|between:1,12',
            'payment_year' => 'required|integer|min:2020|max:2030',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $payment->update($validated);

        return redirect()->route('payments.index')->with('success', __('Payment updated successfully.'));
    }

    public function destroy(StudentMonthlyPaymentSummary $payment)
    {
        // Also delete associated subject payments
        StudentMonthlyPayment::where('student_id', $payment->student_id)
            ->where('payment_month', $payment->payment_month)
            ->where('payment_year', $payment->payment_year)
            ->delete();

        $payment->delete();

        return redirect()->route('payments.index')->with('success', __('Payment deleted successfully.'));
    }
}
