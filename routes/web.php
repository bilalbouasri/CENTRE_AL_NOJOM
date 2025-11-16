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
    TeacherPaymentController
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
    Route::resource('teachers', TeacherController::class);

    // =====================================================================
    // CLASS MANAGEMENT
    // =====================================================================
    Route::prefix('classes')->name('classes.')->group(function () {
        Route::resource('/', ClassController::class)->parameters(['' => 'class']);
        
        // Additional class routes
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
});
