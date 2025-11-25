@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border border-gray-100 dark:border-gray-700">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div class="flex-1">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white">
                            {{ $class->name ?? 'Unnamed Class' }}
                        </h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-2 text-lg">Class details and information</p>
                    </div>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('classes.edit', $class) }}"
                   class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-xl shadow-lg text-base font-semibold text-white bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200 dark:focus:ring-indigo-800 transition-all duration-300 transform hover:scale-105">
                    <svg class="w-5 h-5 ltr:mr-3 rtl:ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    {{ __('messages.edit') }}
                </a>
                <a href="{{ route('classes.index') }}"
                   class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-lg text-base font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 transition-all duration-300">
                    <svg class="w-5 h-5 ltr:mr-3 rtl:ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Classes
                </a>
            </div>
        </div>
    </div>

    <!-- Class Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Information -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Basic Information Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border border-gray-100 dark:border-gray-700">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Class Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-4 border-2 border-gray-100 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 transition-all duration-300 hover:shadow-md">
                        <label class="text-base font-semibold text-gray-500 dark:text-gray-400">Class Name</label>
                        <p class="mt-2 text-lg font-medium text-gray-900 dark:text-white flex items-center">
                            <svg class="w-5 h-5 ltr:mr-3 rtl:ml-3 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            {{ $class->name ?? 'Unnamed Class' }}
                        </p>
                    </div>
                    <div class="p-4 border-2 border-gray-100 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 transition-all duration-300 hover:shadow-md">
                        <label class="text-base font-semibold text-gray-500 dark:text-gray-400">Teacher</label>
                        <p class="mt-2 text-lg font-medium text-gray-900 dark:text-white flex items-center">
                            <svg class="w-5 h-5 ltr:mr-3 rtl:ml-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            {{ $class->teacher->first_name }} {{ $class->teacher->last_name }}
                        </p>
                    </div>
                    <div class="p-4 border-2 border-gray-100 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 transition-all duration-300 hover:shadow-md">
                        <label class="text-base font-semibold text-gray-500 dark:text-gray-400">Subject</label>
                        <p class="mt-2 text-lg font-medium text-gray-900 dark:text-white flex items-center">
                            <svg class="w-5 h-5 ltr:mr-3 rtl:ml-3 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            {{ $class->subject->getName() }}
                        </p>
                    </div>
                    @if(!empty($class->grade_levels))
                    <div class="p-4 border-2 border-gray-100 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 transition-all duration-300 hover:shadow-md">
                        <label class="text-base font-semibold text-gray-500 dark:text-gray-400">Grade Levels</label>
                        <p class="mt-2 text-lg font-medium text-gray-900 dark:text-white flex items-center">
                            <svg class="w-5 h-5 ltr:mr-3 rtl:ml-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ implode(', ', $class->grade_levels) }}
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Students Section -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border border-gray-100 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Students</h3>
                        <p class="text-lg text-gray-600 dark:text-gray-400 mt-1">{{ $class->students->count() }} enrolled</p>
                    </div>
                    <a href="{{ route('classes.enroll-students', $class) }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 text-white font-semibold rounded-xl hover:from-purple-700 hover:to-purple-800 transition-all duration-300 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 ltr:mr-3 rtl:ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add Students
                    </a>
                </div>
                @if($class->students->count() > 0)
                    <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-600">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider">Grade</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider">Phone</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                                @foreach($class->students as $student)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                                    {{ substr($student->first_name, 0, 1) }}{{ substr($student->last_name, 0, 1) }}
                                                </div>
                                                <div class="ltr:ml-4 rtl:mr-4">
                                                    <div class="text-base font-medium text-gray-900 dark:text-white">{{ $student->first_name }} {{ $student->last_name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                                {{ $student->grade ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-base text-gray-500 dark:text-gray-400">
                                            {{ $student->phone ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-base font-medium">
                                            <div class="flex space-x-3">
                                                <a href="{{ route('students.show', $student) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 transition-colors duration-200 font-semibold">View</a>
                                                <form action="{{ route('classes.remove-students', [$class, $student]) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to remove this student from the class?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 transition-colors duration-200 font-semibold">Remove</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="mx-auto h-24 w-24 bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 rounded-full flex items-center justify-center mb-6">
                            <svg class="h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No students enrolled</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-8 max-w-md mx-auto">Start building your class by adding students who will participate in this course.</p>
                        <a href="{{ route('classes.enroll-students', $class) }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-600 to-purple-700 text-white font-semibold rounded-xl hover:from-purple-700 hover:to-purple-800 transition-all duration-300 shadow-lg hover:shadow-xl text-lg">
                            <svg class="w-6 h-6 ltr:mr-3 rtl:ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add First Student
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-8">
            <!-- Quick Stats -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border border-gray-100 dark:border-gray-700">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Quick Stats</h3>
                <div class="space-y-6">
                    <div class="flex items-center justify-between p-4 border-2 border-gray-100 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 transition-all duration-300 hover:shadow-md">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <span class="text-base font-semibold text-gray-500 dark:text-gray-400">Total Students</span>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $class->students->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border border-gray-100 dark:border-gray-700">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Actions</h3>
                <div class="space-y-4">
                    <a href="{{ route('classes.edit', $class) }}"
                       class="w-full inline-flex items-center justify-center px-6 py-4 border border-transparent rounded-xl shadow-lg text-base font-semibold text-white bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200 dark:focus:ring-indigo-800 transition-all duration-300 transform hover:scale-105">
                        <svg class="w-5 h-5 ltr:mr-3 rtl:ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Class
                    </a>
                    <form action="{{ route('classes.destroy', $class) }}" method="POST" class="w-full">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full inline-flex items-center justify-center px-6 py-4 border border-transparent rounded-xl shadow-lg text-base font-semibold text-white bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-4 focus:ring-red-200 dark:focus:ring-red-800 transition-all duration-300 transform hover:scale-105"
                                onclick="return confirm('Are you sure you want to delete this class?')">
                            <svg class="w-5 h-5 ltr:mr-3 rtl:ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Class
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
