#!/bin/sh
# 🔑 APP_KEY Oluşturma ve Kontrol Scripti
# EasyPanel için - .env dosyası olmadan çalışır

set -e

echo "🔑 APP_KEY kontrolü ve oluşturma..."
echo ""

# APP_KEY environment variable'ını kontrol et
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    echo "⚠️  APP_KEY environment variable'ı eksik!"
    echo ""
    echo "APP_KEY oluşturuluyor..."
    
    # Geçici .env dosyası oluştur (sadece key generate için)
    touch /tmp/.env.tmp
    php artisan key:generate --force --env=local 2>/dev/null || {
        # Alternatif yöntem: direkt key oluştur
        KEY=$(php -r "echo 'base64:' . base64_encode(random_bytes(32));")
        echo "✅ APP_KEY oluşturuldu:"
        echo ""
        echo "═══════════════════════════════════════════════════════════"
        echo "EasyPanel Dashboard'da Environment Variables'a şunu ekle:"
        echo "═══════════════════════════════════════════════════════════"
        echo ""
        echo "APP_KEY=$KEY"
        echo ""
        echo "═══════════════════════════════════════════════════════════"
        echo ""
        echo "⚠️  ÖNEMLİ: Bu KEY'i kopyala ve EasyPanel'de APP_KEY environment variable'ına ekle!"
        echo "   Sonra container'ı yeniden başlat."
        exit 0
    }
    
    # .env.tmp'den key'i oku
    if [ -f /tmp/.env.tmp ]; then
        KEY=$(grep "APP_KEY=" /tmp/.env.tmp | cut -d '=' -f2)
        if [ ! -z "$KEY" ]; then
            echo "✅ APP_KEY oluşturuldu:"
            echo ""
            echo "═══════════════════════════════════════════════════════════"
            echo "EasyPanel Dashboard'da Environment Variables'a şunu ekle:"
            echo "═══════════════════════════════════════════════════════════"
            echo ""
            echo "APP_KEY=$KEY"
            echo ""
            echo "═══════════════════════════════════════════════════════════"
        fi
        rm -f /tmp/.env.tmp
    fi
else
    echo "✅ APP_KEY environment variable'ı mevcut"
    echo "   Key: ${APP_KEY:0:20}..."
    
    # APP_KEY'in geçerli olup olmadığını kontrol et
    if php -r "if (strlen('$APP_KEY') < 10) exit(1);" 2>/dev/null; then
        echo "✅ APP_KEY geçerli görünüyor"
    else
        echo "⚠️  APP_KEY geçersiz görünüyor, yeniden oluşturulmalı"
    fi
fi

echo ""
echo "✅ Kontrol tamamlandı!"

