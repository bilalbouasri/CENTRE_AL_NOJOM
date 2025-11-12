<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with(['subjects'])->get();
        $subjects = Subject::all();

        // Calculate top teachers by student count (revenue perspective)
        $topTeachers = Teacher::with(['classes.students'])->get()
            ->map(function ($teacher) {
                $teacher->student_count = $teacher->classes->flatMap->students->unique('id')->count();

                return $teacher;
            })
            ->sortByDesc('student_count')
            ->take(3)
            ->values();

        return view('teachers.index', compact('teachers', 'subjects', 'topTeachers'));
    }

    public function create()
    {
        $subjects = Subject::all();

        return view('teachers.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'joined_date' => 'required|date',
            'monthly_percentage' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string',
            'subjects' => 'array',
        ]);

        $teacher = Teacher::create($validated);

        if ($request->has('subjects')) {
            $teacher->subjects()->sync($request->subjects);
        }

        return redirect()->route('teachers.index')->with('success', __('Teacher created successfully.'));
    }

    public function show(Teacher $teacher)
    {
        $teacher->load('classes');

        return view('teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        $subjects = Subject::all();
        $teacher->load('subjects');

        return view('teachers.edit', compact('teacher', 'subjects'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'joined_date' => 'required|date',
            'monthly_percentage' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string',
            'subjects' => 'array',
        ]);

        $teacher->update($validated);

        if ($request->has('subjects')) {
            $teacher->subjects()->sync($request->subjects);
        }

        return redirect()->route('teachers.index')->with('success', __('Teacher updated successfully.'));
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();

        return redirect()->route('teachers.index')->with('success', __('Teacher deleted successfully.'));
    }
}
