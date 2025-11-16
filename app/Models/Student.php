<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Student Model
 *
 * Represents a student in the educational center with their personal information,
 * enrolled subjects, classes, and payment records.
 */
class Student extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'grade',
        'joined_date',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'joined_date' => 'date',
    ];

    /**
     * Get the subjects the student is enrolled in.
     */
    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class);
    }

    /**
     * Get the classes the student is enrolled in.
     */
    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(Classes::class, 'class_student', 'student_id', 'class_id');
    }

    /**
     * Get the student's payments.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the student's monthly payments.
     */
    public function monthlyPayments(): HasMany
    {
        return $this->hasMany(StudentMonthlyPayment::class);
    }

    /**
     * Get the student's monthly payment summaries.
     */
    public function monthlyPaymentSummaries(): HasMany
    {
        return $this->hasMany(StudentMonthlyPaymentSummary::class);
    }

    /**
     * Get the student's full name.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Check if student has paid for all subjects in current month.
     */
    public function isFullyPaidForCurrentMonth(): bool
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;
        
        $paidSubjectIds = $this->monthlyPayments()
            ->where('payment_month', $currentMonth)
            ->where('payment_year', $currentYear)
            ->pluck('subject_id')
            ->toArray();

        $totalSubjects = $this->subjects->count();
        $paidSubjects = count($paidSubjectIds);

        return $paidSubjects === $totalSubjects && $totalSubjects > 0;
    }

    /**
     * Get payment status for current month.
     */
    public function getPaymentStatusForCurrentMonth(): string
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;
        
        $paidSubjectIds = $this->monthlyPayments()
            ->where('payment_month', $currentMonth)
            ->where('payment_year', $currentYear)
            ->pluck('subject_id')
            ->toArray();

        $totalSubjects = $this->subjects->count();
        $paidSubjects = count($paidSubjectIds);

        if ($totalSubjects === 0) {
            return 'no_subjects';
        }

        if ($paidSubjects === $totalSubjects) {
            return 'paid';
        }

        if ($paidSubjects > 0) {
            return 'partial';
        }

        return 'unpaid';
    }

    /**
     * Check if student has a specific subject.
     */
    public function hasSubject($subjectId): bool
    {
        return $this->subjects()->where('subjects.id', $subjectId)->exists();
    }

    /**
     * Check if student can join a class (has the class subject and correct grade level).
     */
    public function canJoinClass(Classes $class): bool
    {
        return $this->hasSubject($class->subject_id) && $class->acceptsGrade($this->grade);
    }

    /**
     * Get the reason why student cannot join a class.
     */
    public function getJoinClassRestrictionReason(Classes $class): ?string
    {
        if (!$this->hasSubject($class->subject_id)) {
            return 'Student is not enrolled in the subject: ' . $class->subject->getName();
        }
        
        if (!$class->acceptsGrade($this->grade)) {
            return 'Student grade (' . $this->grade . ') is not accepted by this class. Accepted grades: ' . $class->grade_levels_display;
        }
        
        return null;
    }
}
