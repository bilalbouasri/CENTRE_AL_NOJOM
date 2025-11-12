<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportStudentsRequest;
use App\Http\Requests\StoreStudentRequest;
use App\Models\Classes;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $grade = $request->get('grade');
        $paymentStatus = $request->get('payment_status');
        $sort = $request->get('sort', 'joined_date_desc'); // Default to newest first

        $currentMonth = date('n');
        $currentYear = date('Y');

        $students = Student::with(['subjects', 'monthlyPayments'])
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                });
            })
            ->when($grade, function ($query) use ($grade) {
                return $query->where('grade', $grade);
            })
            ->get()
            ->map(function ($student) use ($currentMonth, $currentYear) {
                $paidSubjectIds = $student->monthlyPayments
                    ->where('payment_month', $currentMonth)
                    ->where('payment_year', $currentYear)
                    ->pluck('subject_id')
                    ->toArray();
                $totalSubjects = $student->subjects->count();
                $paidSubjects = count($paidSubjectIds);
                $unpaidSubjects = $totalSubjects - $paidSubjects;

                // Add payment status for sorting
                $student->payment_status = $unpaidSubjects === 0 && $totalSubjects > 0 ? 'paid' : ($paidSubjects > 0 && $unpaidSubjects > 0 ? 'partial' : 'unpaid');
                $student->unpaid_subjects_count = $unpaidSubjects;
                $student->paid_subjects_count = $paidSubjects;
                $student->total_subjects_count = $totalSubjects;

                return $student;
            });

        // Apply payment status filter
        if ($paymentStatus) {
            $students = $students->filter(function ($student) use ($paymentStatus) {
                return $student->payment_status === $paymentStatus;
            });
        }

        // Apply sorting
        switch ($sort) {
            case 'name_asc':
                $students = $students->sortBy(function ($student) {
                    return $student->first_name.' '.$student->last_name;
                });
                break;
            case 'name_desc':
                $students = $students->sortByDesc(function ($student) {
                    return $student->first_name.' '.$student->last_name;
                });
                break;
            case 'joined_date_asc':
                $students = $students->sortBy('joined_date');
                break;
            case 'joined_date_desc':
                $students = $students->sortByDesc('joined_date');
                break;
            case 'grade_asc':
                $students = $students->sortBy(function ($student) {
                    return (int) $student->grade;
                });
                break;
            case 'grade_desc':
                $students = $students->sortByDesc(function ($student) {
                    return (int) $student->grade;
                });
                break;
            default:
                // Default: unpaid first, then newest first
                $students = $students->sortBy([
                    function ($student) {
                        // Priority: unpaid (0), partial (1), paid (2)
                        return $student->payment_status === 'unpaid' ? 0 : ($student->payment_status === 'partial' ? 1 : 2);
                    },
                    function ($student) {
                        return -$student->joined_date->timestamp; // Newest first (negative for descending)
                    },
                ]);
                break;
        }

        $subjects = Subject::all();

        // Calculate student statistics
        $totalStudents = Student::count();

        // Calculate payment statistics for current month
        $currentMonth = date('n');
        $currentYear = date('Y');

        // Get all students with their payment status for current month
        $studentsWithPaymentStatus = Student::with(['subjects', 'monthlyPayments' => function ($query) use ($currentMonth, $currentYear) {
            $query->where('payment_month', $currentMonth)
                ->where('payment_year', $currentYear);
        }])->get();

        // Count students by payment status
        $paidStudents = 0;
        $partiallyPaidStudents = 0;
        $unpaidStudents = 0;

        foreach ($studentsWithPaymentStatus as $student) {
            $paidSubjectIds = $student->monthlyPayments->pluck('subject_id')->toArray();
            $totalSubjects = $student->subjects->count();
            $paidSubjects = count($paidSubjectIds);

            if ($totalSubjects === 0) {
                // Students with no subjects are considered unpaid
                $unpaidStudents++;
            } elseif ($paidSubjects === $totalSubjects) {
                // All subjects paid
                $paidStudents++;
            } elseif ($paidSubjects > 0) {
                // Some subjects paid
                $partiallyPaidStudents++;
            } else {
                // No subjects paid
                $unpaidStudents++;
            }
        }

        // New students: students who joined in the current month
        $newStudents = Student::whereYear('joined_date', $currentYear)
            ->whereMonth('joined_date', $currentMonth)
            ->count();

        return view('students.index', compact(
            'students',
            'subjects',
            'search',
            'grade',
            'paymentStatus',
            'sort',
            'totalStudents',
            'paidStudents',
            'partiallyPaidStudents',
            'unpaidStudents',
            'newStudents'
        ));
    }

    public function create()
    {
        $subjects = Subject::all();

        return view('students.create', compact('subjects'));
    }

    /**
     * Store a newly created student in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        try {
            $validated = $request->validated();
            
            $student = Student::create($validated);

            if ($request->has('subjects')) {
                $student->subjects()->sync($request->subjects);
            }

            return redirect()->route('students.index')
                ->with('success', __('Student created successfully.'));
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create student. Please try again.');
        }
    }

    public function show(Student $student)
    {
        $student->load('subjects', 'payments', 'classes', 'monthlyPayments.subject');

        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $subjects = Subject::all();
        $student->load('subjects');

        return view('students.edit', compact('student', 'subjects'));
    }

    /**
     * Update the specified student in storage.
     */
    public function update(StoreStudentRequest $request, Student $student)
    {
        try {
            $validated = $request->validated();
            
            $student->update($validated);

            if ($request->has('subjects')) {
                $student->subjects()->sync($request->subjects);
            }

            return redirect()->route('students.index')
                ->with('success', __('Student updated successfully.'));
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update student. Please try again.');
        }
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')->with('success', __('Student deleted successfully.'));
    }

    /**
     * Show form to join student to a class
     */
    public function joinClass(Student $student)
    {
        $classes = Classes::with(['teacher', 'subject'])->get();

        return view('students.join-class', compact('student', 'classes'));
    }

    /**
     * Store the class assignment for the student
     */
    public function storeJoinClass(Request $request, Student $student)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
        ]);

        // Check if student is already in this class
        if ($student->classes()->where('class_id', $validated['class_id'])->exists()) {
            return redirect()->route('students.show', $student)
                ->with('error', 'Student is already in this class.');
        }

        // Add student to class
        $student->classes()->attach($validated['class_id']);

        return redirect()->route('students.show', $student)
            ->with('success', 'Student successfully joined the class.');
    }

    /**
     * Show the import form
     */
    public function import()
    {
        return view('students.import');
    }

    /**
     * Process the bulk import of students from JSON file
     */
    public function processImport(ImportStudentsRequest $request)
    {
        try {
            $file = $request->file('json_file');
            $jsonContent = file_get_contents($file->getRealPath());
            $studentsData = json_decode($jsonContent, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return redirect()->back()
                    ->with('error', 'Invalid JSON format: ' . json_last_error_msg());
            }

            if (!is_array($studentsData)) {
                return redirect()->back()
                    ->with('error', 'JSON file must contain an array of student objects.');
            }

            $importedCount = 0;
            $errors = [];

            DB::beginTransaction();

            foreach ($studentsData as $index => $studentData) {
                try {
                    // Validate required fields
                    if (!isset($studentData['first_name']) || !isset($studentData['last_name']) ||
                        !isset($studentData['phone']) || !isset($studentData['grade']) ||
                        !isset($studentData['joined_date'])) {
                        $errors[] = "Row " . ($index + 1) . ": Missing required fields (first_name, last_name, phone, grade, joined_date)";
                        continue;
                    }

                    // Check if student with same phone already exists
                    $existingStudent = Student::where('phone', $studentData['phone'])->first();
                    if ($existingStudent) {
                        $errors[] = "Row " . ($index + 1) . ": Student with phone {$studentData['phone']} already exists";
                        continue;
                    }

                    // Create student
                    $student = Student::create([
                        'first_name' => trim($studentData['first_name']),
                        'last_name' => trim($studentData['last_name']),
                        'phone' => trim($studentData['phone']),
                        'grade' => trim($studentData['grade']),
                        'joined_date' => $studentData['joined_date'],
                        'notes' => $studentData['notes'] ?? null,
                    ]);

                    // Handle subjects if provided
                    if (isset($studentData['subjects']) && is_array($studentData['subjects'])) {
                        $subjectIds = [];
                        foreach ($studentData['subjects'] as $subjectName) {
                            $subject = Subject::where('name', $subjectName)->first();
                            if ($subject) {
                                $subjectIds[] = $subject->id;
                            }
                        }
                        if (!empty($subjectIds)) {
                            $student->subjects()->sync($subjectIds);
                        }
                    }

                    $importedCount++;
                } catch (\Exception $e) {
                    $errors[] = "Row " . ($index + 1) . ": " . $e->getMessage();
                }
            }

            DB::commit();

            $message = "Successfully imported {$importedCount} students.";
            if (!empty($errors)) {
                $message .= " " . count($errors) . " errors occurred.";
                session()->flash('import_errors', $errors);
            }

            return redirect()->route('students.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
}
