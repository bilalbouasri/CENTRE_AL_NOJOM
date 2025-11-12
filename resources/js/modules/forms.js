/**
 * Form validation and enhancement utilities
 */

export class FormManager {
    /**
     * Initialize form enhancements
     */
    static init() {
        // Auto-hide flash messages
        this.autoHideFlashMessages();
        
        // Add loading states to forms
        this.addFormLoadingStates();
        
        // Add character counters to textareas
        this.addCharacterCounters();
        
        // Add input enhancements
        this.enhanceInputs();
    }

    /**
     * Auto-hide flash messages
     */
    static autoHideFlashMessages() {
        setTimeout(() => {
            const flashMessages = document.querySelectorAll('.fixed');
            flashMessages.forEach(msg => {
                msg.style.transform = 'translateX(100%)';
                setTimeout(() => msg.remove(), 300);
            });
        }, 5000);
    }

    /**
     * Add loading states to forms
     */
    static addFormLoadingStates() {
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function() {
                const submitButton = this.querySelector('button[type="submit"]');
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.innerHTML = `
                        <svg class="animate-spin ltr:-ml-1 rtl:-mr-1 ltr:mr-2 rtl:ml-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Loading...
                    `;
                }
            });
        });
    }

    /**
     * Add character counters to textareas
     */
    static addCharacterCounters() {
        const textareas = document.querySelectorAll('textarea[data-max-length]');
        textareas.forEach(textarea => {
            const maxLength = parseInt(textarea.getAttribute('data-max-length')) || 1000;
            const counterId = textarea.id ? `${textarea.id}-counter` : `counter-${Date.now()}`;
            
            // Create counter element if it doesn't exist
            let counter = textarea.nextElementSibling?.querySelector(`#${counterId}`);
            if (!counter) {
                const wrapper = document.createElement('div');
                wrapper.className = 'flex justify-between mt-1';
                wrapper.innerHTML = `
                    <p class="text-xs text-gray-500 dark:text-gray-400">Optional description for the subject</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400" id="${counterId}">${textarea.value.length}/${maxLength}</p>
                `;
                textarea.parentNode.insertBefore(wrapper, textarea.nextSibling);
                counter = document.getElementById(counterId);
            }

            // Add input event listener
            textarea.addEventListener('input', function() {
                const length = this.value.length;
                counter.textContent = `${length}/${maxLength}`;
                
                if (length > maxLength * 0.9) {
                    counter.classList.add('text-yellow-600');
                    counter.classList.remove('text-gray-500');
                } else {
                    counter.classList.remove('text-yellow-600');
                    counter.classList.add('text-gray-500');
                }
                
                if (length > maxLength) {
                    counter.classList.add('text-red-600');
                    counter.classList.remove('text-yellow-600');
                } else {
                    counter.classList.remove('text-red-600');
                }
            });

            // Initialize counter
            textarea.dispatchEvent(new Event('input'));
        });
    }

    /**
     * Enhance input fields with focus effects
     */
    static enhanceInputs() {
        const inputs = document.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            // Focus effects
            input.addEventListener('focus', function() {
                this.style.borderColor = '#3b82f6';
                this.style.boxShadow = '0 0 0 3px rgba(59, 130, 246, 0.1)';
            });

            input.addEventListener('blur', function() {
                this.style.borderColor = '#d1d5db';
                this.style.boxShadow = 'none';
            });

            // Real-time validation for required fields
            if (input.hasAttribute('required')) {
                input.addEventListener('blur', function() {
                    this.validate();
                });

                // Add validate method to input
                input.validate = function() {
                    if (!this.value.trim()) {
                        this.style.borderColor = '#ef4444';
                        return false;
                    } else {
                        this.style.borderColor = '#d1d5db';
                        return true;
                    }
                };
            }
        });
    }

    /**
     * Validate a form
     */
    static validateForm(form) {
        let isValid = true;
        const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
        
        inputs.forEach(input => {
            if (!input.value.trim()) {
                input.style.borderColor = '#ef4444';
                isValid = false;
                
                // Add error message if not exists
                if (!input.nextElementSibling?.classList.contains('error-message')) {
                    const errorMsg = document.createElement('p');
                    errorMsg.className = 'error-message mt-1 text-sm text-red-600 dark:text-red-400';
                    errorMsg.textContent = 'This field is required';
                    input.parentNode.insertBefore(errorMsg, input.nextSibling);
                }
            } else {
                input.style.borderColor = '#d1d5db';
                const errorMsg = input.nextElementSibling;
                if (errorMsg?.classList.contains('error-message')) {
                    errorMsg.remove();
                }
            }
        });

        return isValid;
    }

    /**
     * Reset form validation
     */
    static resetFormValidation(form) {
        const inputs = form.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.style.borderColor = '#d1d5db';
            input.style.boxShadow = 'none';
            
            const errorMsg = input.nextElementSibling;
            if (errorMsg?.classList.contains('error-message')) {
                errorMsg.remove();
            }
        });
    }

    /**
     * Auto-select student from URL parameter
     */
    static autoSelectStudentFromUrl() {
        const urlParams = new URLSearchParams(window.location.search);
        const studentId = urlParams.get('student_id');
        
        if (studentId) {
            const studentSelect = document.querySelector('select[name="student_id"]');
            if (studentSelect) {
                studentSelect.value = studentId;
            }
        }
    }

    /**
     * Initialize filter panel functionality
     */
    static initFilterPanel() {
        const filterToggle = document.getElementById('filter-toggle');
        const filtersPanel = document.getElementById('filters-panel');
        const closeFilters = document.getElementById('close-filters');
        const resetFilters = document.getElementById('reset-filters');

        if (filterToggle && filtersPanel) {
            filterToggle.addEventListener('click', function() {
                filtersPanel.classList.toggle('hidden');
                filtersPanel.classList.toggle('slide-down');
            });

            if (closeFilters) {
                closeFilters.addEventListener('click', function() {
                    filtersPanel.classList.add('hidden');
                    filtersPanel.classList.remove('slide-down');
                });
            }

            if (resetFilters) {
                resetFilters.addEventListener('click', function() {
                    const form = filtersPanel.querySelector('form');
                    form.reset();
                });
            }

            // Close filters when clicking outside
            document.addEventListener('click', function(event) {
                if (!filtersPanel.contains(event.target) && !filterToggle.contains(event.target)) {
                    filtersPanel.classList.add('hidden');
                    filtersPanel.classList.remove('slide-down');
                }
            });
        }
    }
}

export default FormManager;