<?php

use App\Models\AuditLog;
use App\Models\Utilisateur;
use App\Services\AuditService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = Utilisateur::factory()->create();
    Auth::login($this->user);
});

test('log creates an audit log entry', function () {
    $log = AuditService::log(
        action: 'test_action',
        resourceType: 'TestResource',
        resourceId: 123
    );

    expect($log)->toBeInstanceOf(AuditLog::class)
        ->and($log->utilisateur_id)->toBe($this->user->id)
        ->and($log->action)->toBe('test_action')
        ->and($log->resource_type)->toBe('TestResource')
        ->and($log->resource_id)->toBe(123)
        ->and($log->success)->toBeTrue();
});

test('log stores old and new values', function () {
    $oldValues = ['name' => 'Old Name'];
    $newValues = ['name' => 'New Name'];

    $log = AuditService::log(
        action: 'update',
        resourceType: 'User',
        resourceId: 1,
        oldValues: $oldValues,
        newValues: $newValues
    );

    expect($log->old_values)->toBe($oldValues)
        ->and($log->new_values)->toBe($newValues);
});

test('log stores request information', function () {
    $log = AuditService::log(
        action: 'test',
        resourceType: 'Test'
    );

    expect($log->method)->not()->toBeNull()
        ->and($log->path)->not()->toBeNull()
        ->and($log->ip_address)->not()->toBeNull()
        ->and($log->user_agent)->not()->toBeNull();
});

test('logLogin creates login audit entry', function () {
    $log = AuditService::logLogin('test@example.com', '127.0.0.1', true);

    expect($log->action)->toBe('login')
        ->and($log->resource_type)->toBe('Utilisateur')
        ->and($log->success)->toBeTrue()
        ->and($log->error_message)->toBeNull();
});

test('logLogin records failed login', function () {
    $log = AuditService::logLogin('test@example.com', '127.0.0.1', false);

    expect($log->action)->toBe('login')
        ->and($log->success)->toBeFalse()
        ->and($log->error_message)->toBe('Failed login attempt');
});

test('logLogout creates logout audit entry', function () {
    $log = AuditService::logLogout();

    expect($log->action)->toBe('logout')
        ->and($log->resource_type)->toBe('Utilisateur')
        ->and($log->utilisateur_id)->toBe($this->user->id);
});

test('logCreate stores new values', function () {
    $newValues = [
        'name' => 'Test User',
        'email' => 'test@example.com',
    ];

    $log = AuditService::logCreate('User', 1, $newValues);

    expect($log->action)->toBe('create')
        ->and($log->resource_type)->toBe('User')
        ->and($log->resource_id)->toBe(1)
        ->and($log->new_values)->toBe($newValues)
        ->and($log->old_values)->toBeNull();
});

test('logUpdate stores both old and new values', function () {
    $oldValues = ['name' => 'Old Name'];
    $newValues = ['name' => 'New Name'];

    $log = AuditService::logUpdate('User', 1, $oldValues, $newValues);

    expect($log->action)->toBe('update')
        ->and($log->old_values)->toBe($oldValues)
        ->and($log->new_values)->toBe($newValues);
});

test('logDelete stores old values', function () {
    $oldValues = [
        'name' => 'Deleted User',
        'email' => 'deleted@example.com',
    ];

    $log = AuditService::logDelete('User', 1, $oldValues);

    expect($log->action)->toBe('delete')
        ->and($log->resource_id)->toBe(1)
        ->and($log->old_values)->toBe($oldValues)
        ->and($log->new_values)->toBeNull();
});

test('logExport creates export audit entry', function () {
    $log = AuditService::logExport('Adherent', 150);

    expect($log->action)->toBe('export')
        ->and($log->resource_type)->toBe('Adherent')
        ->and($log->new_values)->toBe(['count' => 150]);
});

test('logExport works without count', function () {
    $log = AuditService::logExport('Adherent');

    expect($log->action)->toBe('export')
        ->and($log->resource_type)->toBe('Adherent')
        ->and($log->new_values)->toBeNull();
});

test('logPasswordChange creates password change audit entry', function () {
    $log = AuditService::logPasswordChange($this->user->id);

    expect($log->action)->toBe('password_change')
        ->and($log->resource_type)->toBe('Utilisateur')
        ->and($log->resource_id)->toBe($this->user->id);
});

test('logUnauthorizedAccess records failed access', function () {
    $log = AuditService::logUnauthorizedAccess('Adherent', 123);

    expect($log->action)->toBe('unauthorized_access_attempt')
        ->and($log->resource_type)->toBe('Adherent')
        ->and($log->resource_id)->toBe(123)
        ->and($log->success)->toBeFalse()
        ->and($log->error_message)->toBe('User does not have permission to access this resource');
});

test('audit logs are persisted in database', function () {
    AuditService::log('test', 'Test', 1);

    expect(AuditLog::count())->toBe(1);

    $log = AuditLog::first();
    expect($log->action)->toBe('test')
        ->and($log->resource_type)->toBe('Test');
});
