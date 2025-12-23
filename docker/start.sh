#!/bin/sh
set -e

echo "🚀 Starting Cronjobs.to Application..."

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

# Wait for MySQL to accept connections
echo "⏳ Waiting for MySQL to accept connections..."
MAX_ATTEMPTS=30
ATTEMPT=0
while [ $ATTEMPT -lt $MAX_ATTEMPTS ]; do
    if php -r "try { new PDO('mysql:host=${DB_HOST:-mysql};port=${DB_PORT:-3306}', '${DB_USERNAME:-cronjobs}', '${DB_PASSWORD}'); echo 'Connected'; exit(0); } catch (Exception \$e) { exit(1); }" 2>/dev/null; then
        echo "✅ MySQL connection established!"
        break
    fi
    ATTEMPT=$((ATTEMPT + 1))
    if [ $ATTEMPT -eq $MAX_ATTEMPTS ]; then
        echo "⚠️  MySQL connection check failed, but continuing..."
    else
        echo "   Attempt $ATTEMPT/$MAX_ATTEMPTS - Testing MySQL connection..."
        sleep 2
    fi
done

# Set correct permissions first
echo "🔒 Setting permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Create storage link if not exists
if [ ! -L "/var/www/html/public/storage" ]; then
    echo "🔗 Creating storage link..."
    php artisan storage:link || echo "⚠️  Storage link already exists or failed"
fi

# Clear all caches before operations
echo "🧹 Clearing caches..."
php artisan config:clear || true
php artisan cache:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Run migrations if AUTO_MIGRATE is set
if [ "${AUTO_MIGRATE}" = "true" ]; then
    echo "📦 Running database migrations..."
    php artisan migrate --force || {
        echo "⚠️  Migration failed, but continuing..."
    }
fi

# Run seeders if AUTO_SEED is set
if [ "${AUTO_SEED}" = "true" ]; then
    echo "🌱 Running database seeders..."
    php artisan db:seed --force || {
        echo "⚠️  Seeding failed, but continuing..."
    }
fi

# Cache configuration in production
if [ "${APP_ENV}" = "production" ]; then
    echo "⚡ Caching configuration for production..."
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
fi

# Optimize Laravel
echo "⚡ Optimizing Laravel..."
php artisan optimize || true

echo "✅ Application ready! Starting services..."

# Start supervisor
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf






