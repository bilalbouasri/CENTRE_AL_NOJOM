@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center">
                    <svg class="w-8 h-8 ltr:mr-3 rtl:ml-3 text-blue-600 dark:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    {{ __('messages.edit_student') }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Update student information</p>
            </div>
            <div class="flex items-center space-x-3">
                <form action="{{ route('students.destroy', $student) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this student? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200">
                        <svg class="w-5 h-5 ltr:mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        {{ __('messages.delete') }}
                    </button>
                </form>
                <a href="{{ route('students.index') }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200">
                    <svg class="w-5 h-5 ltr:mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('messages.back_to_students') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
        <form method="POST" action="{{ route('students.update', $student) }}" class="space-y-8">
            @csrf
            @method('PUT')
            
            <!-- Personal Information -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Personal Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- First Name -->
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.first_name') }}</label>
                        <input type="text" name="first_name" id="first_name" required
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('first_name') border-red-500 @enderror transition-colors duration-200 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                               value="{{ old('first_name', $student->first_name) }}">
                        @error('first_name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.last_name') }}</label>
                        <input type="text" name="last_name" id="last_name" required
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('last_name') border-red-500 @enderror transition-colors duration-200 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                               value="{{ old('last_name', $student->last_name) }}">
                        @error('last_name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.phone') }}</label>
                        <input type="tel" name="phone" id="phone" required
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('phone') border-red-500 @enderror transition-colors duration-200 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                               value="{{ old('phone', $student->phone) }}">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Grade -->
                    <div>
                        <label for="grade" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.grade') }}</label>
                        <select name="grade" id="grade" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('grade') border-red-500 @enderror transition-colors duration-200 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <option value="">Select Grade</option>
                            <option value="1st Grade" {{ old('grade', $student->grade) == '1st Grade' ? 'selected' : '' }}>1st Grade</option>
                            <option value="2nd Grade" {{ old('grade', $student->grade) == '2nd Grade' ? 'selected' : '' }}>2nd Grade</option>
                            <option value="3rd Grade" {{ old('grade', $student->grade) == '3rd Grade' ? 'selected' : '' }}>3rd Grade</option>
                            <option value="4th Grade" {{ old('grade', $student->grade) == '4th Grade' ? 'selected' : '' }}>4th Grade</option>
                            <option value="5th Grade" {{ old('grade', $student->grade) == '5th Grade' ? 'selected' : '' }}>5th Grade</option>
                            <option value="6th Grade" {{ old('grade', $student->grade) == '6th Grade' ? 'selected' : '' }}>6th Grade</option>
                            <option value="7th Grade" {{ old('grade', $student->grade) == '7th Grade' ? 'selected' : '' }}>7th Grade</option>
                            <option value="8th Grade" {{ old('grade', $student->grade) == '8th Grade' ? 'selected' : '' }}>8th Grade</option>
                            <option value="9th Grade" {{ old('grade', $student->grade) == '9th Grade' ? 'selected' : '' }}>9th Grade</option>
                            <option value="10th Grade" {{ old('grade', $student->grade) == '10th Grade' ? 'selected' : '' }}>10th Grade</option>
                            <option value="11th Grade" {{ old('grade', $student->grade) == '11th Grade' ? 'selected' : '' }}>11th Grade</option>
                            <option value="12th Grade" {{ old('grade', $student->grade) == '12th Grade' ? 'selected' : '' }}>12th Grade</option>
                        </select>
                        @error('grade')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Joined Date -->
                    <div>
                        <label for="joined_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.joined_date') }}</label>
                        <input type="date" name="joined_date" id="joined_date" required
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('joined_date') border-red-500 @enderror transition-colors duration-200 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                               value="{{ old('joined_date', $student->joined_date->format('Y-m-d')) }}">
                        @error('joined_date')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Subjects Selection -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Subjects Selection</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Select the subjects this student will study:</p>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($subjects as $subject)
                        <div class="flex items-center">
                            <input type="checkbox" name="subjects[]" value="{{ $subject->id }}" id="subject_{{ $subject->id }}"
                                   class="h-4 w-4 text-primary-600 dark:text-primary-500 focus:ring-primary-500 border-gray-300 dark:border-gray-600 rounded transition-colors duration-200"
                                   {{ in_array($subject->id, old('subjects', $student->subjects->pluck('id')->toArray())) ? 'checked' : '' }}>
                            <label for="subject_{{ $subject->id }}" class="ltr:ml-2 rtl:mr-2 block text-sm text-gray-900 dark:text-gray-100">
                                {{ $subject->getName() }}
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('subjects')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Additional Notes</h3>
                <textarea name="notes" id="notes" rows="4"
                          class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 @error('notes') border-red-500 @enderror transition-colors duration-200 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                          placeholder="Any additional notes about the student...">{{ old('notes', $student->notes) }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('students.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200">
                    {{ __('messages.cancel') }}
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200">
                    <svg class="w-5 h-5 ltr:mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ __('messages.update_student') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
