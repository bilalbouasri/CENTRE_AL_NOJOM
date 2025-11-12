@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('messages.record_payment') }}</h1>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">{{ __('messages.record_monthly_payment_for', ['name' => $student->full_name]) }}</p>
                </div>
                <a href="{{ route('students.show', $student->id) }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                    <svg class="w-5 h-5 ltr:mr-2 rtl:ml-2 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('messages.back_to_student') }}
                </a>
            </div>
        </div>

        <!-- Student Information Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('messages.student_information') }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">{{ __('messages.full_name') }}</label>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $student->full_name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">{{ __('messages.grade') }}</label>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $student->grade }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">{{ __('messages.phone') }}</label>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $student->phone }}</p>
                </div>
            </div>
        </div>

        <!-- Payment Form -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <form method="POST" action="{{ route('payments.store-bulk') }}" id="paymentForm">
                @csrf
                <input type="hidden" name="student_id" value="{{ $student->id }}">
                
                <div class="p-6 space-y-8">
                    <!-- Subjects Selection -->
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ __('messages.select_subjects') }}</h3>
                            <div class="text-sm text-gray-500 dark:text-gray-400" id="selectedCount">{{ __('messages.subjects_selected', ['count' => 0]) }}</div>
                        </div>

                        <!-- Legend -->
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-6">
                            <div class="flex flex-wrap gap-6 text-sm">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-green-100 dark:bg-green-900 border-2 border-green-400 dark:border-green-600 rounded ltr:mr-2 rtl:ml-2"></div>
                                    <span class="text-gray-700 dark:text-gray-300">{{ __('messages.already_paid_this_month') }}</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-blue-100 dark:bg-blue-900 border-2 border-blue-400 dark:border-blue-600 rounded ltr:mr-2 rtl:ml-2"></div>
                                    <span class="text-gray-700 dark:text-gray-300">{{ __('messages.enrolled_not_paid') }}</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-gray-100 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 rounded ltr:mr-2 rtl:ml-2"></div>
                                    <span class="text-gray-700 dark:text-gray-300">{{ __('messages.not_enrolled') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Subjects Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($allSubjects as $subject)
                                @php
                                    $isEnrolled = $student->subjects->contains('id', $subject->id);
                                    $isPaid = $student->monthlyPayments
                                        ->where('subject_id', $subject->id)
                                        ->where('payment_month', $currentMonth)
                                        ->where('payment_year', $currentYear)
                                        ->count() > 0;
                                    
                                    $statusClass = $isPaid ? 'border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/20' :
                                                  ($isEnrolled ? 'border-blue-200 dark:border-blue-800 bg-blue-50 dark:bg-blue-900/20' : 'border-gray-200 dark:border-gray-600');
                                    $statusText = $isPaid ? 'text-green-700 dark:text-green-300' :
                                                 ($isEnrolled ? 'text-blue-700 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300');
                                @endphp
                                
                                <div class="subject-card {{ $statusClass }} border-2 rounded-lg p-4 transition-all duration-200 hover:shadow-md">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <input type="checkbox"
                                                   name="subjects[]"
                                                   value="{{ $subject->id }}"
                                                   id="subject_{{ $subject->id }}"
                                                   class="h-5 w-5 text-primary-600 dark:text-primary-500 focus:ring-primary-500 border-gray-300 dark:border-gray-600 rounded subject-checkbox"
                                                   data-fee="{{ $subject->fee_amount }}"
                                                   {{ $isPaid ? 'checked' : '' }}>
                                            <div>
                                                <label for="subject_{{ $subject->id }}" class="block text-sm font-medium text-gray-900 dark:text-white cursor-pointer">
                                                    {{ $subject->getName() }}
                                                </label>
                                                <span class="text-xs {{ $statusText }} font-medium">
                                                    @if($isPaid)
                                                        ✓ {{ __('messages.already_paid_this_month') }}
                                                    @elseif($isEnrolled)
                                                        {{ __('messages.enrolled_not_paid') }}
                                                    @else
                                                        {{ __('messages.not_enrolled') }}
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ltr:text-right rtl:text-left">
                                            <div class="text-lg font-bold text-gray-900 dark:text-white">
                                                MAD {{ number_format($subject->fee_amount, 2) }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ __('messages.per_month') }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Payment Details -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-8">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">{{ __('messages.payment_details') }}</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Total Amount -->
                            <div>
                                <label for="total_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('messages.total_amount') }} (MAD) *
                                </label>
                                <div class="relative rounded-lg shadow-sm">
                                    <div class="absolute inset-y-0 ltr:left-0 rtl:right-0 ltr:pl-3 rtl:pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 dark:text-gray-400 sm:text-sm font-medium">MAD</span>
                                    </div>
                                    <input type="number" name="total_amount" id="total_amount" required 
                                           class="block w-full ltr:pl-12 rtl:pr-12 ltr:pr-3 rtl:pl-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-lg font-medium transition-colors duration-200 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                           placeholder="0.00">
                                </div>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400" id="amountPerSubject">
                                    {{ __('messages.amount_will_be_calculated') }}
                                </p>
                            </div>

                            <!-- Payment Date -->
                            <div>
                                <label for="payment_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('messages.payment_date') }} *
                                </label>
                                <input type="date" name="payment_date" id="payment_date" required
                                       value="{{ date('Y-m-d') }}"
                                       class="block w-full px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm transition-colors duration-200 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            </div>
                        </div>

                        <!-- Month and Year Selection -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                            <div>
                                <label for="payment_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('messages.payment_method') }} *
                                </label>
                                <select name="payment_method" id="payment_method" required
                                        class="block w-full px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm transition-colors duration-200 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                    <option value="cash">{{ __('messages.cash') }}</option>
                                    <option value="card">{{ __('messages.card') }}</option>
                                    <option value="bank_transfer">{{ __('messages.bank_transfer') }}</option>
                                </select>
                            </div>

                            <div>
                                <label for="payment_month" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('messages.payment_month') }} *
                                </label>
                                <select name="payment_month" id="payment_month" required
                                        class="block w-full px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm transition-colors duration-200 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                    @for($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ $i == $currentMonth ? 'selected' : '' }}>
                                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div>
                                <label for="payment_year" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('messages.payment_year') }} *
                                </label>
                                <select name="payment_year" id="payment_year" required
                                        class="block w-full px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm transition-colors duration-200 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                    @for($i = date('Y') - 1; $i <= date('Y') + 1; $i++)
                                        <option value="{{ $i }}" {{ $i == $currentYear ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mt-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('messages.notes') }} ({{ __('messages.optional') }})
                            </label>
                            <textarea name="notes" id="notes" rows="3"
                                      class="block w-full px-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm transition-colors duration-200 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                      placeholder="{{ __('messages.add_notes_about_payment') }}"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="bg-gray-50 dark:bg-gray-800 px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500 dark:text-gray-400" id="summaryText">
                            {{ __('messages.ready_to_record_payment') }}
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('students.show', $student->id) }}"
                               class="inline-flex items-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                                {{ __('messages.cancel') }}
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                                <svg class="w-5 h-5 ltr:mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ __('messages.record_payment') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const subjectCheckboxes = document.querySelectorAll('.subject-checkbox');
        const totalAmountInput = document.getElementById('total_amount');
        const amountPerSubject = document.getElementById('amountPerSubject');
        const selectedCount = document.getElementById('selectedCount');
        const summaryText = document.getElementById('summaryText');
        
        // Translation strings for JavaScript
        const translations = {
            subjects_selected: (count) => `{{ __('messages.subjects_selected', ['count' => ':count']) }}`.replace(':count', count),
            recording_payment_for_subjects: (count) => `{{ __('messages.recording_payment_for_subjects', ['count' => ':count']) }}`.replace(':count', count),
            subjects_already_paid: (count) => `{{ __('messages.subjects_already_paid', ['count' => ':count']) }}`.replace(':count', count),
            ready_to_record_payment: `{{ __('messages.ready_to_record_payment') }}`,
            amount_will_be_calculated: `{{ __('messages.amount_will_be_calculated') }}`,
            new_subjects_will_be_enrolled: (count) => `{{ __('messages.new_subjects_will_be_enrolled', ['count' => ':count']) }}`.replace(':count', count),
            already_paid: (count) => `{{ __('messages.already_paid', ['count' => ':count']) }}`.replace(':count', count),
            no_additional_payment_required: `{{ __('messages.no_additional_payment_required') }}`,
        };

        function calculateTotal() {
            let total = 0;
            let selectedCountValue = 0;
            let paidCount = 0;
            let enrolledCount = 0;
            let newCount = 0;
            
            subjectCheckboxes.forEach(checkbox => {
                const subjectCard = checkbox.closest('.subject-card');
                const isPaid = subjectCard.classList.contains('bg-green-50') || subjectCard.classList.contains('dark:bg-green-900/20');
                const isEnrolled = subjectCard.classList.contains('bg-blue-50') || subjectCard.classList.contains('dark:bg-blue-900/20');
                
                if (checkbox.checked) {
                    if (isPaid) {
                        paidCount++;
                    } else if (isEnrolled) {
                        total += parseFloat(checkbox.dataset.fee) || 0;
                        selectedCountValue++;
                        enrolledCount++;
                    } else {
                        total += parseFloat(checkbox.dataset.fee) || 0;
                        selectedCountValue++;
                        newCount++;
                    }
                }
            });
            
            totalAmountInput.value = total.toFixed(2);
            
            // Update selected count
            selectedCount.textContent = translations.subjects_selected(selectedCountValue + paidCount);
            
            // Update amount per subject text
            if (selectedCountValue > 0) {
                const amountPer = total / selectedCountValue;
                let message = `{{ __('messages.mad') }} ${amountPer.toFixed(2)} {{ __('messages.per_subject') }}`;
                if (newCount > 0) {
                    message += ` • ${translations.new_subjects_will_be_enrolled(newCount)}`;
                }
                if (paidCount > 0) {
                    message += ` • ${translations.already_paid(paidCount)}`;
                }
                amountPerSubject.textContent = message;
            } else if (paidCount > 0) {
                amountPerSubject.textContent = `${translations.subjects_already_paid(paidCount)} (${translations.no_additional_payment_required})`;
            } else {
                amountPerSubject.textContent = translations.amount_will_be_calculated;
            }
            
            // Update summary text
            if (selectedCountValue > 0) {
                summaryText.textContent = translations.recording_payment_for_subjects(selectedCountValue);
            } else if (paidCount > 0) {
                summaryText.textContent = translations.subjects_already_paid(paidCount);
            } else {
                summaryText.textContent = translations.ready_to_record_payment;
            }
        }

        subjectCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', calculateTotal);
        });

        // Add hover effects to subject cards
        subjectCheckboxes.forEach(checkbox => {
            const card = checkbox.closest('.subject-card');
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    card.classList.add('ring-2', 'ring-primary-500');
                } else {
                    card.classList.remove('ring-2', 'ring-primary-500');
                }
            });
        });

        // Initial calculation
        calculateTotal();
    });
</script>

<style>
    .subject-card {
        transition: all 0.2s ease-in-out;
    }
    
    .subject-card:hover {
        transform: translateY(-1px);
    }
    
    input:focus, select:focus, textarea:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* RTL specific adjustments */
    [dir="rtl"] .ltr\:mr-2 {
        margin-right: 0;
        margin-left: 0.5rem;
    }
    
    [dir="rtl"] .ltr\:ml-2 {
        margin-left: 0;
        margin-right: 0.5rem;
    }
    
    [dir="rtl"] .ltr\:text-right {
        text-align: left;
    }
    
    [dir="rtl"] .ltr\:pl-12 {
        padding-left: 0.75rem;
        padding-right: 3rem;
    }
    
    [dir="rtl"] .ltr\:left-0 {
        left: auto;
        right: 0;
    }

    /* Dark mode focus states */
    .dark input:focus,
    .dark select:focus,
    .dark textarea:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }

    /* Responsive improvements */
    @media (max-width: 768px) {
        .subject-card {
            padding: 1rem;
        }
        
        .grid-cols-1 {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection