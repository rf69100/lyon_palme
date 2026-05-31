<?php

namespace Tests;

use App\Models\Adherent;
use App\Models\AdherentRole;
use App\Models\Role;
use App\Models\Utilisateur;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Donne un rôle administratif (Secrétaire) à un utilisateur afin qu'il
     * puisse accéder aux routes /admin/*. Crée l'adhérent associé si besoin.
     */
    protected function grantAdminRole(Utilisateur $utilisateur): Utilisateur
    {
        $adherent = $utilisateur->adherent()->first()
            ?? Adherent::factory()->create(['utilisateur_id' => $utilisateur->id]);

        $role = Role::firstOrCreate(
            ['nom' => Role::SECRETAIRE],
            ['nom_affichage' => 'Secrétaire', 'description' => 'Secrétaire du club']
        );

        AdherentRole::firstOrCreate(
            ['adherent_id' => $adherent->id, 'role_id' => $role->id],
            ['attribue_le' => now(), 'est_actif' => true]
        );

        return $utilisateur->refresh();
    }
}
