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
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        [dir="rtl"] {
            text-align: right;
        }
        [dir="ltr"] {
            text-align: left;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        /* Enhanced card animations */
        .student-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .student-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        /* Progress bar animation */
        .progress-bar {
            transition: width 0.5s ease-in-out;
        }
        
        /* Mobile optimizations */
        @media (max-width: 768px) {
            .mobile-optimized {
                padding: 1rem;
            }
            
            .mobile-stack {
                flex-direction: column;
            }
        }
        
        /* Dark mode enhancements */
        .dark .card-hover {
            border-color: rgba(255, 255, 255, 0.1);
        }
        
        .dark .student-card {
            background: linear-gradient(145deg, rgba(55, 65, 81, 0.5), rgba(31, 41, 55, 0.5));
        }
        
        .sidebar-link {
            transition: all 0.3s ease;
        }
        
        .sidebar-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }
        
        [dir="rtl"] .sidebar-link:hover {
            transform: translateX(-5px);
        }
        
        .active-sidebar-link {
            background-color: rgba(255, 255, 255, 0.2);
            border-right: 4px solid white;
        }
        
        [dir="rtl"] .active-sidebar-link {
            border-right: none;
            border-left: 4px solid white;
        }

        /* Tooltip styles */
        .tooltip {
            position: relative;
        }
        
        .tooltip:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            background: #1f2937;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            white-space: nowrap;
            z-index: 1000;
            margin-left: 0.5rem;
            font-size: 0.875rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        [dir="rtl"] .tooltip:hover::after {
            left: auto;
            right: 100%;
            margin-left: 0;
            margin-right: 0.5rem;
        }

        /* Sidebar transition */
        .sidebar-transition {
            transition: all 0.3s ease-in-out;
        }
        
        /* Filter panel animations */
        .slide-down {
            animation: slideDown 0.3s ease-out;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Loading spinner */
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }
        
        .animate-spin {
            animation: spin 1s linear infinite;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar-transition bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 shadow-sm z-40 sticky top-0 h-screen overflow-y-auto w-20 lg:translate-x-0 -translate-x-full">
            <!-- Sidebar Content -->
            <div class="flex flex-col h-full">
                <!-- Logo and Toggle -->
                <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center ltr:space-x-3 rtl:space-x-reverse">
                        <button id="sidebar-toggle" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        <span id="logo-text" class="text-xl font-bold text-gray-800 dark:text-white hidden">Admin</span>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="flex-1 p-4 space-y-2">
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors group {{ request()->routeIs('dashboard') ? 'bg-blue-50 dark:bg-blue-900 text-blue-600 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300' }}">
                        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('dashboard') ? 'text-blue-600 dark:text-blue-300' : 'text-gray-500 dark:text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span id="dashboard-text" class="ltr:ml-3 rtl:mr-3 font-medium hidden">{{ __('messages.dashboard') }}</span>
                    </a>
                    
                    <!-- Students -->
                    <a href="{{ route('students.index') }}"
                       class="flex items-center p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors group {{ request()->routeIs('students.*') ? 'bg-blue-50 dark:bg-blue-900 text-blue-600 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300' }}">
                        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('students.*') ? 'text-blue-600 dark:text-blue-300' : 'text-gray-500 dark:text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span id="students-text" class="ltr:ml-3 rtl:mr-3 font-medium hidden">{{ __('messages.students') }}</span>
                    </a>
                    
                    <!-- Teachers -->
                    <a href="{{ route('teachers.index') }}"
                       class="flex items-center p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors group {{ request()->routeIs('teachers.*') ? 'bg-blue-50 dark:bg-blue-900 text-blue-600 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300' }}">
                        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('teachers.*') ? 'text-blue-600 dark:text-blue-300' : 'text-gray-500 dark:text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span id="teachers-text" class="ltr:ml-3 rtl:mr-3 font-medium hidden">{{ __('messages.teachers') }}</span>
                    </a>
                    
                    <!-- Classes -->
                    <a href="{{ route('classes.index') }}"
                       class="flex items-center p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors group {{ request()->routeIs('classes.*') ? 'bg-blue-50 dark:bg-blue-900 text-blue-600 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300' }}">
                        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('classes.*') ? 'text-blue-600 dark:text-blue-300' : 'text-gray-500 dark:text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <span id="classes-text" class="ltr:ml-3 rtl:mr-3 font-medium hidden">{{ __('messages.classes') }}</span>
                    </a>
                    
                    <!-- Payments -->
                    <a href="{{ route('payments.index') }}"
                       class="flex items-center p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors group {{ request()->routeIs('payments.*') ? 'bg-blue-50 dark:bg-blue-900 text-blue-600 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300' }}">
                        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('payments.*') ? 'text-blue-600 dark:text-blue-300' : 'text-gray-500 dark:text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        <span id="payments-text" class="ltr:ml-3 rtl:mr-3 font-medium hidden">{{ __('messages.payments') }}</span>
                    </a>
                    
                    <!-- Subjects -->
                    <a href="{{ route('subjects.index') }}"
                       class="flex items-center p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors group {{ request()->routeIs('subjects.*') ? 'bg-blue-50 dark:bg-blue-900 text-blue-600 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300' }}">
                        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('subjects.*') ? 'text-blue-600 dark:text-blue-300' : 'text-gray-500 dark:text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span id="subjects-text" class="ltr:ml-3 rtl:mr-3 font-medium hidden">{{ __('messages.subjects') }}</span>
                    </a>

                    <!-- Unpaid Students Report -->
                    <a href="{{ route('reports.unpaid-students.index') }}"
                       class="flex items-center p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors group {{ request()->routeIs('reports.unpaid-students.*') ? 'bg-red-50 dark:bg-red-900 text-red-600 dark:text-red-300' : 'text-gray-700 dark:text-gray-300' }}">
                        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('unpaid-students.*') ? 'text-red-600 dark:text-red-300' : 'text-gray-500 dark:text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                        <span id="unpaid-students-text" class="ltr:ml-3 rtl:mr-3 font-medium hidden">Unpaid Students</span>
                    </a>
                </nav>

                <!-- User Section -->
                <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center ltr:space-x-3 rtl:space-x-reverse">
                        <div class="w-10 h-10 bg-primary-500 rounded-full flex items-center justify-center text-white font-medium">
                            {{ Auth::check() ? substr(Auth::user()->name, 0, 1) : 'G' }}
                        </div>
                        <div id="user-info" class="flex-1 min-w-0 hidden">
                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ Auth::check() ? Auth::user()->name : 'Guest' }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ Auth::check() ? Auth::user()->email : 'Not logged in' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Top Navigation -->
            <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-center h-16 px-4 sm:px-6 lg:px-8">
                    <!-- Mobile menu button -->
                    <div class="lg:hidden">
                        <button id="mobile-sidebar-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 focus:outline-none focus:text-gray-600" aria-label="Open sidebar">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Spacer to push right side items to the right -->
                    <div class="flex-1"></div>

                    <!-- Right side items -->
                    <div class="flex items-center ltr:space-x-4 rtl:space-x-reverse">
                        <!-- Language Switcher - Flags -->
                        <div class="flex items-center ltr:space-x-2 rtl:space-x-reverse border border-gray-300 rounded-lg p-1 bg-white dark:bg-gray-800 dark:border-gray-600">
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

                        <!-- User dropdown -->
                        {{-- <div class="relative">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="flex items-center text-sm text-gray-600 hover:text-gray-900 focus:outline-none transition-colors duration-200">
                                        <div class="w-8 h-8 bg-primary-500 rounded-full flex items-center justify-center text-white font-medium">
                                            {{ Auth::check() ? substr(Auth::user()->name, 0, 1) : 'G' }}
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
                        </div> --}}
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-auto bg-gray-50 dark:bg-gray-900">
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="fixed top-4 right-4 bg-green-500 dark:bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform transition-all duration-300 ease-in-out">
            <div class="flex items-center ltr:space-x-2 rtl:space-x-reverse">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="fixed top-4 right-4 bg-red-500 dark:bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform transition-all duration-300 ease-in-out">
            <div class="flex items-center ltr:space-x-2 rtl:space-x-reverse">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Main Application JavaScript -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
