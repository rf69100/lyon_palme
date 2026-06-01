# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project scope

Member-management web app for the **Lyon Palme** finned-swimming club. Built for a BTS SIO student project (delivery 27 Apr 2025). The full backlog **US1–US18 is now in scope and implemented**:
- **Sécurité (US1–US3):** CNIL password policy, audit trail, RGPD (AES field encryption + consents).
- **Secrétaire (US4–US11):** login, password change, member CRUD (with rôles, représentant légal for minors, RGPD consents, medical-certificate PDF upload/download), archiving, medical-certificate dashboard, cotisations + paiements.
- **Nageur (US12–US18):** login (Fortify) + account creation by the secretary (`AdherentController@createAccount`, initial password = birthdate YYYYMMDD), forgot/reset password (Fortify), self-service profile (`MonProfilController`, `/mon-profil`), trombinoscope/annuaire opt-in toggles (`adherents.afficher_trombinoscope`/`afficher_annuaire`), and the trombinoscope (`/trombinoscope`) + annuaire (`/annuaire`) listings.

The planning/sorties/compétitions/matériel modules remain **out of scope** — those models/tables exist but are not part of the deliverable. `init.txt` holds the original planning doc, but its "TODO" states are stale — trust the code.

The full product backlog, business rules, and phased plan live in `init.txt` (a 41 KB planning document). Consult it for requirements detail; do not treat its "TODO" lists as current state — check the code, several items (US10/US11 controllers, exports, paiements) are already implemented.

## Commands

```bash
composer dev          # Run server + queue + pail logs + vite concurrently (main dev loop)
php artisan serve     # Server only
npm run dev           # Vite hot reload only

composer test         # Clears config cache, then runs the full Pest suite
php artisan test                                   # All tests
php artisan test --filter=AdherentControllerTest   # Single test file/name
php artisan test tests/Feature/EncryptionTest.php  # Single file by path

./vendor/bin/pint     # Format to PSR-12 (run before committing)

php artisan migrate:fresh --seed   # Reset DB + seed test data (~100 adherents + test accounts)
php artisan db:seed                # Seed only
```

## Database & test environment

- **DB is MariaDB** (`DB_CONNECTION=mariadb`, database `lyonpalme`). PostgreSQL is a CDC target but not yet used.
- **Tests run against the real database, not SQLite.** `phpunit.xml` points the test connection at the same `lyonpalme` MariaDB DB, and `RefreshDatabase` is **commented out** in `tests/Pest.php`. Tests rely on seeded data and existing rows — they are not hermetic. Be careful: a destructive test or `migrate:fresh` affects the working database. Run `migrate:fresh --seed` to restore a known state.
- Test login accounts (password `password` for all): `admin@lyonpalme.fr`, `president@lyonpalme.fr`, `secretaire@lyonpalme.fr`, `tresorier@lyonpalme.fr`. Full list in `COMPTES_TEST.md`.

## Architecture

**Stack:** Laravel 12 / PHP 8.4 / Tailwind CSS 4 (via `@tailwindcss/vite`) / Blade / Vite 7. Auth via Laravel Fortify; roles via Spatie Permission; Excel via maatwebsite/excel; photos via spatie/medialibrary.

**French-first naming.** Tables, models, controllers, routes, and columns are in French (`adherents`, `Adherent`, `AdherentController`, `/admin/adherents`). Timestamps are `cree_le` / `modifie_le`, not `created_at` / `updated_at` — most models override `CREATED_AT`/`UPDATED_AT` constants. Match this when adding code.

### Authentication is non-standard — read before touching auth

- The user model is `App\Models\Utilisateur` (table `utilisateurs`), **not** the default `User`. Password column is `mot_de_passe`, remember token is `jeton_souvenir` — overridden via `getAuthPasswordName()` / `getRememberTokenName()`.
- `FortifyServiceProvider::boot()` defines a **custom `Fortify::authenticateUsing`** closure (looks up by `email`, checks `Hash::check($password, $user->mot_de_passe)`) and registers all Fortify views + the `login` rate limiter (5/min). All Fortify Action classes live in `app/Actions/Fortify/`.
- A `Utilisateur` is linked to an `Adherent` via `adherents.utilisateur_id`. Authorization checks go through the **adherent's** roles, not the user's: `$adherent->estAdministrateur()` returns true for Secrétaire / Président / Trésorier (see `Role` constants).
- `DashboardController@index` branches on `$adherent->estAdministrateur()` to render either the secretary dashboard or the personal adherent dashboard.

