<?php

namespace Tests\Feature;

use App\Models\Utilisateur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_is_accessible(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $this->assertStringContainsString('Se connecter', $response->getContent());
        $this->assertStringContainsString('type="email"', $response->getContent());
        $this->assertStringContainsString('type="password"', $response->getContent());
    }

    public function test_register_page_is_accessible(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $this->assertStringContainsString("S'inscrire", $response->getContent());
        $this->assertStringContainsString('name="nom"', $response->getContent());
        $this->assertStringContainsString('name="email"', $response->getContent());
    }

    public function test_forgot_password_page_is_accessible(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
        $this->assertStringContainsString('Mot de passe oublié', $response->getContent());
        $this->assertStringContainsString('type="email"', $response->getContent());
    }

    public function test_login_page_has_remember_me_checkbox(): void
    {
        $response = $this->get('/login');

        $this->assertStringContainsString('remember', $response->getContent());
        $this->assertStringContainsString('Se souvenir de moi', $response->getContent());
    }

    public function test_login_page_has_forgot_password_link(): void
    {
        $response = $this->get('/login');

        $this->assertStringContainsString('Mot de passe oublié', $response->getContent());
    }

    public function test_login_page_has_register_link(): void
    {
        $response = $this->get('/login');

        $this->assertStringContainsString("S'inscrire", $response->getContent());
    }

    public function test_register_page_has_login_link(): void
    {
        $response = $this->get('/register');

        $this->assertStringContainsString('Se connecter', $response->getContent());
    }

    public function test_forgot_password_page_has_login_link(): void
    {
        $response = $this->get('/forgot-password');

        $this->assertStringContainsString('Retour à la connexion', $response->getContent());
    }

    public function test_auth_layout_includes_tailwind(): void
    {
        $response = $this->get('/login');

        // Layout should include Tailwind CDN
        $this->assertStringContainsString('tailwind', $response->getContent());
    }

    public function test_auth_layout_loads_tailwind_css(): void
    {
        $response = $this->get('/login');

        $this->assertStringContainsString('cdn.tailwindcss.com', $response->getContent());
    }

    public function test_auth_pages_include_inter_font(): void
    {
        $response = $this->get('/login');

        $this->assertStringContainsString('bunny.net', $response->getContent());
        $this->assertStringContainsString('Inter', $response->getContent());
    }

    public function test_login_page_title_correct(): void
    {
        $response = $this->get('/login');

        $this->assertStringContainsString('Connexion - Lyon Palme</title>', $response->getContent());
    }

    public function test_register_page_title_correct(): void
    {
        $response = $this->get('/register');

        $this->assertStringContainsString('Inscription - Lyon Palme</title>', $response->getContent());
    }

    public function test_forgot_password_page_title_correct(): void
    {
        $response = $this->get('/forgot-password');

        $this->assertStringContainsString('Mot de passe oublié - Lyon Palme</title>', $response->getContent());
    }

    public function test_register_page_has_password_confirmation_field(): void
    {
        $response = $this->get('/register');

        $this->assertStringContainsString('password_confirmation', $response->getContent());
    }

    public function test_auth_pages_have_csrf_protection(): void
    {
        $pages = ['/login', '/register', '/forgot-password'];

        foreach ($pages as $page) {
            $response = $this->get($page);

            // Either should have @csrf directive or hidden csrf token
            $hasProtection = (
                str_contains($response->getContent(), '@csrf') ||
                str_contains($response->getContent(), 'name="_token"') ||
                str_contains($response->getContent(), 'csrf-token')
            );

            $this->assertTrue($hasProtection, "Page $page should have CSRF protection");
        }
    }

    public function test_register_page_has_nom_field(): void
    {
        $response = $this->get('/register');

        $this->assertStringContainsString('name="nom"', $response->getContent());
        $this->assertStringContainsString('Nom complet', $response->getContent());
    }

    public function test_auth_pages_have_form_elements(): void
    {
        $pages = ['/login', '/register', '/forgot-password'];

        foreach ($pages as $page) {
            $response = $this->get($page);

            // All auth pages should have forms
            $this->assertStringContainsString('form', $response->getContent(),
                "Page $page should have a form element");
        }
    }

    public function test_login_page_has_submit_button(): void
    {
        $response = $this->get('/login');

        $this->assertStringContainsString('Se connecter', $response->getContent());
        $this->assertStringContainsString('type="submit"', $response->getContent());
    }

    public function test_register_page_has_submit_button(): void
    {
        $response = $this->get('/register');

        $this->assertStringContainsString("S'inscrire", $response->getContent());
        $this->assertStringContainsString('type="submit"', $response->getContent());
    }

    public function test_forgot_password_page_has_submit_button(): void
    {
        $response = $this->get('/forgot-password');

        $this->assertStringContainsString('Envoyer le lien', $response->getContent());
        $this->assertStringContainsString('type="submit"', $response->getContent());
    }

    public function test_dashboard_redirects_unauthenticated_to_login(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_dashboard_is_accessible_for_authenticated_user(): void
    {
        $user = Utilisateur::factory()->create([
            'email_verifie_le' => now(),
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
    }

    public function test_home_page_is_public(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $this->assertStringContainsString('Lyon Palme', $response->getContent());
    }
}
