<?php

use App\Services\InputSanitizationService;

test('sanitizeText removes HTML tags', function () {
    $input = '<script>alert("XSS")</script>Hello';
    $result = InputSanitizationService::sanitizeText($input);

    expect($result)->not()->toContain('<script>')
        ->and($result)->not()->toContain('</script>');
});

test('sanitizeText escapes special characters', function () {
    $input = 'Hello & "World"';
    $result = InputSanitizationService::sanitizeText($input);

    expect($result)->toContain('&amp;')
        ->and($result)->toContain('&quot;');
});

test('sanitizeText trims whitespace', function () {
    $input = '  Hello World  ';
    $result = InputSanitizationService::sanitizeText($input);

    expect($result)->toBe('Hello World');
});

test('sanitizeEmail converts to lowercase', function () {
    $email = 'User@Example.COM';
    $result = InputSanitizationService::sanitizeEmail($email);

    expect($result)->toBe('user@example.com');
});

test('sanitizeEmail removes invalid characters', function () {
    $email = 'user()@example.com';
    $result = InputSanitizationService::sanitizeEmail($email);

    expect($result)->not()->toContain('()')
        ->and($result)->toContain('@');
});

test('sanitizePhone removes non-numeric characters except plus and minus', function () {
    $phone = '+33 (0)1-23-45-67-89';
    $result = InputSanitizationService::sanitizePhone($phone);

    expect($result)->toBe('+3301-23-45-67-89'); // Hyphens are kept
});

test('sanitizePhone keeps only valid characters', function () {
    $phone = '123-ABC-456';
    $result = InputSanitizationService::sanitizePhone($phone);

    expect($result)->toBe('123--456') // Double hyphen where ABC was
        ->and($result)->not()->toContain('ABC');
});

test('sanitizePostalCode removes spaces and special characters', function () {
    $code = '69 200';
    $result = InputSanitizationService::sanitizePostalCode($code);

    expect($result)->toBe('69200');
});

test('sanitizePostalCode allows alphanumeric', function () {
    $code = 'SW1A 1AA';
    $result = InputSanitizationService::sanitizePostalCode($code);

    expect($result)->toBe('SW1A1AA');
});

test('sanitizeFileName prevents path traversal', function () {
    $filename = '../../../etc/passwd';
    $result = InputSanitizationService::sanitizeFileName($filename);

    expect($result)->not()->toContain('../')
        ->and($result)->not()->toContain('/')
        ->and($result)->toBe('etcpasswd');
});

test('sanitizeFileName removes dangerous characters', function () {
    $filename = 'my<>file|name?.txt';
    $result = InputSanitizationService::sanitizeFileName($filename);

    expect($result)->toBe('myfilename.txt');
});

test('sanitizeFileName prevents multiple dots', function () {
    $filename = 'file...txt';
    $result = InputSanitizationService::sanitizeFileName($filename);

    expect($result)->toBe('file.txt');
});

test('sanitizeFileName allows valid characters', function () {
    $filename = 'My_Document-2024.pdf';
    $result = InputSanitizationService::sanitizeFileName($filename);

    expect($result)->toBe('My_Document-2024.pdf');
});

test('validatePatterns returns true for valid data', function () {
    $data = [
        'email' => 'test@example.com',
        'phone' => '0123456789',
    ];

    $patterns = [
        'email' => '/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/i',
        'phone' => '/^[0-9]{10}$/',
    ];

    $result = InputSanitizationService::validatePatterns($data, $patterns);

    expect($result)->toBeTrue();
});

test('validatePatterns returns false for invalid data', function () {
    $data = [
        'email' => 'invalid-email',
    ];

    $patterns = [
        'email' => '/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/i',
    ];

    $result = InputSanitizationService::validatePatterns($data, $patterns);

    expect($result)->toBeFalse();
});

test('hasInjectionPatterns detects SQL injection', function () {
    $input = "1' OR '1'='1";
    $result = InputSanitizationService::hasInjectionPatterns($input);

    expect($result)->toBeTrue();
});

test('hasInjectionPatterns detects union select', function () {
    $input = 'UNION SELECT password FROM users';
    $result = InputSanitizationService::hasInjectionPatterns($input);

    expect($result)->toBeTrue();
});

test('hasInjectionPatterns detects script tags', function () {
    $input = '<script>alert("XSS")</script>';
    $result = InputSanitizationService::hasInjectionPatterns($input);

    expect($result)->toBeTrue();
});

test('hasInjectionPatterns detects javascript protocol', function () {
    $input = 'javascript:alert(1)';
    $result = InputSanitizationService::hasInjectionPatterns($input);

    expect($result)->toBeTrue();
});

test('hasInjectionPatterns returns false for clean input', function () {
    $input = 'This is a normal text without injection';
    $result = InputSanitizationService::hasInjectionPatterns($input);

    expect($result)->toBeFalse();
});

test('hasInjectionPatterns detects SQL keywords', function () {
    $keywords = ['SELECT', 'INSERT', 'UPDATE', 'DELETE', 'DROP', 'CREATE', 'ALTER'];

    foreach ($keywords as $keyword) {
        $result = InputSanitizationService::hasInjectionPatterns($keyword);
        expect($result)->toBeTrue("Failed to detect $keyword");
    }
});
