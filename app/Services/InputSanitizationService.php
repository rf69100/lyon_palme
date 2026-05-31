<?php

namespace App\Services;

class InputSanitizationService
{
    /**
     * Sanitize string input to prevent XSS and injection
     */
    public static function sanitizeText(string $input): string
    {
        // Remove HTML tags
        $input = strip_tags($input);

        // Trim whitespace
        $input = trim($input);

        // Escape HTML special characters
        $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');

        return $input;
    }

    /**
     * Sanitize email addresses
     */
    public static function sanitizeEmail(string $email): string
    {
        $email = trim($email);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $email = strtolower($email);

        return $email;
    }

    /**
     * Sanitize phone numbers (remove non-numeric characters except + and -)
     */
    public static function sanitizePhone(string $phone): string
    {
        return preg_replace('/[^0-9+\-]/', '', $phone);
    }

    /**
     * Sanitize postal codes (alphanumeric only)
     */
    public static function sanitizePostalCode(string $code): string
    {
        return preg_replace('/[^a-zA-Z0-9]/', '', $code);
    }

    /**
     * Sanitize file names to prevent path traversal
     */
    public static function sanitizeFileName(string $filename): string
    {
        // Remove path traversal attempts
        $filename = str_replace(['../', '..\\', '../', '..\\'], '', $filename);

        // Remove potentially dangerous characters
        $filename = preg_replace('/[^a-zA-Z0-9._\- ]/', '', $filename);

        // Remove multiple dots (prevent .php.txt etc)
        $filename = preg_replace('/\.{2,}/', '.', $filename);

        return trim($filename);
    }

    /**
     * Validate input against allowed patterns
     */
    public static function validatePatterns(array $data, array $patterns): bool
    {
        foreach ($patterns as $field => $pattern) {
            if (isset($data[$field])) {
                if (! preg_match($pattern, $data[$field])) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Prevent common SQL injection patterns
     */
    public static function hasInjectionPatterns(string $input): bool
    {
        $patterns = [
            '/(\bunion\b.*\bselect\b)/i',
            '/(\bor\b.*=.*)/i',
            '/(\band\b.*=.*=)/i',
            '/(\bexec\b)/i',
            '/(\bscript\b)/i',
            '/(<script)/i',
            '/(\bjavascript:)/i',
            '/(%27)|(\')|(\-\-)/',
            '/(\b(union|select|insert|update|delete|drop|create|alter)\b)/i',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $input)) {
                return true;
            }
        }

        return false;
    }
}
