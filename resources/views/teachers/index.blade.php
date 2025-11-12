@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center">
                    <svg class="w-8 h-8 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    {{ __('messages.teachers') }}
                </h1>
                <p class="text-gray-600 dark:text-gray-300 mt-2">Manage all teachers in your educational center</p>
            </div>
            <button onclick="openCreateModal()" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                {{ __('messages.add_new') }}
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Total Teachers -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 card-hover">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Teachers</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $teachers->count() ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Top Teacher by Students -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 card-hover">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"></path>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Top Teacher</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-white truncate">
                        {{ $topTeachers[0]->first_name ?? 'N/A' }} {{ $topTeachers[0]->last_name ?? '' }}
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $topTeachers[0]->student_count ?? 0 }} students</p>
                </div>
            </div>
        </div>

        <!-- Second Place Teacher -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 card-hover">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-gradient-to-r from-gray-500 to-gray-600 rounded-xl p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Second Place</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-white truncate">
                        {{ $topTeachers[1]->first_name ?? 'N/A' }} {{ $topTeachers[1]->last_name ?? '' }}
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $topTeachers[1]->student_count ?? 0 }} students</p>
                </div>
            </div>
        </div>

        <!-- Third Place Teacher -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 card-hover">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Third Place</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-white truncate">
                        {{ $topTeachers[2]->first_name ?? 'N/A' }} {{ $topTeachers[2]->last_name ?? '' }}
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $topTeachers[2]->student_count ?? 0 }} students</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Teachers Table -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">All Teachers</h3>
        </div>
        
        @if($teachers->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('messages.first_name') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('messages.last_name') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('messages.phone') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('messages.joined_date') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Percentage
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Subjects
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('messages.actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($teachers as $teacher)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $teacher->first_name }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ $teacher->last_name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ $teacher->phone }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ $teacher->joined_date->format('M d, Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ $teacher->monthly_percentage }}%
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($teacher->subjects as $subject)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                                {{ $subject->getName() }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex flex-wrap gap-1">
                                        <button onclick="openViewModal({{ $teacher->id }})" 
                                               class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 transition-colors duration-200">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            {{ __('messages.view') }}
                                        </button>
                                        <button onclick="openEditModal({{ $teacher->id }})" 
                                               class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 transition-colors duration-200">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            {{ __('messages.edit') }}
                                        </button>
                                        <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 transition-colors duration-200"
                                                    onclick="return confirm('Are you sure you want to delete this teacher?')">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                {{ __('messages.delete') }}
                                            </button>
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
                <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No teachers found</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-4">Get started by adding your first teacher.</p>
                <button onclick="openCreateModal()" 
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add First Teacher
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Create Teacher Modal -->
<div id="createModal" style="display: none; position: fixed; top: 0; inset-inline-start: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 9999; overflow-y: auto; backdrop-filter: blur(2px);">
    <div style="position: relative; top: 2%; margin: 0 auto; padding: 24px; border: 1px solid #e5e7eb; width: 95%; max-width: 700px; background-color: white; border-radius: 12px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);" class="dark:bg-gray-800 dark:border-gray-700">
        <div>
            <!-- Modal Header -->
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid #f3f4f6;" class="dark:border-gray-600">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #3b82f6, #1d4ed8); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <svg style="width: 20px; height: 20px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 style="font-size: 20px; font-weight: 600; color: #111827; margin: 0;" class="dark:text-white">{{ __('messages.add_new_teacher') ?? 'Add New Teacher' }}</h3>
                        <p style="font-size: 14px; color: #6b7280; margin: 4px 0 0 0;" class="dark:text-gray-300">{{ __('messages.add_teacher_description') ?? 'Fill in the details to add a new teacher' }}</p>
                    </div>
                </div>
                <button onclick="closeCreateModal()" 
                        style="color: #9ca3af; cursor: pointer; background: none; border: none; padding: 8px; border-radius: 6px; transition: all 0.2s;"
                        onmouseover="this.style.backgroundColor='#f3f4f6'; this.style.color='#374151';"
                        onmouseout="this.style.backgroundColor='transparent'; this.style.color='#9ca3af';">
                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Form -->
            <form method="POST" action="{{ route('teachers.store') }}" style="display: flex; flex-direction: column; gap: 20px;">
                @csrf
                
                <!-- Personal Information Section -->
                <div>
                    <h4 style="font-size: 16px; font-weight: 600; color: #111827; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;" class="dark:text-white">
                        <svg style="width: 16px; height: 16px; color: #3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ __('messages.personal_information') ?? 'Personal Information' }}
                    </h4>
                <div style="display: grid; grid-template-columns: 1fr; gap: 16px;">
                    <div style="display: grid; grid-template-columns: 1fr; gap: 16px;">
                        <!-- First Name -->
                        <div style="grid-column: span 1;">
                                <label for="first_name" style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 6px;" class="dark:text-gray-300">{{ __('messages.first_name') }}</label>
                                <input type="text" name="first_name" id="first_name" required
                                       style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; transition: all 0.2s; outline: none; @error('first_name') border-color: #ef4444; @enderror" class="dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400"
                                       value="{{ old('first_name') }}"
                                       placeholder="{{ __('messages.enter_first_name') ?? 'Enter first name' }}"
                                       onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)';"
                                       onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
                                @error('first_name')
                                    <p style="margin-top: 6px; font-size: 12px; color: #ef4444;">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Last Name -->
                            <div>
                                <label for="last_name" style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 6px;" class="dark:text-gray-300">{{ __('messages.last_name') }}</label>
                                <input type="text" name="last_name" id="last_name" required
                                       style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; transition: all 0.2s; outline: none; @error('last_name') border-color: #ef4444; @enderror" class="dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400"
                                       value="{{ old('last_name') }}"
                                       placeholder="{{ __('messages.enter_last_name') ?? 'Enter last name' }}"
                                       onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)';"
                                       onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
                                @error('last_name')
                                    <p style="margin-top: 6px; font-size: 12px; color: #ef4444;">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 6px;" class="dark:text-gray-300">{{ __('messages.phone') }}</label>
                            <input type="tel" name="phone" id="phone" required
                                   style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; transition: all 0.2s; outline: none; @error('phone') border-color: #ef4444; @enderror" class="dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400"
                                   value="{{ old('phone') }}"
                                   placeholder="{{ __('messages.enter_phone') ?? 'Enter phone number' }}"
                                   onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)';"
                                   onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
                            @error('phone')
                                <p style="margin-top: 6px; font-size: 12px; color: #ef4444;">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Professional Information Section -->
                <div>
                    <h4 style="font-size: 16px; font-weight: 600; color: #111827; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;" class="dark:text-white">
                        <svg style="width: 16px; height: 16px; color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        {{ __('messages.professional_information') ?? 'Professional Information' }}
                    </h4>
                    <div style="display: grid; grid-template-columns: 1fr; gap: 16px;">
                        <div style="display: grid; grid-template-columns: 1fr; gap: 16px;">
                            <!-- Monthly Percentage -->
                            <div>
                                <label for="monthly_percentage" style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 6px;" class="dark:text-gray-300">{{ __('messages.monthly_percentage') ?? 'Monthly Percentage (%)' }}</label>
                                <input type="number" name="monthly_percentage" id="monthly_percentage" required min="0" max="100" step="0.01"
                                       style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; transition: all 0.2s; outline: none; @error('monthly_percentage') border-color: #ef4444; @enderror" class="dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400"
                                       value="{{ old('monthly_percentage') }}"
                                       placeholder="0.00"
                                       onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)';"
                                       onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
                                @error('monthly_percentage')
                                    <p style="margin-top: 6px; font-size: 12px; color: #ef4444;">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Joined Date -->
                            <div>
                                <label for="joined_date" style="display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 6px;" class="dark:text-gray-300">{{ __('messages.joined_date') }}</label>
                                <input type="date" name="joined_date" id="joined_date" required
                                       style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; transition: all 0.2s; outline: none; @error('joined_date') border-color: #ef4444; @enderror" class="dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                       value="{{ old('joined_date') }}"
                                       onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)';"
                                       onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">
                                @error('joined_date')
                                    <p style="margin-top: 6px; font-size: 12px; color: #ef4444;">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Subjects Selection -->
                <div>
                    <h4 style="font-size: 16px; font-weight: 600; color: #111827; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;" class="dark:text-white">
                        <svg style="width: 16px; height: 16px; color: #8b5cf6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        {{ __('messages.subjects_teaching') ?? 'Subjects Teaching' }}
                    </h4>
                    <p style="font-size: 14px; color: #6b7280; margin-bottom: 16px;" class="dark:text-gray-300">{{ __('messages.select_subjects_description') ?? 'Select the subjects this teacher will teach:' }}</p>
                    <div style="display: grid; grid-template-columns: 1fr; gap: 12px; max-height: 200px; overflow-y: auto; padding: 8px;">
                        @foreach($subjects as $subject)
                           <div style="display: flex; align-items: center; padding: 8px; border-radius: 6px; transition: background-color 0.2s;"
                                onmouseover="this.style.backgroundColor='#f9fafb';"
                                onmouseout="this.style.backgroundColor='transparent';" class="dark:hover:bg-gray-700">
                                <input type="checkbox" name="subjects[]" value="{{ $subject->id }}" id="subject_create_{{ $subject->id }}"
                                       style="height: 16px; width: 16px; color: #3b82f6; border-color: #d1d5db; border-radius: 4px; margin-inline-end: 8px; cursor: pointer;"
                                       {{ in_array($subject->id, old('subjects', [])) ? 'checked' : '' }}>
                                <label for="subject_create_{{ $subject->id }}" style="font-size: 14px; color: #111827; cursor: pointer; flex: 1;" class="dark:text-white">
                                    {{ $subject->getName() }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('subjects')
                        <p style="margin-top: 8px; font-size: 12px; color: #ef4444;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div>
                    <h4 style="font-size: 16px; font-weight: 600; color: #111827; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;" class="dark:text-white">
                        <svg style="width: 16px; height: 16px; color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        {{ __('messages.notes') ?? 'Notes' }}
                    </h4>
                    <textarea name="notes" id="notes" rows="3"
                              style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; transition: all 0.2s; outline: none; resize: vertical; @error('notes') border-color: #ef4444; @enderror" class="dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400"
                              placeholder="{{ __('messages.enter_notes') ?? 'Any additional notes about the teacher...' }}"
                              onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59, 130, 246, 0.1)';"
                              onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p style="margin-top: 6px; font-size: 12px; color: #ef4444;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div style="display: flex; justify-content: flex-end; gap: 12px; padding-top: 20px; border-top: 1px solid #f3f4f6;" class="dark:border-gray-600">
                    <button type="button" onclick="closeCreateModal()"
                           style="display: inline-flex; align-items: center; padding: 10px 20px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; font-weight: 500; color: #374151; background-color: white; cursor: pointer; transition: all 0.2s;"
                           onmouseover="this.style.backgroundColor='#f9fafb'; this.style.borderColor='#9ca3af';"
                           onmouseout="this.style.backgroundColor='white'; this.style.borderColor='#d1d5db';" class="dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
                        <svg style="width: 16px; height: 16px; margin-inline-end: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        {{ __('messages.cancel') }}
                    </button>
                    <button type="submit" 
                            style="display: inline-flex; align-items: center; padding: 10px 20px; border: 1px solid transparent; border-radius: 8px; font-size: 14px; font-weight: 500; color: white; background: linear-gradient(135deg, #3b82f6, #1d4ed8); cursor: pointer; transition: all 0.2s; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05);"
                            onmouseover="this.style.background='linear-gradient(135deg, #2563eb, #1e40af)'; this.style.boxShadow='0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06)';"
                            onmouseout="this.style.background='linear-gradient(135deg, #3b82f6, #1d4ed8)'; this.style.boxShadow='0 1px 2px 0 rgba(0,0,0,0.05)';">
                        <svg style="width: 16px; height: 16px; margin-inline-end: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ __('messages.create_teacher') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Teacher Modal -->
