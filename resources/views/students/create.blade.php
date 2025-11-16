
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div class="flex-1">
                        <div class="flex items-center ltr:space-x-4 rtl:space-x-reverse">
                            <div class="flex-shrink-0 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-3">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white">
                                    {{ __('messages.add_new_student') }}
                                </h1>
                                <p class="text-lg text-gray-600 dark:text-gray-400 mt-2">
                                    {{ __('messages.add_new_student_description') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('students.index') }}" 
                       class="inline-flex items-center px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-base font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200 shadow-sm hover:shadow-md">
                        <svg class="w-5 h-5 ltr:mr-3 rtl:ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        {{ __('messages.back_to_students') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <form method="POST" action="{{ route('students.store') }}" class="space-y-0" id="student-form">
                @csrf
                
                <!-- Progress Steps -->
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <div class="px-8 py-6">
                        <div class="flex items-center justify-center ltr:space-x-8 rtl:space-x-reverse">
                            <div class="flex items-center ltr:space-x-3 rtl:space-x-reverse">
                                <div class="flex-shrink-0 w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-primary-600 dark:text-primary-400">{{ __('messages.personal_info') }}</span>
                            </div>
                            <div class="flex-1 h-0.5 bg-gray-200 dark:bg-gray-700"></div>
                            <div class="flex items-center ltr:space-x-3 rtl:space-x-reverse">
                                <div class="flex-shrink-0 w-8 h-8 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.subjects') }}</span>
                            </div>
                            <div class="flex-1 h-0.5 bg-gray-200 dark:bg-gray-700"></div>
                            <div class="flex items-center ltr:space-x-3 rtl:space-x-reverse">
                                <div class="flex-shrink-0 w-8 h-8 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.additional_info') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Personal Information Section -->
                <div class="p-8 border-b border-gray-200 dark:border-gray-700">
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                            <svg class="w-6 h-6 ltr:mr-3 rtl:ml-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            {{ __('messages.personal_information') }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mt-2 ltr:ml-9 rtl:mr-9">{{ __('messages.basic_details_description') }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- First Name -->
                        <div class="space-y-3">
                            <label for="first_name" class="block text-base font-semibold text-gray-900 dark:text-white flex items-center">
                                <svg class="w-4 h-4 ltr:mr-2 rtl:ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ __('messages.first_name') }}
                                <span class="text-red-500 ltr:ml-1 rtl:mr-1">*</span>
                            </label>
                            <input type="text" name="first_name" id="first_name" required
                                   class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-200 @error('first_name') border-red-500 ring-2 ring-red-200 @enderror"
                                   placeholder="{{ __('messages.enter_first_name_placeholder') }}"
                                   value="{{ old('first_name') }}">
                            @error('first_name')
                                <p class="text-sm text-red-600 dark:text-red-400 flex items-center mt-2">
                                    <svg class="w-4 h-4 ltr:mr-1 rtl:ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Last Name -->
                        <div class="space-y-3">
                            <label for="last_name" class="block text-base font-semibold text-gray-900 dark:text-white flex items-center">
                                <svg class="w-4 h-4 ltr:mr-2 rtl:ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ __('messages.last_name') }}
                                <span class="text-red-500 ltr:ml-1 rtl:mr-1">*</span>
                            </label>
                            <input type="text" name="last_name" id="last_name" required
                                   class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-200 @error('last_name') border-red-500 ring-2 ring-red-200 @enderror"
                                   placeholder="{{ __('messages.enter_last_name_placeholder') }}"
                                   value="{{ old('last_name') }}">
                            @error('last_name')
                                <p class="text-sm text-red-600 dark:text-red-400 flex items-center mt-2">
                                    <svg class="w-4 h-4 ltr:mr-1 rtl:ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="space-y-3">
                            <label for="phone" class="block text-base font-semibold text-gray-900 dark:text-white flex items-center">
                                <svg class="w-4 h-4 ltr:mr-2 rtl:ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                {{ __('messages.phone') }}
                                <span class="text-red-500 ltr:ml-1 rtl:mr-1">*</span>
                            </label>
                            <input type="tel" name="phone" id="phone" required
                                   class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-200 @error('phone') border-red-500 ring-2 ring-red-200 @enderror"
                                   placeholder="{{ __('messages.phone_placeholder') }}"
                                   value="{{ old('phone') }}">
                            @error('phone')
                                <p class="text-sm text-red-600 dark:text-red-400 flex items-center mt-2">
                                    <svg class="w-4 h-4 ltr:mr-1 rtl:ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Grade -->
                        <div class="space-y-3">
                            <label for="grade" class="block text-base font-semibold text-gray-900 dark:text-white flex items-center">
                                <svg class="w-4 h-4 ltr:mr-2 rtl:ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l9 5M12 14v8"></path>
                                </svg>
                                {{ __('messages.grade') }}
                                <span class="text-red-500 ltr:ml-1 rtl:mr-1">*</span>
                            </label>
                            <input type="text" name="grade" id="grade" required
                                   class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-200 @error('grade') border-red-500 ring-2 ring-red-200 @enderror"
                                   placeholder="{{ __('messages.enter_grade_placeholder') }}"
                                   value="{{ old('grade') }}">
                            @error('grade')
                                <p class="text-sm text-red-600 dark:text-red-400 flex items-center mt-2">
                                    <svg class="w-4 h-4 ltr:mr-1 rtl:ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Joined Date -->
                        <div class="space-y-3">
                            <label for="joined_date" class="block text-base font-semibold text-gray-900 dark:text-white flex items-center">
                                <svg class="w-4 h-4 ltr:mr-2 rtl:ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ __('messages.joined_date') }}
                                <span class="text-red-500 ltr:ml-1 rtl:mr-1">*</span>
                            </label>
                            <input type="date" name="joined_date" id="joined_date" required
                                   class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-200 @error('joined_date') border-red-500 ring-2 ring-red-200 @enderror"
                                   value="{{ old('joined_date', date('Y-m-d')) }}">
                            @error('joined_date')
                                <p class="text-sm text-red-600 dark:text-red-400 flex items-center mt-2">
                                    <svg class="w-4 h-4 ltr:mr-1 rtl:ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Subjects Selection Section -->
                <div class="p-8 border-b border-gray-200 dark:border-gray-700">
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                            <svg class="w-6 h-6 ltr:mr-3 rtl:ml-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            {{ __('messages.subjects_selection') }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mt-2 ltr:ml-9 rtl:mr-9">{{ __('messages.subjects_selection_description') }}</p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($subjects as $subject)
                                <div class="flex items-center p-3 bg-white dark:bg-gray-600 rounded-lg border border-gray-200 dark:border-gray-500 hover:border-primary-300 dark:hover:border-primary-400 transition-all duration-200">
                                    <input type="checkbox" name="subjects[]" value="{{ $subject->id }}" id="subject_{{ $subject->id }}"
                                           class="h-5 w-5 text-primary-600 focus:ring-primary-500 border-gray-300 dark:border-gray-500 rounded transition-all duration-200"
                                           {{ in_array($subject->id, old('subjects', [])) ? 'checked' : '' }}>
                                    <label for="subject_{{ $subject->id }}" class="ltr:ml-3 rtl:mr-3 block text-sm font-medium text-gray-900 dark:text-white cursor-pointer hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200">
                                        {{ $subject->getName() }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @error('subjects')
                            <p class="text-sm text-red-600 dark:text-red-400 flex items-center mt-4">
                                <svg class="w-4 h-4 ltr:mr-1 rtl:ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Additional Information Section -->
                <div class="p-8">
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                            <svg class="w-6 h-6 ltr:mr-3 rtl:ml-3 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            {{ __('messages.additional_information') }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mt-2 ltr:ml-9 rtl:mr-9">{{ __('messages.additional_info_description') }}</p>
                    </div>

                    <div class="space-y-3">
                        <label for="notes" class="block text-base font-semibold text-gray-900 dark:text-white flex items-center">
                            <svg class="w-4 h-4 ltr:mr-2 rtl:ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            {{ __('messages.notes') }}
                        </label>
                        <textarea name="notes" id="notes" rows="5"
                                  class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-200 resize-none @error('notes') border-red-500 ring-2 ring-red-200 @enderror"
                                  placeholder="{{ __('messages.notes_placeholder') }}">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="text-sm text-red-600 dark:text-red-400 flex items-center mt-2">
                                <svg class="w-4 h-4 ltr:mr-1 rtl:ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="px-8 py-6 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                    <div class="flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 ltr:sm:space-x-4 rtl:sm:space-x-reverse">
                        <a href="{{ route('students.index') }}"
                           class="inline-flex items-center justify-center px-8 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-base font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-600 hover:bg-gray-50 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200 shadow-sm hover:shadow-md">
                            <svg class="w-5 h-5 ltr:mr-3 rtl:ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            {{ __('messages.cancel') }}
                        </a>
                        <button type="submit"
                                class="inline-flex items-center justify-center px-8 py-3 border border-transparent rounded-xl text-base font-medium text-white bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                            <svg class="w-5 h-5 ltr:mr-3 rtl:ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ __('messages.create_student') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript for Enhanced Form Experience -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('student-form');
    const submitButton = form.querySelector('button[type="submit"]');
    
    // Form submission loading state
    form.addEventListener('submit', function() {
        submitButton.disabled = true;
        submitButton.innerHTML = `
            <svg class="animate-spin ltr:-ml-1 rtl:-mr-1 ltr:mr-3 rtl:ml-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            {{ __('messages.creating_student') }}
        `;
    });

    // Auto-format phone number
    const phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.startsWith('212')) {
            value = value.substring(3);
        }
        if (value.length > 0) {
            value = '+212 ' + value;
        }
        e.target.value = value;
    });

    // Add focus effects to form fields
    const formFields = form.querySelectorAll('input, select, textarea');
    formFields.forEach(field => {
        field.addEventListener('focus', function() {
            this.parentElement.classList.add('ring-2', 'ring-primary-100', 'dark:ring-primary-900');
        });
        
        field.addEventListener('blur', function() {
            this.parentElement.classList.remove('ring-2', 'ring-primary-100', 'dark:ring-primary-900');
        });
    });

    // Real-time validation feedback
    formFields.forEach(field => {
        field.addEventListener('input', function() {
            if (this.checkValidity()) {
                this.classList.remove('border-red-500', 'ring-2', 'ring-red-200');
                this.classList.add('border-green-500', 'ring-2', 'ring-green-200');
            } else {
                this.classList.remove('border-green-500', 'ring-2', 'ring-green-200');
            }
        });
    });
});
</script>
@endsection
