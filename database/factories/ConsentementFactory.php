<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Consentement>
 */
class ConsentementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Types de consentements RGPD pour un club de plongée
        $typesConsentements = [
            'traitement_donnees_personnelles',
            'publication_photos',
            'envoi_newsletter',
            'partage_coordonnees_ffessm',
            'utilisation_image_mineur',
            'contact_partenaires',
            'statistiques_anonymes',
        ];

        $typeConsentement = fake()->randomElement($typesConsentements);

        $accorde = fake()->boolean(85); // 85% accordent le consentement

        $accordeLe = $accorde ? fake()->dateTimeBetween('-2 years', 'now') : null;
        $revoqueLe = ($accorde && fake()->boolean(5)) ? fake()->dateTimeBetween($accordeLe, 'now') : null;

        // Adresses IP françaises simulées
        $adresseIp = fake()->ipv4();

        $userAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.0 Mobile/15E148 Safari/604.1',
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:121.0) Gecko/20100101 Firefox/121.0',
        ];

        return [
            'type_consentement' => $typeConsentement,
            'accorde' => $accorde,
            'accorde_le' => $accordeLe,
            'revoque_le' => $revoqueLe,
            'adresse_ip' => $adresseIp,
            'agent_utilisateur' => fake()->randomElement($userAgents),
        ];
    }
}
