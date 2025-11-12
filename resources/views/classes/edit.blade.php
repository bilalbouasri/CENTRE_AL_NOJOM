@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center">
                    <svg class="w-8 h-8 mr-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    {{ __('messages.classes') }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Edit class information</p>
            </div>
            <a href="{{ route('classes.index') }}"
               class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Classes
            </a>
        </div>
    </div>

    <!-- Form Section -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
        <form method="POST" action="{{ route('classes.update', $class) }}">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 gap-6">
                <!-- Class Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Class Name *
                    </label>
                    <input type="text" name="name" id="name" required
                           value="{{ old('name', $class->name) }}"
                           class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm transition-colors duration-200 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                           placeholder="Enter class name (e.g., Math Grade 10, Physics Advanced)">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Teacher Selection -->
                <div>
                    <label for="teacher_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('messages.teacher') }} *
                    </label>
                    <select name="teacher_id" id="teacher_id" required
                            class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm transition-colors duration-200 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">Select a teacher</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ old('teacher_id', $class->teacher_id) == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->first_name }} {{ $teacher->last_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('teacher_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Subject Selection -->
                <div>
                    <label for="subject_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('messages.subject') }} *
                    </label>
                    <select name="subject_id" id="subject_id" required
                            class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm transition-colors duration-200 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">Select a subject</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id', $class->subject_id) == $subject->id ? 'selected' : '' }}>
                                {{ $subject->getName() }}
                            </option>
                        @endforeach
                    </select>
                    @error('subject_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                <!-- Weekly Schedule -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Weekly Schedule
                    </label>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">Add the weekly schedule for this class (2-3 sessions per week):</p>
                    
                    <div id="schedules-container" class="space-y-4">
                        @foreach(old('schedules', $class->schedules) as $index => $schedule)
                            <div class="schedule-item border border-gray-200 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-700">
                                <div class="flex justify-between items-center mb-3">
                                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Session {{ $index + 1 }}</h4>
                                    <button type="button" class="remove-schedule text-red-600 hover:text-red-800 transition-colors duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Day</label>
                                        <select name="schedules[{{ $index }}][day_of_week]" required
                                                class="block w-full px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-sm focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 bg-white dark:bg-gray-600 text-gray-900 dark:text-white">
                                            <option value="">Select day</option>
                                            <option value="monday" {{ ($schedule['day_of_week'] ?? '') === 'monday' ? 'selected' : '' }}>Monday</option>
                                            <option value="tuesday" {{ ($schedule['day_of_week'] ?? '') === 'tuesday' ? 'selected' : '' }}>Tuesday</option>
                                            <option value="wednesday" {{ ($schedule['day_of_week'] ?? '') === 'wednesday' ? 'selected' : '' }}>Wednesday</option>
                                            <option value="thursday" {{ ($schedule['day_of_week'] ?? '') === 'thursday' ? 'selected' : '' }}>Thursday</option>
                                            <option value="friday" {{ ($schedule['day_of_week'] ?? '') === 'friday' ? 'selected' : '' }}>Friday</option>
                                            <option value="saturday" {{ ($schedule['day_of_week'] ?? '') === 'saturday' ? 'selected' : '' }}>Saturday</option>
                                            <option value="sunday" {{ ($schedule['day_of_week'] ?? '') === 'sunday' ? 'selected' : '' }}>Sunday</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Start Time</label>
                                        <input type="time" name="schedules[{{ $index }}][start_time]" required
                                               value="{{ $schedule['start_time'] ?? '' }}"
                                               class="block w-full px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-sm focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 bg-white dark:bg-gray-600 text-gray-900 dark:text-white">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">End Time</label>
                                        <input type="time" name="schedules[{{ $index }}][end_time]" required
                                               value="{{ $schedule['end_time'] ?? '' }}"
                                               class="block w-full px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-sm focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 bg-white dark:bg-gray-600 text-gray-900 dark:text-white">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Duration (hours)</label>
                                        <select name="schedules[{{ $index }}][duration_hours]" required
                                                class="block w-full px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-sm focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 bg-white dark:bg-gray-600 text-gray-900 dark:text-white">
                                            <option value="">Select duration</option>
                                            <option value="1.0" {{ ($schedule['duration_hours'] ?? '') === '1.0' ? 'selected' : '' }}>1 hour</option>
                                            <option value="1.5" {{ ($schedule['duration_hours'] ?? '') === '1.5' ? 'selected' : '' }}>1.5 hours</option>
                                            <option value="2.0" {{ ($schedule['duration_hours'] ?? '') === '2.0' ? 'selected' : '' }}>2 hours</option>
                                            <option value="2.5" {{ ($schedule['duration_hours'] ?? '') === '2.5' ? 'selected' : '' }}>2.5 hours</option>
                                            <option value="3.0" {{ ($schedule['duration_hours'] ?? '') === '3.0' ? 'selected' : '' }}>3 hours</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <button type="button" id="add-schedule"
                            class="mt-3 inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Schedule
                    </button>
                </div>

                <!-- Students Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('messages.students') }}
                    </label>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">Select students who will attend this class:</p>
                    <div class="space-y-2 max-h-60 overflow-y-auto border border-gray-200 dark:border-gray-600 rounded-md p-4 bg-white dark:bg-gray-700">
                        @foreach($students as $student)
                            <div class="flex items-center">
                                <input type="checkbox" name="students[]" value="{{ $student->id }}" id="student_{{ $student->id }}"
                                       class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded"
                                       {{ in_array($student->id, old('students', $class->students->pluck('id')->toArray())) ? 'checked' : '' }}>
                                <label for="student_{{ $student->id }}" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                    {{ $student->first_name }} {{ $student->last_name }} ({{ $student->grade }})
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('students')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-3">
                <a href="{{ route('classes.index') }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    {{ __('messages.cancel') }}
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Update Class
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const schedulesContainer = document.getElementById('schedules-container');
    const addScheduleBtn = document.getElementById('add-schedule');
    let scheduleCount = {{ count(old('schedules', $class->schedules)) }};

    // Add schedule function
    function addSchedule(data = {}) {
        const index = scheduleCount++;
        const scheduleHtml = `
            <div class="schedule-item border border-gray-200 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-700">
                <div class="flex justify-between items-center mb-3">
                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Session ${index + 1}</h4>
                    <button type="button" class="remove-schedule text-red-600 hover:text-red-800 transition-colors duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Day</label>
                        <select name="schedules[${index}][day_of_week]" required
                                class="block w-full px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-sm focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 bg-white dark:bg-gray-600 text-gray-900 dark:text-white">
                            <option value="">Select day</option>
                            <option value="monday" ${data.day_of_week === 'monday' ? 'selected' : ''}>Monday</option>
                            <option value="tuesday" ${data.day_of_week === 'tuesday' ? 'selected' : ''}>Tuesday</option>
                            <option value="wednesday" ${data.day_of_week === 'wednesday' ? 'selected' : ''}>Wednesday</option>
                            <option value="thursday" ${data.day_of_week === 'thursday' ? 'selected' : ''}>Thursday</option>
                            <option value="friday" ${data.day_of_week === 'friday' ? 'selected' : ''}>Friday</option>
                            <option value="saturday" ${data.day_of_week === 'saturday' ? 'selected' : ''}>Saturday</option>
                            <option value="sunday" ${data.day_of_week === 'sunday' ? 'selected' : ''}>Sunday</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Start Time</label>
                        <input type="time" name="schedules[${index}][start_time]" required
                               value="${data.start_time || ''}"
                               class="block w-full px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-sm focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 bg-white dark:bg-gray-600 text-gray-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">End Time</label>
                        <input type="time" name="schedules[${index}][end_time]" required
                               value="${data.end_time || ''}"
                               class="block w-full px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-sm focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 bg-white dark:bg-gray-600 text-gray-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Duration (hours)</label>
                        <select name="schedules[${index}][duration_hours]" required
                                class="block w-full px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-sm focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 bg-white dark:bg-gray-600 text-gray-900 dark:text-white">
                            <option value="">Select duration</option>
                            <option value="1.0" ${data.duration_hours === '1.0' ? 'selected' : ''}>1 hour</option>
                            <option value="1.5" ${data.duration_hours === '1.5' ? 'selected' : ''}>1.5 hours</option>
                            <option value="2.0" ${data.duration_hours === '2.0' ? 'selected' : ''}>2 hours</option>
                            <option value="2.5" ${data.duration_hours === '2.5' ? 'selected' : ''}>2.5 hours</option>
                            <option value="3.0" ${data.duration_hours === '3.0' ? 'selected' : ''}>3 hours</option>
                        </select>
                    </div>
                </div>
            </div>
        `;
        
        const scheduleElement = document.createElement('div');
        scheduleElement.innerHTML = scheduleHtml;
        schedulesContainer.appendChild(scheduleElement);

        // Add remove functionality
        const removeBtn = scheduleElement.querySelector('.remove-schedule');
        removeBtn.addEventListener('click', function() {
            scheduleElement.remove();
            updateScheduleNumbers();
        });

        // Auto-calculate duration when times change
        const startTimeInput = scheduleElement.querySelector('input[name$="[start_time]"]');
        const endTimeInput = scheduleElement.querySelector('input[name$="[end_time]"]');
        const durationSelect = scheduleElement.querySelector('select[name$="[duration_hours]"]');

        function calculateDuration() {
            if (startTimeInput.value && endTimeInput.value) {
                const start = new Date(`2000-01-01T${startTimeInput.value}`);
                const end = new Date(`2000-01-01T${endTimeInput.value}`);
                const diffHours = (end - start) / (1000 * 60 * 60);
                
                if (diffHours > 0) {
                    // Find closest duration option
                    const options = [1.0, 1.5, 2.0, 2.5, 3.0];
                    const closest = options.reduce((prev, curr) => {
                        return Math.abs(curr - diffHours) < Math.abs(prev - diffHours) ? curr : prev;
                    });
                    
                    durationSelect.value = closest.toString();
                }
            }
        }

        startTimeInput.addEventListener('change', calculateDuration);
        endTimeInput.addEventListener('change', calculateDuration);
    }

    // Update schedule numbers after removal
    function updateScheduleNumbers() {
        const scheduleItems = schedulesContainer.querySelectorAll('.schedule-item');
        scheduleItems.forEach((item, index) => {
            const title = item.querySelector('h4');
            title.textContent = `Session ${index + 1}`;
        });
    }

    // Add remove functionality to existing schedules
    document.querySelectorAll('.remove-schedule').forEach(btn => {
        btn.addEventListener('click', function() {
            this.closest('.schedule-item').remove();
            updateScheduleNumbers();
        });
    });

    // Add schedule button event
    addScheduleBtn.addEventListener('click', function() {
        addSchedule();
        
        // Limit to 3 schedules
        const scheduleCount = schedulesContainer.querySelectorAll('.schedule-item').length;
        if (scheduleCount >= 3) {
            addScheduleBtn.disabled = true;
            addScheduleBtn.classList.add('opacity-50', 'cursor-not-allowed');
        }
    });
});
</script>
@endpush
@endsection
