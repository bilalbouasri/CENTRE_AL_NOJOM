@extends('layouts.app')

@section('content')
    <div class="space-y-4">
        <!-- Welcome Section - Compact -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <h1 class="text-xl font-bold text-gray-900 dark:text-white">
                        {{ __('messages.welcome') }}, {{ Auth::user()->name }}!
                    </h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        {{ __('Manage your educational center efficiently') }}
                    </p>
                </div>
                <div
                    class="w-12 h-12 bg-gradient-to-r from-primary-500 to-primary-600 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Stats Cards - Compact Grid -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
            <!-- Total Students -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-3 card-hover">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-2">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="ltr:ml-3 rtl:mr-3 flex-1">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">
                            {{ __('messages.total_students') }}
                        </p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">
                            {{ $totalStudents ?? 0 }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Total Teachers -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-3 card-hover">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-2">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div class="ltr:ml-3 rtl:mr-3 flex-1">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">
                            {{ __('messages.total_teachers') }}
                        </p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">
                            {{ $totalTeachers ?? 0 }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Total Classes -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-3 card-hover">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-2">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <div class="ltr:ml-3 rtl:mr-3 flex-1">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">
                            {{ __('messages.total_classes') }}
                        </p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">
                            {{ $totalClasses ?? 0 }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Total Subjects -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-3 card-hover">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg p-2">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div class="ltr:ml-3 rtl:mr-3 flex-1">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">
                            {{ __('messages.total_subjects') }}
                        </p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">
                            {{ $totalSubjects ?? 0 }}
                        </p>
                    </div>


                </div>
            </div>
            <!-- Monthly Revenue -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-3 card-hover">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-gradient-to-r from-red-500 to-red-600 rounded-lg p-2">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                        </svg>
                    </div>
                    <div class="ltr:ml-3 rtl:mr-3 flex-1">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">
                            {{ __('messages.monthly_revenue') }}
                        </p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">
                            MAD {{ number_format($monthlyRevenue ?? 0) }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ __('messages.this_month') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <!-- Quick Actions - Compact -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm lg:col-span-1">
                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-4 h-4 ltr:mr-2 rtl:ml-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        {{ __('messages.quick_actions') }}
                    </h3>
                </div>
                <div class="p-3">
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('students.index') }}"
                            class="bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg p-3 text-center transition-colors duration-200">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mx-auto mb-1" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span
                                class="text-xs font-medium text-blue-900 dark:text-blue-300">{{ __('messages.students') }}</span>
                        </a>

                        <a href="{{ route('teachers.index') }}"
                            class="bg-green-50 dark:bg-green-900/20 hover:bg-green-100 dark:hover:bg-green-900/30 rounded-lg p-3 text-center transition-colors duration-200">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400 mx-auto mb-1" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span
                                class="text-xs font-medium text-green-900 dark:text-green-300">{{ __('messages.teachers') }}</span>
                        </a>

                        <a href="{{ route('classes.index') }}"
                            class="bg-purple-50 dark:bg-purple-900/20 hover:bg-purple-100 dark:hover:bg-purple-900/30 rounded-lg p-3 text-center transition-colors duration-200">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400 mx-auto mb-1" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <span
                                class="text-xs font-medium text-purple-900 dark:text-purple-300">{{ __('messages.classes') }}</span>
                        </a>

                        <a href="{{ route('payments.index') }}"
                            class="bg-orange-50 dark:bg-orange-900/20 hover:bg-orange-100 dark:hover:bg-orange-900/30 rounded-lg p-3 text-center transition-colors duration-200">
                            <svg class="w-5 h-5 text-orange-600 dark:text-orange-400 mx-auto mb-1" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                            </svg>
                            <span
                                class="text-xs font-medium text-orange-900 dark:text-orange-300">{{ __('messages.payments') }}</span>
                        </a>

                        <a href="{{ route('subjects.index') }}"
                            class="bg-indigo-50 dark:bg-indigo-900/20 hover:bg-indigo-100 dark:hover:bg-indigo-900/30 rounded-lg p-3 text-center transition-colors duration-200">
                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400 mx-auto mb-1" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span
                                class="text-xs font-medium text-indigo-900 dark:text-indigo-300">{{ __('messages.subjects') }}</span>
                        </a>

                        <a href="{{ route('payments.create-bulk') }}"
                           class="bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-lg p-3 text-center transition-colors duration-200">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400 mx-auto mb-1" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                            </svg>
                            <span
                                class="text-xs font-medium text-red-900 dark:text-red-300">{{ __('messages.bulk_payment') }}</span>
                        </a>

                        <!-- User Management -->
                        <a href="{{ route('users.index') }}"
                           class="bg-purple-50 dark:bg-purple-900/20 hover:bg-purple-100 dark:hover:bg-purple-900/30 rounded-lg p-3 text-center transition-colors duration-200">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400 mx-auto mb-1" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                            <span
                                class="text-xs font-medium text-purple-900 dark:text-purple-300">Users</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Activity - Compact -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm lg:col-span-2">
                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-4 h-4 ltr:mr-2 rtl:ml-2 text-green-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                        </svg>
                        {{ __('messages.recent_activity') }}
                    </h3>
                </div>
                <div class="p-3">
                    @if (isset($recentPayments) && $recentPayments->count() > 0)
                        <div class="space-y-2">
                            @foreach ($recentPayments as $payment)
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div class="flex items-center ltr:space-x-3 rtl:space-x-reverse">
                                        <div
                                            class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-gray-900 dark:text-white">
                                                {{ $payment->student->first_name ?? 'Unknown' }}
                                                {{ $payment->student->last_name ?? 'Student' }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $payment->month_name ?? 'Unknown Month' }}
                                                {{ $payment->payment_year ?? '' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="ltr:text-right rtl:text-left">
                                        <p class="text-xs font-bold text-green-600 dark:text-green-400">
                                            MAD {{ number_format($payment->amount ?? 0, 2) }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $payment->payment_date->format('M d') ?? 'Unknown' }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-6">
                            <svg class="w-8 h-8 text-gray-400 dark:text-gray-500 mx-auto" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400 text-xs mt-2">{{ __('messages.no_payments_found') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
