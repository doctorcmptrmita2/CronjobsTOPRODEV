# 🔗 APP_URL Sorunu Çözümü

## ❌ Sorun

"Test This Job" butonuna tıklayınca EasyPanel'in default domain'ine (`cronprojesi-cj.lc58dd.easypanel.host`) yönlendiriyor, custom domain'e (`cronjobs.to`) değil.

**Neden:** `APP_URL` environment variable'ı yanlış ayarlanmış.

## ✅ Çözüm

### EasyPanel'de APP_URL'i Düzelt

1. EasyPanel Dashboard → Projen → Service (cj)
2. **Environment Variables** sekmesine git
3. `APP_URL` değişkenini bul veya ekle
4. Değeri düzelt:
   - ❌ Yanlış: `https://cronprojesi-cj.lc58dd.easypanel.host`
   - ✅ Doğru: `https://cronjobs.to`

5. **Save** butonuna tıkla
6. Service'i **yeniden başlat** (Restart)

## 🔄 Cache Temizleme

Service yeniden başladıktan sonra, Console'da:

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Production cache'leri yeniden oluştur
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## ✅ Kontrol

1. Ana sayfayı yenile: `https://cronjobs.to`
2. "Test This Job" butonuna tıkla
3. Artık `https://cronjobs.to/try` sayfasına gitmeli (EasyPanel domain'ine değil)

## 📝 Doğru Environment Variables

EasyPanel'de şu değişkenler olmalı:

```env
APP_URL=https://cronjobs.to
APP_NAME="Cronjobs.to"
APP_ENV=production
```

**Önemli:** 
- `APP_URL` mutlaka custom domain olmalı (`https://cronjobs.to`)
- EasyPanel'in default domain'i (`cronprojesi-cj.lc58dd.easypanel.host`) kullanılmamalı
- `https://` ile başlamalı (SSL aktifse)

## 🔍 Sorun Giderme

### Problem: Hala yanlış domain'e gidiyor

**Çözüm:**
1. Cache'leri temizle (yukarıdaki komutlar)
2. Service'i yeniden başlat
3. Tarayıcı cache'ini temizle (Ctrl+F5)

### Problem: APP_URL değişkeni yok

**Çözüm:**
1. EasyPanel Dashboard → Environment Variables
2. "+ Add Variable" butonuna tıkla
3. Name: `APP_URL`
4. Value: `https://cronjobs.to`
5. Save ve Restart

---

**Son Güncelleme:** 23 Aralık 2025

