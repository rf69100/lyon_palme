<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $typesDocuments = [
            'certificat_medical',
            'certification_plongee',
            'piece_identite',
            'justificatif_domicile',
            'autorisation_parentale',
            'attestation_assurance',
            'photo_identite',
            'programme_entrainement',
            'compte_rendu_sortie',
        ];

        $typeDocument = fake()->randomElement($typesDocuments);

        $extensions = ['pdf', 'pdf', 'pdf', 'jpg', 'png'];
        $extension = fake()->randomElement($extensions);

        $nomOriginal = fake()->slug(3) . '_' . $typeDocument . '.' . $extension;
        $nomStocke = fake()->uuid() . '.' . $extension;
        $chemin = 'documents/' . date('Y/m');

        $typesMime = [
            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
        ];

        $tailleFichier = fake()->numberBetween(50000, 5000000); // 50KB à 5MB

        return [
            'type_documentable' => 'App\\Models\\' . fake()->randomElement(['Adherent', 'CertificatMedical', 'Certification', 'ProgrammeEntrainement']),
            'id_documentable' => fake()->numberBetween(1, 100),
            'type_document' => $typeDocument,
            'nom_fichier_original' => $nomOriginal,
            'nom_fichier_stocke' => $nomStocke,
            'chemin_fichier' => $chemin . '/' . $nomStocke,
            'hash_fichier' => hash('sha256', $nomStocke),
            'type_mime' => $typesMime[$extension],
            'taille_fichier' => $tailleFichier,
            'disque_stockage' => 'local',
            'version' => fake()->numberBetween(1, 3),
            'est_archive' => fake()->boolean(10), // 10% archivés
        ];
    }
}
