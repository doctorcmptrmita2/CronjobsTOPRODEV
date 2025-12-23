#!/bin/sh
# 🔧 EasyPanel Troubleshooting Script
# Bu script, 500 hatası ve diğer sorunları tespit eder ve düzeltir

set -e

echo "🔧 Troubleshooting başlatılıyor..."
echo ""

# Renkler
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m'

# 1. APP_KEY kontrolü
echo "1️⃣  APP_KEY kontrol ediliyor..."
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    echo -e "${RED}❌ APP_KEY eksik!${NC}"
    echo "   Çözüm: php artisan key:generate --force"
    php artisan key:generate --force
    echo -e "${GREEN}✅ APP_KEY oluşturuldu${NC}"
else
    echo -e "${GREEN}✅ APP_KEY mevcut${NC}"
fi

# 2. Veritabanı bağlantı kontrolü
echo ""
echo "2️⃣  Veritabanı bağlantısı kontrol ediliyor..."
if php artisan db:show 2>/dev/null; then
    echo -e "${GREEN}✅ Veritabanı bağlantısı başarılı${NC}"
else
    echo -e "${RED}❌ Veritabanı bağlantı hatası!${NC}"
    echo "   Kontrol edilecekler:"
    echo "   - DB_HOST=${DB_HOST:-mysql}"
    echo "   - DB_DATABASE=${DB_DATABASE:-cronjobs}"
    echo "   - DB_USERNAME=${DB_USERNAME:-cronjobs}"
    echo "   - DB_PASSWORD ayarlı mı?"
fi

# 3. Migration kontrolü
echo ""
echo "3️⃣  Migration durumu kontrol ediliyor..."
PENDING=$(php artisan migrate:status 2>/dev/null | grep -c "Pending" || echo "0")
if [ "$PENDING" != "0" ]; then
    echo -e "${YELLOW}⚠️  Bekleyen migration'lar var: $PENDING${NC}"
    echo "   Çözüm: php artisan migrate --force"
    php artisan migrate --force || echo "   Migration hatası!"
else
    echo -e "${GREEN}✅ Tüm migration'lar çalıştırılmış${NC}"
fi

# 4. Storage permissions
echo ""
echo "4️⃣  Storage izinleri kontrol ediliyor..."
if [ -w "storage" ] && [ -w "bootstrap/cache" ]; then
    echo -e "${GREEN}✅ Storage izinleri OK${NC}"
else
    echo -e "${YELLOW}⚠️  Storage izinleri düzeltiliyor...${NC}"
    chown -R www-data:www-data storage bootstrap/cache
    chmod -R 775 storage bootstrap/cache
    echo -e "${GREEN}✅ Storage izinleri düzeltildi${NC}"
fi

# 5. Storage link
echo ""
echo "5️⃣  Storage link kontrol ediliyor..."
if [ ! -L "public/storage" ]; then
    echo -e "${YELLOW}⚠️  Storage link eksik, oluşturuluyor...${NC}"
    php artisan storage:link
    echo -e "${GREEN}✅ Storage link oluşturuldu${NC}"
else
    echo -e "${GREEN}✅ Storage link mevcut${NC}"
fi

# 6. Cache temizleme
echo ""
echo "6️⃣  Cache'ler temizleniyor..."
php artisan config:clear || true
php artisan cache:clear || true
php artisan route:clear || true
php artisan view:clear || true
echo -e "${GREEN}✅ Cache'ler temizlendi${NC}"

# 7. Production cache
if [ "${APP_ENV}" = "production" ]; then
    echo ""
    echo "7️⃣  Production cache oluşturuluyor..."
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
    echo -e "${GREEN}✅ Production cache oluşturuldu${NC}"
fi

# 8. Log kontrolü
echo ""
echo "8️⃣  Son hatalar kontrol ediliyor..."
if [ -f "storage/logs/laravel.log" ]; then
    echo "   Son 10 satır:"
    tail -n 10 storage/logs/laravel.log | head -n 10
fi

echo ""
echo -e "${GREEN}═══════════════════════════════════════════════════════════${NC}"
echo -e "${GREEN}✅ Troubleshooting tamamlandı!${NC}"
echo -e "${GREEN}═══════════════════════════════════════════════════════════${NC}"
echo ""
echo "Eğer hala sorun varsa:"
echo "1. Logları kontrol et: tail -f storage/logs/laravel.log"
echo "2. Veritabanı bağlantısını test et: php artisan db:show"
echo "3. Health endpoint'i test et: curl http://localhost/health"
echo ""

