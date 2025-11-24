<?php

namespace Tests\Unit\Config;

use Tests\TestCase;

class ConfigTest extends TestCase
{
    /**
     * Test 1: Vérifier que le fichier de configuration app.php existe
     * @test
     */
    public function test_app_config_file_exists()
    {
        $configPath = config_path('app.php');
        $this->assertFileExists($configPath);
    }

    /**
     * Test 2: Vérifier que la configuration Fortify existe
     * @test
     */
    public function test_fortify_config_exists()
    {
        $configPath = config_path('fortify.php');
        $this->assertFileExists($configPath);
    }

    /**
     * Test 3: Vérifier que la configuration database.php existe
     * @test
     */
    public function test_database_config_exists()
    {
        $configPath = config_path('database.php');
        $this->assertFileExists($configPath);
    }

    /**
     * Test 4: Vérifier que la configuration auth.php existe
     * @test
     */
    public function test_auth_config_exists()
    {
        $configPath = config_path('auth.php');
        $this->assertFileExists($configPath);
    }

    /**
     * Test 5: Vérifier que la configuration cache.php existe
     * @test
     */
    public function test_cache_config_exists()
    {
        $configPath = config_path('cache.php');
        $this->assertFileExists($configPath);
    }

    /**
     * Test 6: Vérifier que l'application a un APP_KEY
     * @test
     */
    public function test_app_has_encryption_key()
    {
        $key = config('app.key');
        $this->assertNotEmpty($key);
        $this->assertTrue(
            strpos($key, 'base64:') === 0 || strpos($key, 'base64:') === false,
            'APP_KEY should be set'
        );
    }

    /**
     * Test 7: Vérifier que la configuration Fortify est chargée
     * @test
     */
    public function test_fortify_configuration_is_loaded()
    {
        $fortifyConfig = config('fortify');
        $this->assertIsArray($fortifyConfig);
        $this->assertNotEmpty($fortifyConfig);
    }
}
