<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Utilisateur;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoutesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test 1: Vérifier que la route '/' retourne 'welcome' view
     * @test
     */
    public function test_home_route_returns_welcome_view()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('welcome');
    }

    /**
     * Test 2: Vérifier que la route '/dashboard' redirige vers login si non authentifié
     * @test
     */
    public function test_dashboard_route_redirects_to_login_if_not_authenticated()
    {
        $response = $this->get('/dashboard');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Test 3: Vérifier que la route '/dashboard' retourne 200 avec un utilisateur vérifié
     * @test
     */
    public function test_dashboard_route_accessible_with_verified_user()
    {
        $user = Utilisateur::factory()->create([
            'email_verifie_le' => now(),
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertViewIs('dashboard');
    }

    /**
     * Test 4: Vérifier que la route '/dashboard' affiche 'dashboard' view pour un utilisateur authentifié et vérifié
     * @test
     */
    public function test_dashboard_route_returns_dashboard_view_for_authenticated_verified_user()
    {
        $user = Utilisateur::factory()->create([
            'email_verifie_le' => now(),
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertViewIs('dashboard');
    }

    /**
     * Test 5: Vérifier que la configuration Fortify est présente dans config/fortify.php
     * @test
     */
    public function test_fortify_is_configured_in_application()
    {
        // Vérifier que le fichier de configuration Fortify existe
        $this->assertTrue(
            file_exists(config_path('fortify.php')),
            'config/fortify.php should exist'
        );

        // Vérifier que la configuration Fortify a des paramètres
        $fortifyConfig = config('fortify');
        $this->assertIsArray($fortifyConfig);

        // Vérifier que la page welcome est accessible (route publique)
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewIs('welcome');
    }
}
