<?php

use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('welcome');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('application')->group(function() {
    Route::get('/application', [ApplicationController::class, 'create'])->name('application.create');
    Route::post('/application/personal', [ApplicationController::class, 'validatePersonalInfo'])->name('application.validate.personalInfo');
    Route::post('/application/parents', [ApplicationController::class, 'validateParentsBackground'])->name('application.validate.parentsBackground');
    Route::post('/application/submit', [ApplicationController::class, 'submit'])->name('application.submit');
});

Route::prefix('applicant')->group(function() {
    Route::get('/pending', [ApplicantController::class, 'indexPending'])->name('applicant.pending.index');
    Route::get('/accepted', [ApplicantController::class, 'indexAccepted'])->name('applicant.accepted.index');
    Route::get('/rejected', [ApplicantController::class, 'indexRejected'])->name('applicant.rejected.index');
    Route::get('/{id}', [ApplicantController::class, 'view'])->name('applicant.view');
    Route::post('/{id}/accept', [ApplicantController::class, 'accept'])->name('applicant.accept');
    Route::post('/{id}/reject', [ApplicantController::class, 'reject'])->name('applicant.reject');
});

Route::prefix(prefix: 'users')->group(callback: function() {
    Route::get('/', [UserController::class, 'index'])->name('user.index');
});

require __DIR__ . '/auth.php';