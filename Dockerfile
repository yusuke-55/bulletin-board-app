# ---- Node build stage (Vite) ----
FROM node:20-alpine AS node_build
WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY resources ./resources
COPY vite.config.js ./vite.config.js
COPY public ./public

RUN npm run build

# ---- Composer binary stage ----
FROM composer:2 AS composer_bin

# ---- Runtime (Apache + PHP) ----
FROM php:8.4-apache

# System deps
RUN set -eux; \
    apt-get update; \
    apt-get install -y --no-install-recommends \
        $PHPIZE_DEPS \
        ca-certificates \
        curl \
        git \
        libcurl4-openssl-dev \
        libonig-dev \
        libsqlite3-dev \
        libxml2-dev \
        libzip-dev \
        zlib1g-dev \
        unzip; \
    rm -rf /var/lib/apt/lists/*

# PHP extensions
RUN set -eux; \
    docker-php-ext-install curl; \
    docker-php-ext-install mbstring; \
    docker-php-ext-install pdo; \
    docker-php-ext-install pdo_sqlite; \
    docker-php-ext-install xml; \
    docker-php-ext-install zip; \
    a2enmod rewrite

WORKDIR /var/www/html

# Composer
COPY --from=composer_bin /usr/bin/composer /usr/local/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_MEMORY_LIMIT=-1 \
    COMPOSER_PROCESS_TIMEOUT=0

# App source
COPY . /var/www/html

# Diagnostics (helps Render build logs)
RUN php -v && php -m && composer --version

# Composer diagnostics (helps Render build logs)
RUN composer diagnose || true

# Install PHP dependencies (scripts are deferred to runtime)
RUN set -eux; \
    composer install --no-dev --no-interaction --prefer-dist --no-progress --optimize-autoloader --no-scripts -vvv

# Built assets
COPY --from=node_build /app/public/build /var/www/html/public/build

# Apache vhost
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true

# Entrypoint
COPY docker/entrypoint.sh /usr/local/bin/entrypoint
RUN chmod +x /usr/local/bin/entrypoint

ENV APP_ENV=production \
    APP_DEBUG=false \
    LOG_CHANNEL=stderr \
    RUN_MIGRATIONS=true

EXPOSE 80

ENTRYPOINT ["entrypoint"]
