#!/bin/bash

# 🚀 EasyPanel Otomatik Kurulum Scripti
# Bu script, EasyPanel için gerekli tüm ayarları otomatik olarak yapar

set -e

echo "🚀 EasyPanel Otomatik Kurulum Başlatılıyor..."
echo ""

# Renkler
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# .env dosyası kontrolü
if [ ! -f .env ]; then
    echo -e "${YELLOW}⚠️  .env dosyası bulunamadı. .env.example'dan oluşturuluyor...${NC}"
    cp .env.example .env
    echo -e "${GREEN}✅ .env dosyası oluşturuldu${NC}"
else
    echo -e "${GREEN}✅ .env dosyası mevcut${NC}"
fi

# APP_KEY kontrolü ve oluşturma
if ! grep -q "APP_KEY=base64:" .env || grep -q "APP_KEY=$" .env; then
    echo -e "${YELLOW}🔑 APP_KEY oluşturuluyor...${NC}"
    php artisan key:generate --force
    echo -e "${GREEN}✅ APP_KEY oluşturuldu${NC}"
else
    echo -e "${GREEN}✅ APP_KEY mevcut${NC}"
fi

# Dosya izinleri
echo -e "${YELLOW}🔒 Dosya izinleri ayarlanıyor...${NC}"
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || echo "⚠️  www-data kullanıcısı bulunamadı (normal, Docker dışında)"
echo -e "${GREEN}✅ Dosya izinleri ayarlandı${NC}"

# Storage link
if [ ! -L "public/storage" ]; then
    echo -e "${YELLOW}🔗 Storage link oluşturuluyor...${NC}"
    php artisan storage:link
    echo -e "${GREEN}✅ Storage link oluşturuldu${NC}"
else
    echo -e "${GREEN}✅ Storage link mevcut${NC}"
fi

# Composer dependencies
if [ ! -d "vendor" ]; then
    echo -e "${YELLOW}📦 Composer bağımlılıkları yükleniyor...${NC}"
    composer install --optimize-autoloader --no-dev
    echo -e "${GREEN}✅ Composer bağımlılıkları yüklendi${NC}"
else
    echo -e "${GREEN}✅ Composer bağımlılıkları mevcut${NC}"
fi

# NPM dependencies ve build
if [ ! -d "node_modules" ]; then
    echo -e "${YELLOW}📦 NPM bağımlılıkları yükleniyor...${NC}"
    npm install
    echo -e "${GREEN}✅ NPM bağımlılıkları yüklendi${NC}"
fi

if [ ! -d "public/build" ]; then
    echo -e "${YELLOW}🏗️  Frontend assets build ediliyor...${NC}"
    npm run build
    echo -e "${GREEN}✅ Frontend assets build edildi${NC}"
else
    echo -e "${GREEN}✅ Frontend assets mevcut${NC}"
fi

# Cache temizleme
echo -e "${YELLOW}🧹 Cache'ler temizleniyor...${NC}"
php artisan config:clear || true
php artisan cache:clear || true
php artisan route:clear || true
php artisan view:clear || true
echo -e "${GREEN}✅ Cache'ler temizlendi${NC}"

echo ""
echo -e "${GREEN}═══════════════════════════════════════════════════════════${NC}"
echo -e "${GREEN}✅ EasyPanel Kurulum Hazırlığı Tamamlandı!${NC}"
echo -e "${GREEN}═══════════════════════════════════════════════════════════${NC}"
echo ""
echo "📋 Sonraki Adımlar:"
echo ""
echo "1. EasyPanel Dashboard'a giriş yap"
echo "2. Yeni bir proje oluştur"
echo "3. Docker Compose service ekle"
echo "4. Git repository'yi bağla"
echo "5. Docker Compose File: easypanel.yml"
echo "6. Environment Variables'ları ekle (.env.example'dan)"
echo "7. APP_KEY'i oluştur: php artisan key:generate --show"
echo "8. Domain ekle ve SSL aktif et"
echo "9. Deploy butonuna tıkla"
echo ""
echo "📝 Önemli Notlar:"
echo "- AUTO_MIGRATE=true olarak ayarlandı (otomatik migration)"
echo "- MySQL ve Redis otomatik olarak oluşturulacak"
echo "- Tüm servisler aynı network'te çalışacak"
echo "- Health check'ler otomatik yapılandırıldı"
echo ""
echo "📚 Detaylı dokümantasyon: docker/EASYPANEL_SETUP.md"
echo ""

