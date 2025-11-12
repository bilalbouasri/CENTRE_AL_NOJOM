<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>

    <style>
        [dir="rtl"] {
            text-align: right;
        }
        [dir="ltr"] {
            text-align: left;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('dashboard') }}" class="text-xl font-bold text-gray-800 dark:text-white">
                                {{ __('CENTRE AL NOJOM') }}
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                {{ __('messages.dashboard') }}
                            </x-nav-link>
                            <x-nav-link :href="route('students.index')" :active="request()->routeIs('students.*')">
                                {{ __('messages.students') }}
                            </x-nav-link>
                            <x-nav-link :href="route('teachers.index')" :active="request()->routeIs('teachers.*')">
                                {{ __('messages.teachers') }}
                            </x-nav-link>
                            <x-nav-link :href="route('classes.index')" :active="request()->routeIs('classes.*')">
                                {{ __('messages.classes') }}
                            </x-nav-link>
                            <x-nav-link :href="route('payments.index')" :active="request()->routeIs('payments.*')">
                                {{ __('messages.payments') }}
                            </x-nav-link>
                            <x-nav-link :href="route('subjects.index')" :active="request()->routeIs('subjects.*')">
                                {{ __('messages.subjects') }}
                            </x-nav-link>
                        </div>
                    </div>

                    <!-- Right side items -->
                    <div class="flex items-center space-x-4">
                        <!-- Language Switcher - Flags -->
                        <div class="flex items-center space-x-2 border border-gray-300 dark:border-gray-600 rounded-lg p-1 bg-white dark:bg-gray-800">
                            <!-- English Flag -->
                            <a href="{{ route('language.switch', ['lang' => 'en']) }}"
                               class="flex items-center justify-center w-8 h-8 rounded {{ app()->getLocale() === 'en' ? 'bg-blue-100 border border-blue-300' : 'hover:bg-gray-100' }} transition-colors duration-200"
                               title="English">
                                <svg class="w-5 h-5" viewBox="0 0 640 480">
                                    <path fill="#012169" d="M0 0h640v480H0z"/>
                                    <path fill="#FFF" d="m75 0l244 181L562 0h78v62L400 241l240 178v61h-80L320 301 81 480H0v-60l239-178L0 64V0h75z"/>
                                    <path fill="#C8102E" d="m424 281l216 159v40L369 281h55zm-184 20l6 35L54 480H0l240-179zM640 0v3L391 191l2-44L590 0h50zM0 0l239 176h-60L0 42V0z"/>
                                    <path fill="#C8102E" d="M241 0v480h160V0H241zM0 160v160h640V160H0z"/>
                                </svg>
                            </a>
                            
                            <!-- Arabic Flag (Moroccan) -->
                            <a href="{{ route('language.switch', ['lang' => 'ar']) }}"
                               class="flex items-center justify-center w-8 h-8 rounded {{ app()->getLocale() === 'ar' ? 'bg-green-100 border border-green-300' : 'hover:bg-gray-100' }} transition-colors duration-200"
                               title="العربية">
                                <svg class="w-5 h-5" viewBox="0 0 640 480">
                                    <path fill="#c1272d" d="M640 0H0v480h640z"/>
                                    <path fill="none" stroke="#006233" stroke-width="11.7" d="M320 179.4 284.4 289l93.2-67.6H262.4l93.2 67.6z"/>
                                </svg>
                            </a>
                        </div>

                        <!-- Dark Mode Toggle -->
                        <button id="dark-mode-toggle" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" title="Toggle Dark Mode">
                            <svg id="dark-icon" class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                            </svg>
                            <svg id="light-icon" class="w-5 h-5 text-gray-600 dark:text-gray-300 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </button>

                        <!-- Settings Dropdown -->
                        <div class="hidden sm:flex sm:items-center">
                            <div class="relative">
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                            <div>{{ Auth::user()->name }}</div>
                                            <div class="ms-1">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        <!-- Authentication -->
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')"
                                                    onclick="event.preventDefault();
                                                                this.closest('form').submit();">
                                                {{ __('messages.logout') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="fixed top-4 right-4 bg-green-500 dark:bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="fixed top-4 right-4 bg-red-500 dark:bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('error') }}
        </div>
    @endif

    <script>
        // Dark Mode Functionality
        function initializeDarkMode() {
            const darkModeToggle = document.getElementById('dark-mode-toggle');
            const darkIcon = document.getElementById('dark-icon');
            const lightIcon = document.getElementById('light-icon');
            
            // Get saved dark mode state from localStorage
            const savedDarkMode = localStorage.getItem('darkMode');
            const isDarkMode = savedDarkMode === 'true';
            
            // Apply dark mode based on saved state
            function applyDarkMode(isDark) {
                if (isDark) {
                    document.documentElement.classList.add('dark');
                    darkIcon.classList.add('hidden');
                    lightIcon.classList.remove('hidden');
                } else {
                    document.documentElement.classList.remove('dark');
                    darkIcon.classList.remove('hidden');
                    lightIcon.classList.add('hidden');
                }
                localStorage.setItem('darkMode', isDark.toString());
            }
            
            // Initialize dark mode
            applyDarkMode(isDarkMode);
            
            // Toggle dark mode
            darkModeToggle.addEventListener('click', function() {
                const isCurrentlyDark = document.documentElement.classList.contains('dark');
                applyDarkMode(!isCurrentlyDark);
            });
        }

        // Auto-hide flash messages after 5 seconds
        setTimeout(() => {
            const flashMessages = document.querySelectorAll('.fixed');
            flashMessages.forEach(msg => msg.remove());
        }, 5000);

        // Initialize dark mode when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            initializeDarkMode();
        });
    </script>
</body>
</html>
