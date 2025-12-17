# Comptes de test - Lyon Palme

Ce fichier liste les comptes de test disponibles après avoir exécuté les seeders.

## 🔐 Comptes Administratifs

Tous les comptes utilisent le mot de passe: `password`

### 1. Admin (Super Administrateur)
- **Email**: `admin@lyonpalme.fr`
- **Mot de passe**: `password`
- **Rôles**: Président, Secrétaire, Trésorier
- **Dashboard**: Dashboard Secrétaire (administratif)
- **Description**: Compte avec tous les rôles administratifs

### 2. Président
- **Email**: `president@lyonpalme.fr`
- **Mot de passe**: `password`
- **Rôle**: Président
- **Dashboard**: Dashboard Secrétaire (administratif)
- **Description**: Président du club

### 3. Secrétaire
- **Email**: `secretaire@lyonpalme.fr`
- **Mot de passe**: `password`
- **Rôle**: Secrétaire
- **Dashboard**: Dashboard Secrétaire (administratif)
- **Description**: Secrétaire du club

### 4. Trésorier
- **Email**: `tresorier@lyonpalme.fr`
- **Mot de passe**: `password`
- **Rôle**: Trésorier
- **Dashboard**: Dashboard Secrétaire (administratif)
- **Description**: Trésorier du club

## 📝 Notes

- Les comptes administratifs (Président, Secrétaire, Trésorier) sont automatiquement redirigés vers le dashboard administratif après connexion
- Les adhérents sans rôle administratif voient le dashboard adhérent standard
- Pour réinitialiser les données de test: `php artisan migrate:fresh --seed`

## 🔄 Commandes utiles

```bash
# Réinitialiser la base de données et créer les données de test
php artisan migrate:fresh --seed

# Exécuter uniquement le seeder des rôles
php artisan db:seed --class=AdherentRoleSeeder

# Vérifier les rôles d'un utilisateur
php artisan tinker
$user = App\Models\Utilisateur::where('email', 'secretaire@lyonpalme.fr')->first();
$adherent = App\Models\Adherent::where('utilisateur_id', $user->id)->first();
$adherent->rolesActifs()->get();
$adherent->estAdministrateur(); // true ou false
```

## 🎯 Test de la redirection

1. Connectez-vous avec `secretaire@lyonpalme.fr` / `password`
2. Vous devriez être redirigé vers `/dashboard`
3. Le dashboard affiché doit être le **Dashboard Secrétaire** (vue administrative)
4. Vous devriez voir les statistiques du club, les adhérents récents, etc.

Si vous voyez le dashboard adhérent au lieu du dashboard secrétaire, vérifiez que:
- Le seeder `AdherentRoleSeeder` a bien été exécuté
- L'utilisateur a un profil adhérent associé
- Le rôle est bien actif dans la table `adherent_roles`
