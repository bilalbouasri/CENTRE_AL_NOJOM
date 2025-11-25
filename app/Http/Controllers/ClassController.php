<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClassController extends Controller
{
    public function index()
    {
        $classes = Classes::with(['teacher', 'subject', 'students', 'schedules'])->get();

        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        $teachers = Teacher::all();
        $subjects = Subject::all();

        return view('classes.create', compact('teachers', 'subjects'));
    }

    public function enrollStudents(Classes $class)
    {
        // Get students who are eligible to join this class
        // - Have the correct grade level (if class has grade restrictions)
        // - Are enrolled in the class subject
        $eligibleStudents = Student::whereHas('subjects', function($query) use ($class) {
            $query->where('subjects.id', $class->subject_id);
        })->get()->filter(function($student) use ($class) {
            return $student->canJoinClass($class);
        });

        // Get students already in the class
        $currentStudents = $class->students->pluck('id')->toArray();

        // Filter out students already in the class
        $availableStudents = $eligibleStudents->filter(function($student) use ($currentStudents) {
            return !in_array($student->id, $currentStudents);
        });

        return view('classes.enroll-students', compact('class', 'availableStudents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'grade_levels' => 'nullable|array',
            'grade_levels.*' => 'string|max:10',
            'students' => 'array',
            'schedules' => 'array',
            'schedules.*.day_of_week' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'schedules.*.start_time' => 'required|date_format:H:i',
            'schedules.*.end_time' => 'required|date_format:H:i|after:schedules.*.start_time',
            'schedules.*.duration_hours' => 'required|numeric|min:0.5|max:4',
        ]);

        $class = Classes::create($validated);

        if ($request->has('students')) {
            $class->students()->sync($request->students);
        }

        // Create schedules
        if ($request->has('schedules')) {
            foreach ($request->schedules as $scheduleData) {
                $class->schedules()->create($scheduleData);
            }
        }

        return redirect()->route('classes.index')->with('success', __('Class created successfully.'));
    }

    public function show(Classes $class)
    {
        $class->load(['teacher', 'subject', 'students', 'schedules']);

        return view('classes.show', compact('class'));
    }

    public function edit(Classes $class)
    {
        $teachers = Teacher::all();
        $subjects = Subject::all();
        
        // Get all students that can join this class (have the subject and correct grade level)
        $students = Student::all()->filter(function($student) use ($class) {
            return $student->canJoinClass($class);
        });
        
        $class->load(['students', 'schedules']);

        return view('classes.edit', compact('class', 'teachers', 'subjects', 'students'));
    }

    public function update(Request $request, Classes $class)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'grade_levels' => 'nullable|array',
            'grade_levels.*' => 'string|max:10',
            'students' => 'array',
            'schedules' => 'array',
            'schedules.*.day_of_week' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'schedules.*.start_time' => 'required|date_format:H:i',
            'schedules.*.end_time' => 'required|date_format:H:i|after:schedules.*.start_time',
            'schedules.*.duration_hours' => 'required|numeric|min:0.5|max:4',
        ]);

        $class->update($validated);

        if ($request->has('students')) {
            $class->students()->sync($request->students);
        }

        // Update schedules
        if ($request->has('schedules')) {
            // Delete existing schedules
            $class->schedules()->delete();

            // Create new schedules
            foreach ($request->schedules as $scheduleData) {
                $class->schedules()->create($scheduleData);
            }
        }

        return redirect()->route('classes.index')->with('success', __('Class updated successfully.'));
    }

    public function destroy(Classes $class)
    {
        $class->delete();

        return redirect()->route('classes.index')->with('success', __('Class deleted successfully.'));
    }

    /**
     * Append students to a class
     */
    public function appendStudents(Request $request, Classes $class)
    {
        $validated = $request->validate([
            'students' => 'required|array',
            'students.*' => 'exists:students,id',
        ]);

        // Filter students who have the class subject and correct grade level
        $eligibleStudents = [];
        $ineligibleStudents = [];

        foreach ($validated['students'] as $studentId) {
            $student = Student::find($studentId);
            if ($student->canJoinClass($class)) {
                $eligibleStudents[] = $studentId;
            } else {
                $reason = $student->getJoinClassRestrictionReason($class);
                $ineligibleStudents[] = $student->full_name . ' (' . $reason . ')';
            }
        }

        // Add only eligible students to the class
        if (!empty($eligibleStudents)) {
            $class->students()->syncWithoutDetaching($eligibleStudents);
        }

        // Prepare success message
        $message = '';
        if (!empty($eligibleStudents)) {
            $message = __('Students added to class successfully.');
        }
        
        if (!empty($ineligibleStudents)) {
            $ineligibleNames = implode(', ', $ineligibleStudents);
            $message .= ' ' . __('The following students were not added because they are not enrolled in the subject: :names', ['names' => $ineligibleNames]);
        }

        return redirect()->route('classes.show', $class)->with(
            !empty($eligibleStudents) ? 'success' : 'warning',
            $message ?: __('No students were added to the class.')
        );
    }

    /**
     * Remove students from a class
     */
    public function removeStudents(Request $request, Classes $class)
    {
        $validated = $request->validate([
            'students' => 'required|array',
            'students.*' => 'exists:students,id',
        ]);

        $class->students()->detach($validated['students']);

        return redirect()->route('classes.show', $class)->with('success', __('Students removed from class successfully.'));
    }
}
