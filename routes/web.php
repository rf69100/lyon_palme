<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

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
});

