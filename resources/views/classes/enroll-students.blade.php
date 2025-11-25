@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border border-gray-100 dark:border-gray-700">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div class="flex-1">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white">
                            Enroll Students - {{ $class->name }}
                        </h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-2 text-lg">
                            Select students who are eligible to join this class based on grade level and subject enrollment
                        </p>
                    </div>
                </div>
            </div>
            <a href="{{ route('classes.show', $class) }}"
               class="inline-flex items-center px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-lg text-base font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 transition-all duration-300">
                <svg class="w-5 h-5 ltr:mr-3 rtl:ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Class
            </a>
        </div>
    </div>

    <!-- Class Information -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border border-gray-100 dark:border-gray-700">
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Class Requirements</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-4 border-2 border-gray-100 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700">
                <label class="text-base font-semibold text-gray-500 dark:text-gray-400">Subject</label>
                <p class="mt-2 text-lg font-medium text-gray-900 dark:text-white">{{ $class->subject->getName() }}</p>
            </div>
            <div class="p-4 border-2 border-gray-100 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700">
                <label class="text-base font-semibold text-gray-500 dark:text-gray-400">Teacher</label>
                <p class="mt-2 text-lg font-medium text-gray-900 dark:text-white">{{ $class->teacher->first_name }} {{ $class->teacher->last_name }}</p>
            </div>
            <div class="p-4 border-2 border-gray-100 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700">
                <label class="text-base font-semibold text-gray-500 dark:text-gray-400">Grade Levels</label>
                <p class="mt-2 text-lg font-medium text-gray-900 dark:text-white">
                    @if(!empty($class->grade_levels))
                        {{ implode(', ', $class->grade_levels) }}
                    @else
                        All Grades
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Eligible Students Section -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border border-gray-100 dark:border-gray-700">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
            <div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Eligible Students</h3>
                <p class="text-lg text-gray-600 dark:text-gray-400 mt-1">
                    {{ $availableStudents->count() }} students meet the class requirements
                </p>
            </div>
        </div>

        @if($availableStudents->count() > 0)
            <form method="POST" action="{{ route('classes.append-students', $class) }}">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-h-96 overflow-y-auto border-2 border-gray-200 dark:border-gray-600 rounded-xl p-6 bg-white dark:bg-gray-700">
                    @foreach($availableStudents as $student)
                        <div class="flex items-center p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200">
                            <input type="checkbox" name="students[]" value="{{ $student->id }}" id="student_{{ $student->id }}"
                                   class="h-5 w-5 text-green-600 focus:ring-green-500 border-gray-300 rounded transition-colors duration-200">
                            <label for="student_{{ $student->id }}" class="ltr:ml-3 rtl:mr-3 flex-1 cursor-pointer">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                        {{ substr($student->first_name, 0, 1) }}{{ substr($student->last_name, 0, 1) }}
                                    </div>
                                    <div class="ltr:ml-3 rtl:mr-3">
                                        <div class="text-base font-medium text-gray-900 dark:text-white">
                                            {{ $student->first_name }} {{ $student->last_name }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            Grade: {{ $student->grade }}
                                        </div>
                                        <div class="text-xs text-green-600 dark:text-green-400 mt-1">
                                            ✓ Eligible for this class
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    @endforeach
                </div>

                <!-- Submit Buttons -->
                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row justify-end gap-4">
                    <a href="{{ route('classes.show', $class) }}"
                       class="inline-flex items-center justify-center px-8 py-4 border-2 border-gray-300 dark:border-gray-600 rounded-xl shadow-lg text-lg font-semibold text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 transition-all duration-300">
                        <svg class="w-6 h-6 ltr:mr-3 rtl:ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancel
                    </a>
                    <button type="submit"
                            class="inline-flex items-center justify-center px-8 py-4 border border-transparent rounded-xl shadow-lg text-lg font-semibold text-white bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-4 focus:ring-green-200 dark:focus:ring-green-800 transition-all duration-300 transform hover:scale-105">
                        <svg class="w-6 h-6 ltr:mr-3 rtl:ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Enroll Selected Students
                    </button>
                </div>
            </form>
        @else
            <div class="text-center py-12">
                <div class="mx-auto h-24 w-24 bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 rounded-full flex items-center justify-center mb-6">
                    <svg class="h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No eligible students found</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-8 max-w-md mx-auto">
                    There are currently no students who meet the requirements for this class. 
                    Students must be enrolled in {{ $class->subject->getName() }} and have the appropriate grade level.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('students.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 ltr:mr-3 rtl:ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add New Student
                    </a>
                    <a href="{{ route('classes.show', $class) }}" class="inline-flex items-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-xl hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-300">
                        Back to Class
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
