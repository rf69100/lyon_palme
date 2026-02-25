# ─────────────────────────────────────────────
# Stage 1 : Build des assets (Node / Vite)
# ─────────────────────────────────────────────
FROM node:22-alpine AS node-builder

WORKDIR /app

COPY package.json package-lock.json* ./
RUN npm ci --prefer-offline

COPY vite.config.js ./
COPY resources/ resources/
COPY public/ public/

RUN npm run build

# ─────────────────────────────────────────────
# Stage 2 : Image PHP / Laravel finale
# ─────────────────────────────────────────────
FROM php:8.2-fpm-alpine AS app

# --- Dépendances système ---
RUN apk add --no-cache \
    bash \
    curl \
    git \
    unzip \
    zip \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    icu-dev \
    oniguruma-dev \
    mariadb-client \
    supervisor

# --- Extensions PHP ---
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    mbstring \
    zip \
    exif \
    pcntl \
    bcmath \
    gd \
    intl \
    opcache

# --- Composer ---
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# --- Dépendances PHP (sans dev) ---
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-interaction --prefer-dist --optimize-autoloader

# --- Code source ---
COPY . .

# --- Assets buildés ---
COPY --from=node-builder /app/public/build public/build

# --- Permissions ---
RUN chown -R www-data:www-data /var/www/html \
 && chmod -R 755 /var/www/html/storage \
 && chmod -R 755 /var/www/html/bootstrap/cache

# --- Post-install Composer (sans interactivité) ---
RUN composer run-script post-autoload-dump --no-interaction || true

# --- Config PHP pour la production ---
COPY docker/php/php.ini /usr/local/etc/php/conf.d/app.ini

# --- Supervisord (php-fpm) ---
COPY docker/supervisor/supervisord.conf /etc/supervisord.conf

# --- Entrypoint ---
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh \
 && sed -i 's/\r$//' /entrypoint.sh

EXPOSE 9000

ENTRYPOINT ["/entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
