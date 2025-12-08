<?php

use App\Models\Utilisateur;
use App\Services\PasswordPolicyService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('isPasswordExpired returns true when password was never changed', function () {
    $user = Utilisateur::factory()->create([
        'mot_de_passe_change_le' => null,
    ]);

    $result = PasswordPolicyService::isPasswordExpired($user);

    expect($result)->toBeTrue();
});

test('isPasswordExpired returns true when password is older than 90 days', function () {
    $user = Utilisateur::factory()->create([
        'mot_de_passe_change_le' => Carbon::now()->subDays(100),
    ]);

    $result = PasswordPolicyService::isPasswordExpired($user);

    expect($result)->toBeTrue();
});

test('isPasswordExpired returns false when password is within 90 days', function () {
    $user = Utilisateur::factory()->create([
        'mot_de_passe_change_le' => Carbon::now()->subDays(30),
    ]);

    $result = PasswordPolicyService::isPasswordExpired($user);

    expect($result)->toBeFalse();
});

test('isPasswordExpired returns false for freshly changed password', function () {
    $user = Utilisateur::factory()->create([
        'mot_de_passe_change_le' => Carbon::now(),
    ]);

    $result = PasswordPolicyService::isPasswordExpired($user);

    expect($result)->toBeFalse();
});

test('getDaysUntilExpiration returns 0 for never changed password', function () {
    $user = Utilisateur::factory()->create([
        'mot_de_passe_change_le' => null,
    ]);

    $result = PasswordPolicyService::getDaysUntilExpiration($user);

    expect($result)->toBe(0);
});

test('getDaysUntilExpiration calculates correct days remaining', function () {
    $user = Utilisateur::factory()->create([
        'mot_de_passe_change_le' => Carbon::now()->subDays(60),
    ]);

    $result = PasswordPolicyService::getDaysUntilExpiration($user);

    // Allow for 1 day variance due to test execution time
    expect($result)->toBeGreaterThanOrEqual(29)
        ->and($result)->toBeLessThanOrEqual(30);
});

test('getDaysUntilExpiration returns 0 for expired passwords', function () {
    $user = Utilisateur::factory()->create([
        'mot_de_passe_change_le' => Carbon::now()->subDays(100),
    ]);

    $result = PasswordPolicyService::getDaysUntilExpiration($user);

    expect($result)->toBe(0);
});

test('isPasswordChangeRequired returns true when password is expired', function () {
    $user = Utilisateur::factory()->create([
        'mot_de_passe_change_le' => Carbon::now()->subDays(100),
        'mot_de_passe_expire' => false,
    ]);

    $result = PasswordPolicyService::isPasswordChangeRequired($user);

    expect($result)->toBeTrue();
});

test('isPasswordChangeRequired returns true when manually marked as expired', function () {
    $user = Utilisateur::factory()->create([
        'mot_de_passe_change_le' => Carbon::now(),
        'mot_de_passe_expire' => true,
    ]);

    $result = PasswordPolicyService::isPasswordChangeRequired($user);

    expect($result)->toBeTrue();
});

test('isPasswordChangeRequired returns false when password is valid', function () {
    $user = Utilisateur::factory()->create([
        'mot_de_passe_change_le' => Carbon::now()->subDays(30),
        'mot_de_passe_expire' => false,
    ]);

    $result = PasswordPolicyService::isPasswordChangeRequired($user);

    expect($result)->toBeFalse();
});
