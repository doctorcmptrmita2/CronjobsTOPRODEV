#!/bin/sh
set -e

echo "🚀 Starting Cronjobs.to..."

# Wait for MySQL to be ready with timeout
echo "⏳ Waiting for MySQL at ${DB_HOST:-mysql}:${DB_PORT:-3306}..."
MAX_ATTEMPTS=60
ATTEMPT=0
while [ $ATTEMPT -lt $MAX_ATTEMPTS ]; do
    if nc -z ${DB_HOST:-mysql} ${DB_PORT:-3306} 2>/dev/null; then
        echo "✅ MySQL is ready!"
        break
    fi
    ATTEMPT=$((ATTEMPT + 1))
    if [ $ATTEMPT -eq $MAX_ATTEMPTS ]; then
        echo "❌ MySQL connection timeout after ${MAX_ATTEMPTS} attempts"
        exit 1
    fi
    echo "   Attempt $ATTEMPT/$MAX_ATTEMPTS - MySQL not ready yet, waiting..."
    sleep 2
done

# Run migrations if AUTO_MIGRATE is set
if [ "${AUTO_MIGRATE}" = "true" ]; then
    echo "📦 Running migrations..."
    php artisan migrate --force
fi

# Cache configuration in production
if [ "${APP_ENV}" = "production" ]; then
    echo "⚡ Caching configuration..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

# Create storage link if not exists
if [ ! -L "/var/www/html/public/storage" ]; then
    echo "🔗 Creating storage link..."
    php artisan storage:link
fi

# Set correct permissions
echo "🔒 Setting permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

echo "✅ Application ready!"

# Start supervisor
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf






