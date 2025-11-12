<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'joined_date',
        'monthly_percentage',
        'notes',
    ];

    protected $casts = [
        'joined_date' => 'date',
        'monthly_percentage' => 'decimal:2',
    ];

    public function classes(): HasMany
    {
        return $this->hasMany(Classes::class);
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'teacher_subject');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(TeacherPayment::class);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getMonthlyEarningsAttribute(): float
    {
        // Calculate monthly earnings based on students' payments and teacher's percentage
        $totalEarnings = 0;

        foreach ($this->subjects as $subject) {
            $subjectPayments = StudentMonthlyPayment::where('subject_id', $subject->id)
                ->where('payment_month', now()->month)
                ->where('payment_year', now()->year)
                ->sum('amount');

            $totalEarnings += ($subjectPayments * $this->monthly_percentage / 100);
        }

        return $totalEarnings;
    }

    public function getEarningsBySubject($month = null, $year = null): array
    {
        $month = $month ?? now()->month;
        $year = $year ?? now()->year;

        $earnings = [];

        foreach ($this->subjects as $subject) {
            $subjectPayments = StudentMonthlyPayment::where('subject_id', $subject->id)
                ->where('payment_month', $month)
                ->where('payment_year', $year)
                ->sum('amount');

            $earnings[] = [
                'subject' => $subject->getName(),
                'total_payments' => $subjectPayments,
                'teacher_earnings' => $subjectPayments * $this->monthly_percentage / 100,
            ];
        }

        return $earnings;
    }

    /**
     * Calculate earnings based on actual students in teacher's classes
     */
    public function getClassBasedEarnings($month = null, $year = null): array
    {
        $month = $month ?? now()->month;
        $year = $year ?? now()->year;

        $earnings = [];

        // Get all classes taught by this teacher
        $classes = $this->classes()->with(['students', 'subject'])->get();

        foreach ($classes as $class) {
            $subject = $class->subject;
            $studentIds = $class->students->pluck('id')->toArray();

            if (empty($studentIds)) {
                continue;
            }

            // Calculate payments only from students in this class for this subject
            $classPayments = StudentMonthlyPayment::where('subject_id', $subject->id)
                ->where('payment_month', $month)
                ->where('payment_year', $year)
                ->whereIn('student_id', $studentIds)
                ->sum('amount');

            $earnings[] = [
                'class_name' => $class->name,
                'subject' => $subject->getName(),
                'student_count' => count($studentIds),
                'total_payments' => $classPayments,
                'teacher_earnings' => $classPayments * $this->monthly_percentage / 100,
            ];
        }

        return $earnings;
    }

    /**
     * Get total earnings based on actual students in classes
     */
    public function getTotalClassBasedEarnings($month = null, $year = null): float
    {
        $earnings = $this->getClassBasedEarnings($month, $year);

        return array_sum(array_column($earnings, 'teacher_earnings'));
    }

    /**
     * Get earnings grouped by subject based on actual students in classes
     */
    public function getClassBasedEarningsBySubject($month = null, $year = null): array
    {
        $month = $month ?? now()->month;
        $year = $year ?? now()->year;

        $earningsBySubject = [];

        // Get all classes taught by this teacher
        $classes = $this->classes()->with(['students', 'subject'])->get();

        foreach ($classes as $class) {
            $subject = $class->subject;
            $subjectKey = $subject->id;
            $studentIds = $class->students->pluck('id')->toArray();

            if (empty($studentIds)) {
                continue;
            }

            // Calculate payments only from students in this class for this subject
            $classPayments = StudentMonthlyPayment::where('subject_id', $subject->id)
                ->where('payment_month', $month)
                ->where('payment_year', $year)
                ->whereIn('student_id', $studentIds)
                ->sum('amount');

            if (! isset($earningsBySubject[$subjectKey])) {
                $earningsBySubject[$subjectKey] = [
                    'subject' => $subject->getName(),
                    'total_payments' => 0,
                    'teacher_earnings' => 0,
                    'student_count' => 0,
                    'classes' => [],
                ];
            }

            $earningsBySubject[$subjectKey]['total_payments'] += $classPayments;
            $earningsBySubject[$subjectKey]['teacher_earnings'] += $classPayments * $this->monthly_percentage / 100;
            $earningsBySubject[$subjectKey]['student_count'] += count($studentIds);
            $earningsBySubject[$subjectKey]['classes'][] = [
                'class_name' => $class->name,
                'student_count' => count($studentIds),
                'payments' => $classPayments,
                'earnings' => $classPayments * $this->monthly_percentage / 100,
            ];
        }

        return array_values($earningsBySubject);
    }

    /**
     * Calculate earnings based on class enrollment and subject fee
     * This assumes each student in a class pays the subject fee
     */
    public function getClassBasedEarningsByEnrollment($month = null, $year = null): array
    {
        $month = $month ?? now()->month;
        $year = $year ?? now()->year;

        $earningsBySubject = [];

        // Get all classes taught by this teacher
        $classes = $this->classes()->with(['students', 'subject'])->get();

        foreach ($classes as $class) {
            $subject = $class->subject;
            $subjectKey = $subject->id;
            $studentIds = $class->students->pluck('id')->toArray();

            if (empty($studentIds)) {
                continue;
            }

            // Calculate based on class enrollment and subject fee
            $studentCount = count($studentIds);
            $totalPayments = $subject->fee_amount * $studentCount;
            $teacherEarnings = $totalPayments * $this->monthly_percentage / 100;

            if (! isset($earningsBySubject[$subjectKey])) {
                $earningsBySubject[$subjectKey] = [
                    'subject' => $subject->getName(),
                    'total_payments' => 0,
                    'teacher_earnings' => 0,
                    'student_count' => 0,
                    'classes' => [],
                ];
            }

            $earningsBySubject[$subjectKey]['total_payments'] += $totalPayments;
            $earningsBySubject[$subjectKey]['teacher_earnings'] += $teacherEarnings;
            $earningsBySubject[$subjectKey]['student_count'] += $studentCount;
            $earningsBySubject[$subjectKey]['classes'][] = [
                'class_name' => $class->name,
                'student_count' => $studentCount,
                'payments' => $totalPayments,
                'earnings' => $teacherEarnings,
            ];
        }

        return array_values($earningsBySubject);
    }
}
