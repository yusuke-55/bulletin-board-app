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
FROM php:8.2-apache

# System deps + PHP extensions
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        ca-certificates \
        curl \
        git \
        libxml2-dev \
        libonig-dev \
        libzip-dev \
        unzip \
    && docker-php-ext-install \
        mbstring \
        pdo \
        pdo_sqlite \
        xml \
        zip \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Composer
COPY --from=composer_bin /usr/bin/composer /usr/local/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER=1

# App source
COPY . /var/www/html

# Diagnostics (helps Render build logs)
RUN php -v && php -m && composer --version

# Install PHP dependencies (scripts are deferred to runtime)
RUN composer install --no-dev --no-interaction --prefer-dist --no-progress --optimize-autoloader --no-scripts

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
