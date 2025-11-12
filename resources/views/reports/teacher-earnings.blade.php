@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                    <svg class="w-8 h-8 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Teacher Earnings Report
                </h1>
                <p class="text-gray-600 mt-2">Teacher earnings breakdown for {{ DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('reports.subject-payments', ['month' => $month, 'year' => $year]) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200">
                    Subject Payments
                </a>
                <a href="{{ route('payments.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200">
                    Back to Payments
                </a>
            </div>
        </div>
    </div>

    <!-- Month/Year Filter -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form method="GET" class="flex items-end space-x-4">
            <div>
                <label for="month" class="block text-sm font-medium text-gray-700 mb-2">Month</label>
                <select name="month" id="month" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div>
                <label for="year" class="block text-sm font-medium text-gray-700 mb-2">Year</label>
                <select name="year" id="year" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                    @for($i = date('Y') - 1; $i <= date('Y') + 1; $i++)
                        <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Filter
            </button>
        </form>
    </div>

    <!-- Teacher Earnings Table -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Teacher Earnings Summary</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Earnings breakdown by subject for each teacher</p>
        </div>
        
        @if(count($teacherEarnings) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left rtl:text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Teacher
                            </th>
                            <th class="px-6 py-3 text-left rtl:text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Monthly Percentage
                            </th>
                            <th class="px-6 py-3 text-left rtl:text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Classes & Revenue Breakdown
                            </th>
                            <th class="px-6 py-3 text-left rtl:text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Total Earnings
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($teacherEarnings as $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $item['teacher']->full_name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ number_format($item['teacher']->monthly_percentage, 2) }}%
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if(count($item['earnings_by_subject']) > 0)
                                        <div class="space-y-4">
                                            @php
                                                $totalClassRevenue = 0;
                                            @endphp
                                            @foreach($item['earnings_by_subject'] as $earning)
                                                @if(isset($earning['classes']) && count($earning['classes']) > 0)
                                                    <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                                                        <div class="flex items-center justify-between text-sm mb-3">
                                                            <span class="font-semibold text-gray-900 dark:text-white">{{ $earning['subject'] }}</span>
                                                            <div class="text-right">
                                                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $earning['student_count'] }} students total</div>
                                                                <div class="text-gray-600 dark:text-gray-400 font-medium">MAD {{ number_format($earning['total_payments'], 2) }}</div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="border-t border-gray-100 dark:border-gray-600 pt-3">
                                                            <div class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">CLASSES:</div>
                                                            @foreach($earning['classes'] as $class)
                                                                @php
                                                                    $totalClassRevenue += $class['payments'];
                                                                @endphp
                                                                <div class="flex items-center justify-between text-sm mb-2 p-2 bg-gray-50 dark:bg-gray-700 rounded">
                                                                    <div>
                                                                        <span class="font-medium text-gray-900 dark:text-white">{{ $class['class_name'] }}</span>
                                                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $class['student_count'] }} students</div>
                                                                    </div>
                                                                    <div class="text-right">
                                                                        <div class="text-gray-600 dark:text-gray-400">MAD {{ number_format($class['payments'], 2) }}</div>
                                                                        <div class="text-xs text-green-600 dark:text-green-400">
                                                                            Teacher: MAD {{ number_format($class['earnings'], 2) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                            
                                            <!-- Total Summary -->
                                            @if($totalClassRevenue > 0)
                                                <div class="border-t border-gray-200 dark:border-gray-600 pt-4 mt-4">
                                                    <div class="flex items-center justify-between text-sm font-semibold">
                                                        <span class="text-gray-900 dark:text-white">Total Class Revenue:</span>
                                                        <span class="text-blue-600 dark:text-blue-400">MAD {{ number_format($totalClassRevenue, 2) }}</span>
                                                    </div>
                                                    <div class="flex items-center justify-between text-sm mt-1">
                                                        <span class="text-gray-600 dark:text-gray-400">Teacher Percentage ({{ number_format($item['teacher']->monthly_percentage, 2) }}%):</span>
                                                        <span class="text-green-600 dark:text-green-400 font-semibold">MAD {{ number_format($item['total_earnings'], 2) }}</span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-500 dark:text-gray-400">No classes assigned or no students in classes</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-lg font-bold text-green-600 dark:text-green-400">
                                        MAD {{ number_format($item['total_earnings']) }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-white" colspan="3">
                                Total Earnings
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600 dark:text-green-400">
                                MAD {{ number_format(array_sum(array_column($teacherEarnings, 'total_earnings')), 2) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No earnings found</h3>
                <p class="text-gray-500 dark:text-gray-400">No earnings recorded for the selected period.</p>
            </div>
        @endif
    </div>
</div>
@endsection