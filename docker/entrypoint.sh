#!/usr/bin/env bash
set -euo pipefail

cd /var/www/html

# Ensure writable directories
mkdir -p storage/framework/{cache,data,sessions,views} storage/logs bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache || true

# Create storage symlink if missing
if [ ! -L public/storage ]; then
  php artisan storage:link || true
fi

# Run migrations optionally (recommended for simple demos)
if [ "${RUN_MIGRATIONS:-true}" = "true" ]; then
  php artisan migrate --force
fi

exec apache2-foreground
