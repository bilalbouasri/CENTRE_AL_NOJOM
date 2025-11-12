<form method="POST" action="{{ route('teachers.update', $teacher) }}" style="display: flex; flex-direction: column; gap: 20px;">
    @csrf
    @method('PUT')
    
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
                           value="{{ old('first_name', $teacher->first_name) }}"
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
                           value="{{ old('last_name', $teacher->last_name) }}"
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
                       value="{{ old('phone', $teacher->phone) }}"
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
                           value="{{ old('monthly_percentage', $teacher->monthly_percentage) }}"
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
                           value="{{ old('joined_date', $teacher->joined_date->format('Y-m-d')) }}"
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
                    <input type="checkbox" name="subjects[]" value="{{ $subject->id }}" id="subject_edit_{{ $subject->id }}"
                           style="height: 16px; width: 16px; color: #3b82f6; border-color: #d1d5db; border-radius: 4px; margin-inline-end: 8px; cursor: pointer;"
                           {{ in_array($subject->id, old('subjects', $teacher->subjects->pluck('id')->toArray())) ? 'checked' : '' }}>
                    <label for="subject_edit_{{ $subject->id }}" style="font-size: 14px; color: #111827; cursor: pointer; flex: 1;" class="dark:text-white">
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
                  onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none';">{{ old('notes', $teacher->notes) }}</textarea>
        @error('notes')
            <p style="margin-top: 6px; font-size: 12px; color: #ef4444;">{{ $message }}</p>
        @enderror
    </div>

    <!-- Submit Buttons -->
    <div style="display: flex; justify-content: flex-end; gap: 12px; padding-top: 20px; border-top: 1px solid #f3f4f6;" class="dark:border-gray-600">
        <button type="button" onclick="closeEditModal()" 
               style="display: inline-flex; align-items: center; padding: 10px 20px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; font-weight: 500; color: #374151; background-color: white; cursor: pointer; transition: all 0.2s;"
               onmouseover="this.style.backgroundColor='#f9fafb'; this.style.borderColor='#9ca3af';"
               onmouseout="this.style.backgroundColor='white'; this.style.borderColor='#d1d5db';" class="dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
            <svg style="width: 16px; height: 16px; margin-inline-end: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            {{ __('messages.cancel') }}
        </button>
            <button type="submit" 
                    style="display: inline-flex; align-items: center; padding: 10px 20px; border: 1px solid transparent; border-radius: 8px; font-size: 14px; font-weight: 500; color: white; background: linear-gradient(135deg, #f59e0b, #d97706); cursor: pointer; transition: all 0.2s; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05);"
                    onmouseover="this.style.background='linear-gradient(135deg, #d97706, #b45309)'; this.style.boxShadow='0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06)';"
                    onmouseout="this.style.background='linear-gradient(135deg, #f59e0b, #d97706)'; this.style.boxShadow='0 1px 2px 0 rgba(0,0,0,0.05)';">
                <svg style="width: 16px; height: 16px; margin-inline-end: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ __('messages.update_teacher') ?? 'Update Teacher' }}
            </button>
        </div>
    </div>
</form>
