<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Public Routes (no auth required)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Routes (auth required)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Generic dashboard redirect based on role
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;
        if ($role === 'admin')    return redirect()->route('admin.dashboard');
        if ($role === 'employer') return redirect()->route('employer.dashboard');
        return redirect()->route('student.dashboard');
    })->name('dashboard');

    // -------------------------------------------------------
    // Student Routes
    // -------------------------------------------------------
    Route::prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', fn() => view('student.dashboard'))->name('dashboard');
        Route::get('/jobs',      fn() => view('student.jobs'))->name('jobs.index');
        Route::get('/applications', fn() => view('student.applications'))->name('applications.index');
        Route::get('/resume',    fn() => view('student.resume'))->name('resume.index');
    });

    // -------------------------------------------------------
    // Employer Routes
    // -------------------------------------------------------
    Route::prefix('employer')->name('employer.')->group(function () {
        Route::get('/dashboard',    fn() => view('employer.dashboard'))->name('dashboard');
        Route::get('/jobs',         fn() => view('employer.jobs'))->name('jobs.index');
        Route::get('/applications', fn() => view('employer.applications'))->name('applications.index');
    });

    // -------------------------------------------------------
    // Admin Routes
    // -------------------------------------------------------
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
        Route::get('/users',     fn() => view('admin.users'))->name('users.index');
        Route::get('/jobs',      fn() => view('admin.jobs'))->name('jobs.index');
    });

});
