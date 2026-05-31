<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TwoFactorAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_two_factor_view_file_exists(): void
    {
        $this->assertTrue(
            file_exists(resource_path('views/auth/two-factor-challenge.blade.php')),
            'Two-factor challenge view file should exist'
        );
    }

    public function test_two_factor_view_contains_code_field(): void
    {
        $viewContent = file_get_contents(resource_path('views/auth/two-factor-challenge.blade.php'));

        $this->assertStringContainsString('inputmode="numeric"', $viewContent);
        $this->assertStringContainsString('name="code"', $viewContent);
        $this->assertStringContainsString('maxlength="6"', $viewContent);
    }

    public function test_two_factor_view_contains_recovery_code_field(): void
    {
        $viewContent = file_get_contents(resource_path('views/auth/two-factor-challenge.blade.php'));

        $this->assertStringContainsString('name="recovery_code"', $viewContent);
        $this->assertStringContainsString('id="recovery-section"', $viewContent);
    }

    public function test_two_factor_view_has_toggle_recovery_function(): void
    {
        $viewContent = file_get_contents(resource_path('views/auth/two-factor-challenge.blade.php'));

        $this->assertStringContainsString('function toggleRecovery()', $viewContent);
        $this->assertStringContainsString('toggleRecovery()', $viewContent);
    }

    public function test_two_factor_view_uses_tailwind_css(): void
    {
        $viewContent = file_get_contents(resource_path('views/auth/two-factor-challenge.blade.php'));

        $this->assertStringContainsString('bg-gradient-to-br', $viewContent);
        $this->assertStringContainsString('min-h-screen', $viewContent);
        $this->assertStringContainsString('rounded-lg', $viewContent);
    }

    public function test_two_factor_view_has_csrf_protection(): void
    {
        $viewContent = file_get_contents(resource_path('views/auth/two-factor-challenge.blade.php'));

        $this->assertStringContainsString('@csrf', $viewContent);
    }

    public function test_two_factor_view_has_form_method_post(): void
    {
        $viewContent = file_get_contents(resource_path('views/auth/two-factor-challenge.blade.php'));

        $this->assertStringContainsString('method="POST"', $viewContent);
        $this->assertStringContainsString('two-factor.login', $viewContent);
    }

    public function test_two_factor_recovery_code_hidden_by_default(): void
    {
        $viewContent = file_get_contents(resource_path('views/auth/two-factor-challenge.blade.php'));

        $this->assertStringContainsString('class="hidden"', $viewContent);
        $this->assertStringContainsString('id="recovery-section"', $viewContent);
    }

    public function test_two_factor_code_field_has_monospace_font(): void
    {
        $viewContent = file_get_contents(resource_path('views/auth/two-factor-challenge.blade.php'));

        $this->assertStringContainsString('font-mono', $viewContent);
    }

    public function test_two_factor_code_field_has_text_center(): void
    {
        $viewContent = file_get_contents(resource_path('views/auth/two-factor-challenge.blade.php'));

        $this->assertStringContainsString('text-center', $viewContent);
    }

    public function test_two_factor_code_placeholder_is_numeric(): void
    {
        $viewContent = file_get_contents(resource_path('views/auth/two-factor-challenge.blade.php'));

        $this->assertStringContainsString('placeholder="000000"', $viewContent);
    }

    public function test_two_factor_recovery_placeholder_format(): void
    {
        $viewContent = file_get_contents(resource_path('views/auth/two-factor-challenge.blade.php'));

        $this->assertStringContainsString('placeholder="XXXXXXXX-XXXXXXXX"', $viewContent);
    }

    public function test_two_factor_toggle_button_exists(): void
    {
        $viewContent = file_get_contents(resource_path('views/auth/two-factor-challenge.blade.php'));

        $this->assertStringContainsString('toggleRecovery()', $viewContent);
        $this->assertStringContainsString('toggle-text', $viewContent);
    }

    public function test_two_factor_submit_button_text(): void
    {
        $viewContent = file_get_contents(resource_path('views/auth/two-factor-challenge.blade.php'));

        $this->assertStringContainsString('Vérifier', $viewContent);
    }

    public function test_two_factor_javascript_is_present(): void
    {
        $viewContent = file_get_contents(resource_path('views/auth/two-factor-challenge.blade.php'));

        $this->assertStringContainsString('<script>', $viewContent);
        $this->assertStringContainsString('classList.contains', $viewContent);
        $this->assertStringContainsString('classList.remove', $viewContent);
        $this->assertStringContainsString('classList.add', $viewContent);
    }

    public function test_two_factor_code_section_label(): void
    {
        $viewContent = file_get_contents(resource_path('views/auth/two-factor-challenge.blade.php'));

        $this->assertStringContainsString("Code d'authentification", $viewContent);
    }

    public function test_two_factor_recovery_section_label(): void
    {
        $viewContent = file_get_contents(resource_path('views/auth/two-factor-challenge.blade.php'));

        $this->assertStringContainsString('Code de récupération', $viewContent);
    }

    public function test_two_factor_form_has_error_handling(): void
    {
        $viewContent = file_get_contents(resource_path('views/auth/two-factor-challenge.blade.php'));

        $this->assertStringContainsString('@error', $viewContent);
    }
}
