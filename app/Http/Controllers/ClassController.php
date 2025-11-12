<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

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
        $students = Student::all();

        return view('classes.create', compact('teachers', 'subjects', 'students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
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
        $students = Student::all();
        $class->load(['students', 'schedules']);

        return view('classes.edit', compact('class', 'teachers', 'subjects', 'students'));
    }

    public function update(Request $request, Classes $class)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
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

        $class->students()->syncWithoutDetaching($validated['students']);

        return redirect()->route('classes.show', $class)->with('success', __('Students added to class successfully.'));
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
