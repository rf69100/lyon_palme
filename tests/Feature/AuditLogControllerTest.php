<?php

use App\Models\Utilisateur;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('journaux audit accessibles a un administrateur', function () {
    $admin = Utilisateur::factory()->create(['email_verifie_le' => now()]);
    $this->grantAdminRole($admin);

    $this->actingAs($admin)->get(route('admin.audit.index'))
        ->assertOk()
        ->assertViewIs('admin.audit.index')
        ->assertViewHas('logs');
});

test('journaux audit interdits a un non administrateur', function () {
    $user = Utilisateur::factory()->create(['email_verifie_le' => now()]);

    $this->actingAs($user)->get(route('admin.audit.index'))->assertForbidden();
});
