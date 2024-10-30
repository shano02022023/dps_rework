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
    Route::post('/application/parents', [ApplicationController::class, 'validateParentsBackground'])->name('applicant.validate.parentsBackground');
});

Route::prefix('applicant')->group(function() {
    Route::get('/', [ApplicantController::class, 'index'])->name('applicant.index');
});

Route::prefix(prefix: 'users')->group(callback: function() {
    Route::get('/', [UserController::class, 'index'])->name('user.index');
    Route::get('/edit/{user}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::post('register', [UserController::class, 'store'])->name('user.store');

});


require __DIR__ . '/auth.php';
