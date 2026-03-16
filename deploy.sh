#!/bin/bash
# =============================================================================
# deploy.sh — Déploiement Lyon Palme sur VPS OVH Ubuntu
# Usage : ./deploy.sh
# =============================================================================
set -e

REPO_URL="https://github.com/VOTRE_USER/VOTRE_REPO.git"  # ← à changer
APP_DIR="/var/www/lyon_palme"
DOMAIN="votre-domaine.com"                                 # ← à changer
EMAIL="votre@email.com"                                    # ← à changer (certbot)

GREEN="\033[0;32m"
YELLOW="\033[1;33m"
RED="\033[0;31m"
NC="\033[0m"

info()    { echo -e "${GREEN}▶ $1${NC}"; }
warning() { echo -e "${YELLOW}⚠ $1${NC}"; }
error()   { echo -e "${RED}✖ $1${NC}"; exit 1; }

# ── 1. Vérification root ────────────────────────────────────────────────────
[[ $EUID -ne 0 ]] && error "Ce script doit être lancé en root (sudo ./deploy.sh)"

# ── 2. Installation Docker ──────────────────────────────────────────────────
info "Installation de Docker..."
if ! command -v docker &>/dev/null; then
    apt-get update -qq
    apt-get install -y ca-certificates curl gnupg lsb-release
    install -m 0755 -d /etc/apt/keyrings
    curl -fsSL https://download.docker.com/linux/ubuntu/gpg \
        | gpg --dearmor -o /etc/apt/keyrings/docker.gpg
    echo "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] \
https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable" \
        > /etc/apt/sources.list.d/docker.list
    apt-get update -qq
    apt-get install -y docker-ce docker-ce-cli containerd.io docker-compose-plugin
    systemctl enable --now docker
    info "Docker installé ✔"
else
    info "Docker déjà installé ✔"
fi

# ── 3. Récupération du code ─────────────────────────────────────────────────
info "Récupération du code source..."
if [ -d "$APP_DIR/.git" ]; then
    cd "$APP_DIR"
    git pull origin main
else
    git clone "$REPO_URL" "$APP_DIR"
    cd "$APP_DIR"
fi

# ── 4. Vérification .env.production ─────────────────────────────────────────
if [ ! -f "$APP_DIR/.env.production" ]; then
    error ".env.production introuvable dans $APP_DIR — copiez-le manuellement sur le serveur."
fi

# ── 5. Génération APP_KEY si nécessaire ─────────────────────────────────────
if grep -q "CHANGEME" "$APP_DIR/.env.production"; then
    warning "Génération de APP_KEY..."
    NEW_KEY=$(docker run --rm php:8.2-alpine php -r "echo 'base64:'.base64_encode(random_bytes(32));")
    sed -i "s|APP_KEY=.*|APP_KEY=$NEW_KEY|" "$APP_DIR/.env.production"
    info "APP_KEY générée ✔"
fi

# ── 6. Mise à jour du domaine dans nginx ────────────────────────────────────
info "Configuration du domaine $DOMAIN dans nginx..."
sed -i "s/votre-domaine.com/$DOMAIN/g" "$APP_DIR/docker/nginx/default.conf"

# ── 7. Build & démarrage des containers ─────────────────────────────────────
info "Build de l'image Docker..."
cd "$APP_DIR"
docker compose build --no-cache

info "Démarrage des containers..."
docker compose up -d

# ── 8. Certificat SSL Let's Encrypt (premier lancement) ─────────────────────
info "Obtention du certificat SSL..."
sleep 5  # attendre que nginx soit prêt

docker compose run --rm certbot certbot certonly \
    --webroot \
    -w /var/www/certbot \
    -d "$DOMAIN" \
    --email "$EMAIL" \
    --agree-tos \
    --no-eff-email \
    --non-interactive || warning "Certbot a échoué — vérifiez que $DOMAIN pointe vers ce serveur."

info "Rechargement nginx..."
docker compose exec nginx nginx -s reload || true

# ── 9. Résumé ────────────────────────────────────────────────────────────────
echo ""
echo -e "${GREEN}══════════════════════════════════════════${NC}"
echo -e "${GREEN}  ✔ Déploiement terminé !                 ${NC}"
echo -e "${GREEN}  → https://$DOMAIN                       ${NC}"
echo -e "${GREEN}══════════════════════════════════════════${NC}"
echo ""
echo "Commandes utiles :"
echo "  docker compose logs -f app       # logs Laravel"
echo "  docker compose logs -f nginx     # logs Nginx"
echo "  docker compose exec app php artisan tinker"
echo "  docker compose down              # arrêter"
echo "  docker compose up -d             # redémarrer"
