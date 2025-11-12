@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex-1">
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white flex items-center">
                    <svg class="w-6 h-6 lg:w-8 lg:h-8 ltr:mr-3 rtl:ml-3 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                    </svg>
                    Import Students
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Bulk import students from a JSON file</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('students.index') }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200">
                    <svg class="w-4 h-4 lg:w-5 lg:h-5 ltr:mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Students
                </a>
            </div>
        </div>
    </div>

    <!-- Import Form -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
        <div class="max-w-2xl mx-auto">
            <!-- Instructions -->
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-6">
                <div class="flex">
                    <svg class="h-5 w-5 text-blue-400 ltr:mr-3 rtl:ml-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-blue-800 dark:text-blue-300">Import Instructions</h3>
                        <div class="mt-2 text-sm text-blue-700 dark:text-blue-400">
                            <p class="mb-2">Upload a JSON file containing an array of student objects. Each student should have the following fields:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li><code class="text-blue-800 dark:text-blue-300">first_name</code> (required)</li>
                                <li><code class="text-blue-800 dark:text-blue-300">last_name</code> (required)</li>
                                <li><code class="text-blue-800 dark:text-blue-300">phone</code> (required, unique)</li>
                                <li><code class="text-blue-800 dark:text-blue-300">grade</code> (required)</li>
                                <li><code class="text-blue-800 dark:text-blue-300">joined_date</code> (required, YYYY-MM-DD)</li>
                                <li><code class="text-blue-800 dark:text-blue-300">notes</code> (optional)</li>
                                <li><code class="text-blue-800 dark:text-blue-300">subjects</code> (optional, array of subject names)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- JSON Example -->
            <div class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-4 mb-6">
                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Example JSON Format:</h4>
                <pre class="text-xs bg-gray-900 text-gray-100 p-3 rounded overflow-x-auto"><code>[
  {
    "first_name": "John",
    "last_name": "Doe",
    "phone": "+1234567890",
    "grade": "10",
    "joined_date": "2024-01-15",
    "notes": "Excellent student",
    "subjects": ["Mathematics", "Physics"]
  },
  {
    "first_name": "Jane",
    "last_name": "Smith",
    "phone": "+1234567891",
    "grade": "11",
    "joined_date": "2024-01-20",
    "subjects": ["Chemistry", "Biology"]
  }
]</code></pre>
            </div>

            <!-- Upload Form -->
            <form action="{{ route('students.process-import') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <!-- File Upload -->
                <div>
                    <label for="json_file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        JSON File
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                <label for="json_file" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-primary-600 dark:text-primary-400 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                    <span>Upload a file</span>
                                    <input id="json_file" name="json_file" type="file" class="sr-only" accept=".json,.txt">
                                </label>
                                <p class="ltr:pl-1 rtl:pr-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">JSON files up to 10MB</p>
                        </div>
                    </div>
                    @error('json_file')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200">
                        <svg class="w-4 h-4 lg:w-5 lg:h-5 ltr:mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                        </svg>
                        Import Students
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Drag and Drop Functionality -->
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('json_file');
    const dropZone = fileInput.closest('.border-dashed');
    
    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });
    
    // Highlight drop zone when item is dragged over it
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });
    
    // Handle dropped files
    dropZone.addEventListener('drop', handleDrop, false);
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    function highlight() {
        dropZone.classList.add('border-primary-500', 'bg-primary-50', 'dark:bg-primary-900/20');
    }
    
    function unhighlight() {
        dropZone.classList.remove('border-primary-500', 'bg-primary-50', 'dark:bg-primary-900/20');
    }
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        fileInput.files = files;
        
        // Update the display to show the file name
        if (files.length > 0) {
            const fileName = files[0].name;
            const label = dropZone.querySelector('span');
            if (label) {
                label.textContent = fileName;
            }
        }
    }
});
</script>
@endpush
@endsection