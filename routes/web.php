<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{
    DashboardController,
    StudentController,
    TeacherController,
    ClassController,
    PaymentController,
    MonthlyRevenueController,
    SubjectController,
    LanguageController,
    HomeController,
    UnpaidStudentsController,
    ReportController,
    TeacherPaymentController,
    UserController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// =========================================================================
// PUBLIC ROUTES
// =========================================================================

// Authentication Routes (Laravel UI)
Auth::routes();

// Language Localization
Route::get('/language/{lang}', [LanguageController::class, 'switch'])
    ->name('language.switch');

// =========================================================================
// PROTECTED ROUTES (Require Authentication & Localization)
// =========================================================================
Route::middleware(['auth', 'localization'])->group(function () {
    
    // =====================================================================
    // DASHBOARD & HOME
    // =====================================================================
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });
    
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    
    Route::get('/home', [HomeController::class, 'index'])
        ->name('home');

    // =====================================================================
    // STUDENT MANAGEMENT
    // =====================================================================
    Route::prefix('students')->name('students.')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('index');
        Route::get('/create', [StudentController::class, 'create'])->name('create');
        Route::post('/', [StudentController::class, 'store'])->name('store');
        Route::get('/{student}', [StudentController::class, 'show'])->name('show');
        Route::get('/{student}/edit', [StudentController::class, 'edit'])->name('edit');
        Route::put('/{student}', [StudentController::class, 'update'])->name('update');
        Route::delete('/{student}', [StudentController::class, 'destroy'])->name('destroy');
        
        // Additional student routes
        Route::get('/{student}/join-class', [StudentController::class, 'joinClass'])
            ->name('join-class');
        Route::post('/{student}/join-class', [StudentController::class, 'storeJoinClass'])
            ->name('store-join-class');
        
        // Bulk import routes
        Route::get('/import', [StudentController::class, 'import'])
            ->name('import');
        Route::post('/import', [StudentController::class, 'processImport'])
            ->name('process-import');
    });

    // =====================================================================
    // TEACHER MANAGEMENT
    // =====================================================================
    Route::prefix('teachers')->name('teachers.')->group(function () {
        Route::get('/', [TeacherController::class, 'index'])->name('index');
        Route::get('/create', [TeacherController::class, 'create'])->name('create');
        Route::post('/', [TeacherController::class, 'store'])->name('store');
        Route::get('/{teacher}', [TeacherController::class, 'show'])->name('show');
        Route::get('/{teacher}/edit', [TeacherController::class, 'edit'])->name('edit');
        Route::put('/{teacher}', [TeacherController::class, 'update'])->name('update');
        Route::delete('/{teacher}', [TeacherController::class, 'destroy'])->name('destroy');
    });

    // =====================================================================
    // CLASS MANAGEMENT
    // =====================================================================
    Route::prefix('classes')->name('classes.')->group(function () {
        Route::get('/', [ClassController::class, 'index'])->name('index');
        Route::get('/create', [ClassController::class, 'create'])->name('create');
        Route::post('/', [ClassController::class, 'store'])->name('store');
        Route::get('/{class}', [ClassController::class, 'show'])->name('show');
        Route::get('/{class}/edit', [ClassController::class, 'edit'])->name('edit');
        Route::put('/{class}', [ClassController::class, 'update'])->name('update');
        Route::delete('/{class}', [ClassController::class, 'destroy'])->name('destroy');
        
        // Additional class routes
        Route::get('/{class}/enroll-students', [ClassController::class, 'enrollStudents'])
            ->name('enroll-students');
        Route::post('/{class}/append-students', [ClassController::class, 'appendStudents'])
            ->name('append-students');
        Route::post('/{class}/remove-students', [ClassController::class, 'removeStudents'])
            ->name('remove-students');
    });

    // =====================================================================
    // PAYMENT MANAGEMENT
    // =====================================================================
    Route::prefix('payments')->name('payments.')->group(function () {
        // Bulk payment routes (must come before resource routes)
        Route::get('/create-bulk', [PaymentController::class, 'createBulk'])
            ->name('create-bulk');
        Route::post('/store-bulk', [PaymentController::class, 'storeBulk'])
            ->name('store-bulk');
        
        // Resource routes
        Route::resource('/', PaymentController::class)->parameters(['' => 'payment']);
    });

    // =====================================================================
    // SUBJECT MANAGEMENT
    // =====================================================================
    Route::resource('subjects', SubjectController::class);

    // =====================================================================
    // MONTHLY REVENUE MANAGEMENT
    // =====================================================================
    Route::prefix('monthly-revenues')->name('monthly-revenues.')->group(function () {
        Route::resource('/', MonthlyRevenueController::class)->parameters(['' => 'monthlyRevenue']);
        
        // Additional revenue routes
        Route::post('/{monthlyRevenue}/recalculate', [MonthlyRevenueController::class, 'recalculate'])
            ->name('recalculate');
        Route::get('/year-to-date', [MonthlyRevenueController::class, 'yearToDate'])
            ->name('year-to-date');
        Route::get('/comparison', [MonthlyRevenueController::class, 'comparison'])
            ->name('comparison');
        Route::get('/export', [MonthlyRevenueController::class, 'export'])
            ->name('export');
    });

    // =====================================================================
    // TEACHER PAYMENT MANAGEMENT
    // =====================================================================
    Route::resource('teacher-payments', TeacherPaymentController::class);

    // =====================================================================
    // REPORTS & ANALYTICS
    // =====================================================================
    Route::prefix('reports')->name('reports.')->group(function () {
        // Unpaid students report
        Route::get('/unpaid-students', [UnpaidStudentsController::class, 'index'])
            ->name('unpaid-students.index');
        
        // Subject payments report
        Route::get('/subject-payments', [ReportController::class, 'subjectPayments'])
            ->name('subject-payments');
        
        // Teacher earnings report
        Route::get('/teacher-earnings', [ReportController::class, 'teacherEarnings'])
            ->name('teacher-earnings');
    });

    // =====================================================================
    // USER MANAGEMENT (Admin Only)
    // =====================================================================
    Route::prefix('users')->name('users.')->middleware('admin')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        
        // Additional user routes
        Route::get('/{user}/change-password', [UserController::class, 'showChangePasswordForm'])
            ->name('change-password');
        Route::post('/{user}/change-password', [UserController::class, 'changePassword'])
            ->name('update-password');
        Route::post('/{user}/toggle-status', [UserController::class, 'toggleStatus'])
            ->name('toggle-status');
    });
});
