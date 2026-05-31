<?php

use App\Http\Controllers\AdherentController;
use App\Http\Controllers\AdhesionController;
use App\Http\Controllers\AnnuaireController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\CertificatMedicalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\MonProfilController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\TrombinoscopeController;
use Illuminate\Support\Facades\Route;

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

    // Espace nageur : mes données personnelles + préférences (US14/15/16)
    Route::get('/mon-profil', [MonProfilController::class, 'edit'])->name('mon-profil.edit');
    Route::put('/mon-profil', [MonProfilController::class, 'update'])->name('mon-profil.update');

    // Trombinoscope et annuaire des nageurs (US17/18)
    Route::get('/trombinoscope', [TrombinoscopeController::class, 'index'])->name('trombinoscope');
    Route::get('/annuaire', [AnnuaireController::class, 'index'])->name('annuaire');

    // Support
    Route::get('/support/contact', [SupportController::class, 'index'])->name('support.index');
    Route::post('/support/contact', [SupportController::class, 'store'])->name('support.store');

    // Help & Documentation
    Route::get('/aide/guide-gestion', [HelpController::class, 'guideGestion'])->name('help.guide');
    Route::get('/aide/faq', [HelpController::class, 'faq'])->name('help.faq');
    Route::get('/aide/contact-admin', [HelpController::class, 'contactAdmin'])->name('help.contact');

    // Admin routes - Gestion des adhérents (réservées aux rôles administratifs)
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::resource('adherents', AdherentController::class);
        Route::post('adherents/{adherent}/restore', [AdherentController::class, 'restore'])->name('adherents.restore');
        Route::post('adherents/{adherent}/compte', [AdherentController::class, 'createAccount'])->name('adherents.create-account');

        // Certificats médicaux (US10)
        Route::get('certificats-medicaux', [CertificatMedicalController::class, 'index'])->name('certificats.index');
        Route::get('certificats-medicaux/export', [CertificatMedicalController::class, 'export'])->name('certificats.export');
        Route::get('certificats-medicaux/{certificat}/download', [CertificatMedicalController::class, 'download'])->name('certificats.download');

        // Cotisations (US11)
        Route::get('cotisations', [AdhesionController::class, 'index'])->name('cotisations.index');
        Route::get('cotisations/export', [AdhesionController::class, 'export'])->name('cotisations.export');

        // Paiements (US11)
        Route::get('adhesions/{adhesion}/paiements/create', [PaiementController::class, 'create'])->name('paiements.create');
        Route::post('adhesions/{adhesion}/paiements', [PaiementController::class, 'store'])->name('paiements.store');

        // Journaux d'audit (US2)
        Route::get('journaux-audit', [AuditLogController::class, 'index'])->name('audit.index');
    });
});