<div id="editModal" style="display: none; position: fixed; top: 0; inset-inline-start: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 9999; overflow-y: auto; backdrop-filter: blur(2px);">
    <div style="position: relative; top: 2%; margin: 0 auto; padding: 24px; border: 1px solid #e5e7eb; width: 95%; max-width: 700px; background-color: white; border-radius: 12px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);" class="dark:bg-gray-800 dark:border-gray-700">
        <div>
            <!-- Modal Header -->
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid #f3f4f6;" class="dark:border-gray-600">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <svg style="width: 20px; height: 20px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 style="font-size: 20px; font-weight: 600; color: #111827; margin: 0;" class="dark:text-white">{{ __('messages.edit_teacher') ?? 'Edit Teacher' }}</h3>
                        <p style="font-size: 14px; color: #6b7280; margin: 4px 0 0 0;" class="dark:text-gray-300">{{ __('messages.edit_teacher_description') ?? 'Update the teacher information' }}</p>
                    </div>
                </div>
                <button onclick="closeEditModal()" 
                        style="color: #9ca3af; cursor: pointer; background: none; border: none; padding: 8px; border-radius: 6px; transition: all 0.2s;"
                        onmouseover="this.style.backgroundColor='#f3f4f6'; this.style.color='#374151';"
                        onmouseout="this.style.backgroundColor='transparent'; this.style.color='#9ca3af';">
                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Form will be loaded dynamically via JavaScript -->
            <div id="editModalContent">
                <div style="text-align: center; padding: 40px;">
                    <div style="width: 48px; height: 48px; border: 3px solid #e5e7eb; border-top: 3px solid #3b82f6; border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto 16px;" class="dark:border-gray-600"></div>
                    <p style="color: #6b7280; font-size: 14px;" class="dark:text-gray-300">Loading teacher information...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Teacher-specific JavaScript -->
@push('scripts')
<script type="module">
    import { TeacherManager } from '/resources/js/modules/teachers.js';
    TeacherManager.initAll();
</script>
@endpush
@endsection
