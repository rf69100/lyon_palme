<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\SupportController;

Route::get('/', function () {
    return view('index');
});

// Pages publiques du footer
Route::get('/documentation', function () {
    return view('pages.documentation');
})->name('documentation');

Route::get('/support', function () {
    return view('pages.support');
})->name('support');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/rgpd', function () {
    return view('pages.rgpd');
})->name('rgpd');

Route::get('/cnil', function () {
    return view('pages.cnil');
})->name('cnil');

Route::get('/confidentialite', function () {
    return view('pages.confidentialite');
})->name('confidentialite');

Route::get('/conditions', function () {
    return view('pages.conditions');
})->name('conditions');

Route::get('/cookies', function () {
    return view('pages.cookies');
})->name('cookies');

// Protected routes requiring authentication and email verification
Route::middleware(['auth', 'verified', 'audit.trail'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Password management (change password from profile)
    Route::get('/password/change', [PasswordController::class, 'edit'])->name('password.edit');
    Route::put('/password/change', [PasswordController::class, 'update'])->name('password.change');

    // Support
    Route::get('/support/contact', [SupportController::class, 'index'])->name('support.index');
    Route::post('/support/contact', [SupportController::class, 'store'])->name('support.store');
});