### Field-level encryption (RGPD) — the central pattern

Sensitive columns are **encrypted at rest with AES-256** via the `App\Traits\EncryptsAttributes` trait. A model lists encrypted columns in `protected $encryptable = [...]` (e.g. `Adherent` encrypts name, email, phone, full address, emergency contact; `RepresentantLegal` similar). The trait transparently encrypts on `setAttribute` and decrypts on `getAttribute`/`attributesToArray`.

Consequences to keep in mind:
- **You cannot `WHERE` or `ORDER BY` an encrypted column** in SQL — every row is a different ciphertext. For names, the trait auto-maintains SHA-256 hash columns (`nom_recherche`, `prenom_recherche`, `nom_complet_recherche`) for exact-match lookups; use `Adherent::rechercherParNom()` / `rechercherParNomComplet()`, not `where('nom', ...)`.
- Encrypted dates (e.g. `date_naissance`) **cannot use Eloquent date casts** — they're stored as encrypted strings and parsed manually.
- The trait tolerates legacy plaintext (decrypt failure returns the raw value), so don't assume a column is always ciphertext.

### Security services & middleware

Reusable static services in `app/Services/`:
- `AuditService` — write to `audit_logs`; call `AuditService::log/logCreate/logUpdate/logDelete/logLogin/...` on every sensitive action (create/update/archive). This is a graded requirement, not optional.
- `PasswordPolicyService` — CNIL policy (12+ chars, complexity, 90-day expiry).
- `InputSanitizationService`, `FileSecurityService`, `RGPDComplianceService`.

Custom middleware in `app/Http/Middleware/`: `LogAuditTrail` (alias `audit.trail`, applied to all authenticated routes), `EnforceAuthorization`, `SecureSessionHeaders`, `ThrottleLoginAttempts`, `PreventApiAbuse` (export rate limit). All protected routes use `['auth', 'verified', 'audit.trail']`; admin routes are under the `admin.` name prefix in `routes/web.php`.

### Request flow for member management

`routes/web.php` → `admin/*` group → `AdherentController` (resource + `restore`), `CertificatMedicalController` (US10, with `export`), `AdhesionController` (US11 cotisations, with `export`), `PaiementController` (add payment to an adhesion). Validation lives in `app/Http/Requests/` (`StoreAdherentRequest`, `UpdateAdherentRequest`, `StorePaiementRequest`). Excel exports are in `app/Exports/`. Membership balance: `adhesions.solde` is a generated column (`montant_total − montant_paye`); don't set it manually.

## Conventions

- PHP 8 constructor property promotion, explicit return types, curly braces always.
- Pest 4 for tests (`tests/Feature`, `tests/Unit`); Pint (PSR-12) before commits.
- Tailwind 4 utility classes; club palette violet `#5B4B8A` + cyan `#5DD9D2`, gradients `from-purple-600 to-cyan-500`. Layouts: `layouts.public`, `layouts.app`, `layouts.auth`.
- Never call `env()` outside `config/`. Validate input via Form Requests. Audit every sensitive mutation.

### Middleware registration

All middleware aliases are registered in `bootstrap/app.php` (Laravel 12 — no `Kernel.php`). The relevant aliases for this project:

| Alias | Class | Purpose |
|---|---|---|
| `audit.trail` | `LogAuditTrail` | Logs every authenticated HTTP request |
| `admin` | `EnsureUserIsAdmin` | Guards `admin.*` routes to administrative roles only |
| `throttle.login` | `ThrottleLoginAttempts` | Brute-force protection on login |
| `api.abuse` | `PreventApiAbuse` | Rate-limits Excel exports (10/hour) |

### Route structure

```
/                          → public landing page
/admin/*   (name: admin.)  → admin middleware + auth/verified/audit.trail
  adherents                → AdherentController (resource + restore + createAccount)
  certificats-medicaux     → CertificatMedicalController (index, export, download)
  cotisations              → AdhesionController (index, export)
  adhesions/{id}/paiements → PaiementController (create, store)
  journaux-audit           → AuditLogController
/mon-profil                → MonProfilController (nageur self-service)
/trombinoscope             → TrombinoscopeController
/annuaire                  → AnnuaireController
```
