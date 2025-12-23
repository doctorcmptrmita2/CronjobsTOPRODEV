#!/bin/sh
# 🔧 419 Page Expired ve Domain Yönlendirme Sorunu Düzeltme Scripti

set -e

echo "🔧 419 ve Domain sorunları düzeltiliyor..."
echo ""

# 1. Cache temizleme
echo "1️⃣  Cache'ler temizleniyor..."
php artisan optimize:clear || true
php artisan config:clear || true
php artisan cache:clear || true
php artisan route:clear || true
php artisan view:clear || true
echo "✅ Cache'ler temizlendi"
echo ""

# 2. APP_URL kontrolü
echo "2️⃣  APP_URL kontrol ediliyor..."
APP_URL=$(php artisan tinker --execute="echo config('app.url');" 2>/dev/null | tail -n 1)
echo "   APP_URL: $APP_URL"

if [ "$APP_URL" != "https://cronjobs.to" ]; then
    echo "⚠️  APP_URL yanlış! EasyPanel'de APP_URL=https://cronjobs.to olmalı"
else
    echo "✅ APP_URL doğru"
fi
echo ""

# 3. Route kontrolü
echo "3️⃣  Route URL kontrol ediliyor..."
ROUTE_URL=$(php artisan tinker --execute="echo route('guest.preview');" 2>/dev/null | tail -n 1)
echo "   Route URL: $ROUTE_URL"

if echo "$ROUTE_URL" | grep -q "cronprojesi-cj.lc58dd.easypanel.host"; then
    echo "⚠️  Route yanlış domain'e işaret ediyor!"
    echo "   Çözüm: APP_URL environment variable'ını kontrol et"
else
    echo "✅ Route URL doğru"
fi
echo ""

# 4. Session domain kontrolü
echo "4️⃣  Session domain kontrol ediliyor..."
SESSION_DOMAIN=$(php artisan tinker --execute="echo config('session.domain') ?? 'null';" 2>/dev/null | tail -n 1)
echo "   SESSION_DOMAIN: $SESSION_DOMAIN"

if [ "$SESSION_DOMAIN" != "null" ] && [ ! -z "$SESSION_DOMAIN" ]; then
    echo "⚠️  SESSION_DOMAIN set edilmiş: $SESSION_DOMAIN"
    echo "   Önerilen: SESSION_DOMAIN= (boş bırak)"
else
    echo "✅ SESSION_DOMAIN doğru (null/boş)"
fi
echo ""

# 5. Production cache oluştur
echo "5️⃣  Production cache'leri oluşturuluyor..."
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true
echo "✅ Production cache'leri oluşturuldu"
echo ""

echo "═══════════════════════════════════════════════════════════"
echo "✅ Kontrol tamamlandı!"
echo "═══════════════════════════════════════════════════════════"
echo ""
echo "📋 Yapılacaklar:"
echo ""
echo "1. EasyPanel Dashboard → Environment Variables:"
echo "   - APP_URL=https://cronjobs.to (kontrol et)"
echo "   - SESSION_DOMAIN= (boş bırak veya kaldır)"
echo "   - SESSION_SECURE_COOKIE=true (ekle)"
echo ""
echo "2. Service'i yeniden başlat"
echo ""
echo "3. Tarayıcı cache'ini temizle (Ctrl+F5)"
echo ""
echo "4. Test et: https://cronjobs.to"
echo ""

