@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Join Student to Class</h1>
                <p class="text-gray-600">Add {{ $student->full_name }} to a class</p>
            </div>
            <a href="{{ route('students.show', $student) }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200">
                <svg class="w-5 h-5 ltr:mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Student
            </a>
        </div>

        <!-- Student Info -->
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $student->full_name }}</h3>
                    <p class="text-gray-600">{{ $student->grade }} • {{ $student->phone }}</p>
                </div>
            </div>
        </div>

        <!-- Current Classes -->
        @if($student->classes->count() > 0)
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-3">Current Classes</h3>
            <div class="space-y-2">
                @foreach($student->classes as $class)
                <div class="flex items-center justify-between bg-blue-50 rounded-lg p-3">
                    <div>
                        <span class="font-medium text-blue-900">{{ $class->name }}</span>
                        <span class="text-sm text-blue-700 ml-2">({{ $class->subject->getName() }} - {{ $class->teacher->full_name }})</span>
                    </div>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        Already Enrolled
                    </span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Join Class Form -->
        @if($classes->count() > 0)
        <form action="{{ route('students.store-join-class', $student) }}" method="POST">
            @csrf
            
            <div class="space-y-4">
                <!-- Class Selection -->
                <div>
                    <label for="class_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Select Class
                    </label>
                    <select id="class_id" name="class_id" required
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                        <option value="">Choose a class...</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">
                                {{ $class->name }} - {{ $class->subject->getName() }} ({{ $class->teacher->full_name }}) - {{ $class->grade_levels_display }}
                            </option>
                        @endforeach
                    </select>
                    @error('class_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end space-x-3 pt-4">
                    <a href="{{ route('students.show', $student) }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200">
                        Cancel
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        <svg class="w-5 h-5 ltr:mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        Join to Class
                    </button>
                </div>
            </div>
        </form>
        @else
        <!-- No Available Classes Message -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
            <svg class="w-12 h-12 text-yellow-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
            <h3 class="text-lg font-medium text-yellow-800 mb-2">No Available Classes</h3>
            <p class="text-yellow-700 mb-4">
                This student is not enrolled in any subjects, or there are no classes available for their enrolled subjects.
            </p>
            <div class="space-x-3">
                <a href="{{ route('students.edit', $student) }}"
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all duration-200">
                    <svg class="w-5 h-5 ltr:mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Student Subjects
                </a>
                <a href="{{ route('students.show', $student) }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200">
                    Back to Student
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection