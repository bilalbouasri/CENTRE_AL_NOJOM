<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classes extends Model
{
    protected $fillable = [
        'name',
        'teacher_id',
        'subject_id',
        'grade_levels',
    ];

    protected $casts = [
        'grade_levels' => 'array',
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'class_student', 'class_id', 'student_id');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(ClassSchedule::class, 'class_id');
    }

    /**
     * Check if class accepts a specific grade level.
     */
    public function acceptsGrade($grade): bool
    {
        if (empty($this->grade_levels)) {
            return true; // If no grade levels specified, accept all grades
        }
        
        return in_array($grade, $this->grade_levels);
    }

    /**
     * Get formatted grade levels string.
     */
    public function getFormattedGradeLevelsAttribute(): string
    {
        if (empty($this->grade_levels)) {
            return 'All Grades';
        }
        
        sort($this->grade_levels);
        return 'Grades: ' . implode(', ', $this->grade_levels);
    }

    /**
     * Get grade levels as a readable string.
     */
    public function getGradeLevelsDisplayAttribute(): string
    {
        if (empty($this->grade_levels)) {
            return 'All Grades';
        }
        
        sort($this->grade_levels);
        return implode(', ', $this->grade_levels);
    }
}
