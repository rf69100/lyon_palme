<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationViewsTest extends TestCase
{
    use RefreshDatabase;

    // View Files Existence Tests
    public function test_all_auth_view_files_exist(): void
    {
        $files = [
            'login.blade.php',
            'register.blade.php',
            'forgot-password.blade.php',
            'reset-password.blade.php',
            'verify-email.blade.php',
            'confirm-password.blade.php',
            'two-factor-challenge.blade.php',
        ];

        foreach ($files as $file) {
            $path = resource_path("views/auth/$file");
            $this->assertTrue(
                file_exists($path),
                "Auth view file [$file] should exist"
            );
        }
    }

    public function test_auth_layout_files_exist(): void
    {
        $this->assertTrue(file_exists(resource_path('views/layouts/auth.blade.php')));
        $this->assertTrue(file_exists(resource_path('views/layouts/app.blade.php')));
    }

    // CSS/Styling Tests
    public function test_auth_layout_includes_tailwind_css(): void
    {
        $content = file_get_contents(resource_path('views/layouts/auth.blade.php'));
        $this->assertStringContainsString('cdn.tailwindcss.com', $content);
    }

    public function test_auth_layout_includes_inter_font(): void
    {
        $content = file_get_contents(resource_path('views/layouts/auth.blade.php'));
        $this->assertStringContainsString('bunny.net', $content);
        $this->assertStringContainsString('Inter', $content);
    }

    public function test_auth_pages_use_styling(): void
    {
        $pages = [
            'login.blade.php',
            'register.blade.php',
            'forgot-password.blade.php',
            'reset-password.blade.php',
            'verify-email.blade.php',
            'confirm-password.blade.php',
        ];

        foreach ($pages as $page) {
            $content = file_get_contents(resource_path("views/auth/$page"));
            // Check that page uses either Tailwind CSS or inline styles
            $hasStyle = (
                str_contains($content, 'bg-gradient') ||
                str_contains($content, 'min-h-screen') ||
                str_contains($content, 'rounded-') ||
                str_contains($content, 'border-radius') ||
                str_contains($content, 'background:') ||
                str_contains($content, 'style=')
            );
            $this->assertTrue($hasStyle, "$page should have styling");
        }
    }

    // Form Fields Tests
    public function test_login_page_form_fields(): void
    {
        $content = file_get_contents(resource_path('views/auth/login.blade.php'));

        $this->assertStringContainsString('type="email"', $content);
        $this->assertStringContainsString('name="email"', $content);
        $this->assertStringContainsString('type="password"', $content);
        $this->assertStringContainsString('name="password"', $content);
        $this->assertStringContainsString('type="checkbox"', $content);
        $this->assertStringContainsString('name="remember"', $content);
    }

    public function test_register_page_form_fields(): void
    {
        $content = file_get_contents(resource_path('views/auth/register.blade.php'));

        $this->assertStringContainsString('name="nom"', $content);
        $this->assertStringContainsString('type="email"', $content);
        $this->assertStringContainsString('name="email"', $content);
        $this->assertStringContainsString('type="password"', $content);
        $this->assertStringContainsString('name="password"', $content);
        $this->assertStringContainsString('password_confirmation', $content);
    }

    public function test_forgot_password_page_form_fields(): void
    {
        $content = file_get_contents(resource_path('views/auth/forgot-password.blade.php'));

        $this->assertStringContainsString('type="email"', $content);
        $this->assertStringContainsString('name="email"', $content);
    }

    public function test_reset_password_page_form_fields(): void
    {
        $content = file_get_contents(resource_path('views/auth/reset-password.blade.php'));

        $this->assertStringContainsString('readonly', $content);
        $this->assertStringContainsString('name="password"', $content);
        $this->assertStringContainsString('password_confirmation', $content);
        $this->assertStringContainsString('name="token"', $content);
    }

    // Security Tests
    public function test_form_pages_have_csrf_protection(): void
    {
        $pages = [
            'login.blade.php',
            'register.blade.php',
            'forgot-password.blade.php',
            'reset-password.blade.php',
        ];

        foreach ($pages as $page) {
            $content = file_get_contents(resource_path("views/auth/$page"));
            $this->assertStringContainsString('@csrf', $content, "$page should have CSRF token");
        }
    }

    // Button/Link Tests
    public function test_login_page_has_links(): void
    {
        $content = file_get_contents(resource_path('views/auth/login.blade.php'));

        $this->assertStringContainsString('register', $content);
        $this->assertStringContainsString('password.request', $content);
        $this->assertStringContainsString('Se connecter', $content);
    }

    public function test_register_page_has_links(): void
    {
        $content = file_get_contents(resource_path('views/auth/register.blade.php'));

        $this->assertStringContainsString('login', $content);
        $this->assertStringContainsString("S'inscrire", $content);
    }

    public function test_forgot_password_page_has_links(): void
    {
        $content = file_get_contents(resource_path('views/auth/forgot-password.blade.php'));

        $this->assertStringContainsString('login', $content);
        $this->assertStringContainsString('Envoyer le lien', $content);
    }

    // Content Tests
    public function test_auth_pages_have_lyon_palme_header(): void
    {
        $pages = [
            'login.blade.php',
            'register.blade.php',
            'forgot-password.blade.php',
        ];

        foreach ($pages as $page) {
            $content = file_get_contents(resource_path("views/auth/$page"));
            $this->assertStringContainsString('Lyon Palme', $content);
        }
    }

    public function test_verify_email_page_has_special_buttons(): void
    {
        $content = file_get_contents(resource_path('views/auth/verify-email.blade.php'));

        $this->assertStringContainsString('Renvoyer le lien', $content);
        $this->assertStringContainsString('Se déconnecter', $content);
    }

    public function test_confirm_password_page_explains_action(): void
    {
        $content = file_get_contents(resource_path('views/auth/confirm-password.blade.php'));

        $this->assertStringContainsString('confirmation de sécurité', $content);
        $this->assertStringContainsString('type="password"', $content);
    }

    // Two-Factor Tests
    public function test_two_factor_page_has_code_and_recovery_fields(): void
    {
        $content = file_get_contents(resource_path('views/auth/two-factor-challenge.blade.php'));

        $this->assertStringContainsString('name="code"', $content);
        $this->assertStringContainsString('name="recovery_code"', $content);
        $this->assertStringContainsString('toggleRecovery()', $content);
    }

    public function test_two_factor_page_has_proper_input_attributes(): void
    {
        $content = file_get_contents(resource_path('views/auth/two-factor-challenge.blade.php'));

        // Code field should be numeric
        $this->assertStringContainsString('inputmode="numeric"', $content);
        $this->assertStringContainsString('maxlength="6"', $content);

        // Recovery section should be hidden by default
        $this->assertStringContainsString('class="hidden"', $content);
    }
}
