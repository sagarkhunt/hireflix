<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\SubmissionController;
use Illuminate\Support\Facades\Route;

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

// Public routes
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // Interview routes for admins/reviewers
    Route::middleware('role:admin,reviewer')->group(function () {
        Route::resource('interviews', InterviewController::class);
        Route::get('/submissions', [SubmissionController::class, 'index'])->name('submissions.index');
        Route::get('/submissions/{submission}', [SubmissionController::class, 'show'])->name('submissions.show');
        Route::put('/submissions/{submission}', [SubmissionController::class, 'update'])->name('submissions.update');
        Route::get('/interviews/{interview}/submissions', [SubmissionController::class, 'interviewSubmissions'])->name('interviews.submissions');
    });

    // Interview routes for candidates
    Route::middleware('role:candidate')->group(function () {
        Route::get('/candidate/interviews', [InterviewController::class, 'candidateIndex'])->name('candidate.interviews');
        Route::get('/candidate/interviews/{interview}', [InterviewController::class, 'candidateShow'])->name('candidate.interview');
        Route::post('/submissions', [SubmissionController::class, 'store'])->name('submissions.store');
    });
});
