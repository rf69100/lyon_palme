#!/bin/sh
set -e

echo "▶ Attente de MariaDB..."
until php -r "new PDO('mysql:host=db;dbname=${DB_DATABASE}', '${DB_USERNAME}', '${DB_PASSWORD}');" 2>/dev/null; do
    echo "  MariaDB pas encore prêt, on attend 3s..."
    sleep 3
done
echo "✔ MariaDB accessible."

echo "▶ Génération du cache de config Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "▶ Migrations..."
php artisan migrate --force

echo "▶ Liens symboliques storage..."
php artisan storage:link || true

echo "✔ Laravel prêt — démarrage supervisord"
exec "$@"
