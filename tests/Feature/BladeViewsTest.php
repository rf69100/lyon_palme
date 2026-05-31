<?php

namespace Tests\Feature;

use App\Models\Utilisateur;
use Tests\TestCase;

class BladeViewsTest extends TestCase
{
    /**
     * Test 1: Vérifier que la vue index se charge
     *
     * @test
     */
    public function test_welcome_view_loads()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewIs('index');
    }

    /**
     * Test 2: Vérifier que le dashboard se charge pour utilisateur authentifié
     *
     * @test
     */
    public function test_dashboard_view_loads_for_authenticated_user()
    {
        $user = Utilisateur::factory()->create([
            'email_verifie_le' => now(),
        ]);

        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
        // Dashboard can be dashboard.adherent or dashboard.secretary depending on roles
        $this->assertTrue(
            in_array($response->original->getName(), ['dashboard.adherent', 'dashboard.secretary']),
            'Dashboard should display role-based view'
        );
    }

    /**
     * Test 3: Vérifier que le dashboard redirige vers login si non authentifié
     *
     * @test
     */
    public function test_dashboard_redirects_to_login_if_not_authenticated()
    {
        $response = $this->get('/dashboard');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Test 4: Vérifier que le layout app.blade.php existe
     *
     * @test
     */
    public function test_app_layout_exists()
    {
        $layoutPath = resource_path('views/layouts/app.blade.php');
        $this->assertFileExists($layoutPath);
    }

    /**
     * Test 5: Vérifier que le layout auth.blade.php existe
     *
     * @test
     */
    public function test_auth_layout_exists()
    {
        $layoutPath = resource_path('views/layouts/auth.blade.php');
        $this->assertFileExists($layoutPath);
    }

    /**
     * Test 6: Vérifier que les utilisateurs non authentifiés voient la page welcome
     *
     * @test
     */
    public function test_unauthenticated_users_see_welcome_page()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewIs('index');
    }

    /**
     * Test 7: Vérifier que la vue dashboard existe pour utilisateur authentifié
     *
     * @test
     */
    public function test_dashboard_exists_and_is_accessible()
    {
        $user = Utilisateur::factory()->create([
            'email_verifie_le' => now(),
        ]);

        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
    }

    /**
     * Test 8: Vérifier que les utilisateurs authentifiés ne sont pas redirigés
     *
     * @test
     */
    public function test_authenticated_users_are_not_redirected_from_dashboard()
    {
        $user = Utilisateur::factory()->create([
            'email_verifie_le' => now(),
        ]);

        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
        $this->assertTrue($response->status() === 200);
    }

    /**
     * Test 9: Vérifier que la page d'accueil contient HTML
     *
     * @test
     */
    public function test_welcome_page_contains_html()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $content = $response->getContent();
        $this->assertStringContainsString('<html', $content);
    }

    /**
     * Test 10: Vérifier que le middleware d'authentification fonctionne
     *
     * @test
     */
    public function test_auth_middleware_redirects_unauthenticated_users()
    {
        // Vérifier que les routes protégées redirigent
        $response = $this->get('/dashboard');
        $this->assertTrue($response->status() === 302 || $response->status() === 307);
    }

    /**
     * Test 11: Vérifier que les utilisateurs vérifiés accèdent au dashboard
     *
     * @test
     */
    public function test_verified_users_access_dashboard()
    {
        $user = Utilisateur::factory()->create([
            'email_verifie_le' => now(),
        ]);

        $response = $this->actingAs($user)->get('/dashboard');
        $this->assertEquals(200, $response->status());
    }

    /**
     * Test 12: Vérifier que la page welcome est publique
     *
     * @test
     */
    public function test_welcome_page_is_public()
    {
        $response = $this->get('/');
        $this->assertNotEquals(302, $response->status());
        $this->assertEquals(200, $response->status());
    }

    /**
     * Test 13: Vérifier que le layout app existe
     *
     * @test
     */
    public function test_app_layout_file_exists()
    {
        $this->assertFileExists(resource_path('views/layouts/app.blade.php'));
    }

    /**
     * Test 14: Vérifier que le layout auth existe
     *
     * @test
     */
    public function test_auth_layout_file_exists()
    {
        $this->assertFileExists(resource_path('views/layouts/auth.blade.php'));
    }

    /**
     * Test 15: Vérifier que la vue index existe
     *
     * @test
     */
    public function test_welcome_view_file_exists()
    {
        $this->assertFileExists(resource_path('views/index.blade.php'));
    }
}
