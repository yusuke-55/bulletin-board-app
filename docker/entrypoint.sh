#!/usr/bin/env sh
set -eu

cd /var/www/html

if [ -z "${APP_KEY:-}" ]; then
  echo "ERROR: APP_KEY is not set. Set APP_KEY in your Render environment variables." >&2
  exit 1
fi

# Render (and similar platforms) often require listening on $PORT.
if [ -n "${PORT:-}" ] && [ "${PORT}" != "80" ]; then
  sed -i "s/^Listen 80$/Listen ${PORT}/" /etc/apache2/ports.conf 2>/dev/null || true
  sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf 2>/dev/null || true
fi

# Ensure writable directories (POSIX sh compatible)
mkdir -p \
  storage/framework/cache \
  storage/framework/sessions \
  storage/framework/views \
  storage/framework/testing \
  storage/logs \
  bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache || true

# Ensure SQLite database file exists (for demo / ephemeral deployments)
mkdir -p database
if [ "${DB_CONNECTION:-sqlite}" = "sqlite" ]; then
  if [ -z "${DB_DATABASE:-}" ]; then
    DB_DATABASE="/var/www/html/database/database.sqlite"
    export DB_DATABASE
  fi
  if [ "${DB_DATABASE}" != ":memory:" ]; then
    mkdir -p "$(dirname "${DB_DATABASE}")" || true
    touch "${DB_DATABASE}" || true
    chown -R www-data:www-data "$(dirname "${DB_DATABASE}")" || true
  fi
fi

# Create storage symlink if missing
if [ ! -L public/storage ]; then
  php artisan storage:link || true
fi

# Generate package discovery cache (composer build uses --no-scripts)
php artisan package:discover --ansi

# Run migrations optionally (recommended for simple demos)
if [ "${RUN_MIGRATIONS:-true}" = "true" ]; then
  php artisan migrate --force
fi

exec apache2-foreground
