<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Subject Model
 *
 * Represents a subject/course offered at the educational center with multilingual support,
 * fee structure, and relationships to students, teachers, and classes.
 */
class Subject extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name_en',
        'name_ar',
        'description',
        'fee_amount',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fee_amount' => 'decimal:2',
    ];

    /**
     * Get the students enrolled in this subject.
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class);
    }

    /**
     * Get the classes associated with this subject.
     */
    public function classes(): HasMany
    {
        return $this->hasMany(Classes::class);
    }

    /**
     * Get the teachers qualified to teach this subject.
     */
    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class, 'teacher_subject');
    }

    /**
     * Get the localized name of the subject based on current application locale.
     */
    public function getName(): string
    {
        return app()->getLocale() === 'ar' ? $this->name_ar : $this->name_en;
    }

    /**
     * Get the number of students enrolled in this subject.
     */
    public function getStudentCountAttribute(): int
    {
        return $this->students()->count();
    }

    /**
     * Get the number of classes for this subject.
     */
    public function getClassCountAttribute(): int
    {
        return $this->classes()->count();
    }

    /**
     * Get the number of teachers qualified for this subject.
     */
    public function getTeacherCountAttribute(): int
    {
        return $this->teachers()->count();
    }

    /**
     * Get the total monthly revenue for this subject.
     */
    public function getMonthlyRevenue($month = null, $year = null): float
    {
        $month = $month ?? now()->month;
        $year = $year ?? now()->year;

        return StudentMonthlyPayment::where('subject_id', $this->id)
            ->where('payment_month', $month)
            ->where('payment_year', $year)
            ->sum('amount');
    }

    /**
     * Get the formatted fee amount.
     */
    public function getFormattedFeeAttribute(): string
    {
        return 'MAD '.number_format($this->fee_amount, 2);
    }
}
