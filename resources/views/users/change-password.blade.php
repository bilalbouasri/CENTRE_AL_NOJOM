@extends('layouts.app')

@section('content')
<div class="space-y-4">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Change Password') }}</h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                {{ __('Update password for :name', ['name' => $user->name]) }}
            </p>
        </div>
        <a href="{{ route('users.show', $user) }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <svg class="w-4 h-4 ltr:mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            {{ __('Back to User') }}
        </a>
    </div>

    <!-- Change Password Form -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
        <form action="{{ route('users.update-password', $user) }}" method="POST">
            @csrf
            
            <div class="p-6 space-y-6">
                <!-- User Information -->
                <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 rounded-full bg-primary-500 flex items-center justify-center text-white font-medium">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    </div>
                    <div class="ltr:ml-4 rtl:mr-4">
                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ $user->name }}
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $user->email }}
                        </div>
                    </div>
                </div>

                <!-- Password Fields -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                        {{ __('New Password') }}
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- New Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('New Password') }} *
                            </label>
                            <input type="password" 
                                   name="password" 
                                   id="password"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="{{ __('Enter new password') }}"
                                   autocomplete="new-password">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Confirm New Password') }} *
                            </label>
                            <input type="password" 
                                   name="password_confirmation" 
                                   id="password_confirmation"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="{{ __('Confirm new password') }}"
                                   autocomplete="new-password">
                        </div>
                    </div>

                    <!-- Password Requirements -->
                    <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <h4 class="text-sm font-medium text-blue-800 dark:text-blue-300 mb-2">
                            {{ __('Password Requirements') }}
                        </h4>
                        <ul class="text-xs text-blue-700 dark:text-blue-400 space-y-1">
                            <li class="flex items-center">
                                <svg class="w-3 h-3 ltr:mr-2 rtl:ml-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                {{ __('Minimum 8 characters') }}
                            </li>
                            <li class="flex items-center">
                                <svg class="w-3 h-3 ltr:mr-2 rtl:ml-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                {{ __('At least one uppercase letter') }}
                            </li>
                            <li class="flex items-center">
                                <svg class="w-3 h-3 ltr:mr-2 rtl:ml-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                {{ __('At least one lowercase letter') }}
                            </li>
                            <li class="flex items-center">
                                <svg class="w-3 h-3 ltr:mr-2 rtl:ml-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                {{ __('At least one number') }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600 flex justify-end space-x-3">
                <a href="{{ route('users.show', $user) }}" 
                   class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 ltr:mr-2 rtl:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    {{ __('Update Password') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection