# 🔧 419 Page Expired ve Domain Yönlendirme Sorunu

## ❌ Sorunlar

1. **Form yanlış domain'e gidiyor:** `cronprojesi-cj.lc58dd.easypanel.host` yerine `cronjobs.to` olmalı
2. **419 Page Expired:** CSRF token hatası

## ✅ Çözümler

### 1. Cache Temizleme (ÖNCE BUNU YAP!)

EasyPanel Console'da (app servisi):

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

# Production cache'leri yeniden oluştur
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 2. Environment Variables Düzeltme

EasyPanel Dashboard → Environment Variables:

**Eklenmesi/Güncellenmesi Gerekenler:**

```env
# APP_URL (mutlaka doğru olmalı)
APP_URL=https://cronjobs.to

# Session Domain (null veya boş bırak - otomatik algılansın)
SESSION_DOMAIN=

# Session Secure Cookie (HTTPS için true)
SESSION_SECURE_COOKIE=true

# Trusted Proxies (Cloudflare için)
TRUSTED_PROXIES=*
```

### 3. Trusted Proxies Ayarlama

Cloudflare kullanıyorsan, `config/app.php` veya environment variable ile trusted proxies ayarla:

```env
TRUSTED_PROXIES=*
```

Veya `config/trustedproxy.php` dosyasında (eğer varsa).

### 4. Session Domain Kontrolü

`SESSION_DOMAIN` environment variable'ı:
- ❌ Yanlış: `.cronjobs.to` veya `cronprojesi-cj.lc58dd.easypanel.host`
- ✅ Doğru: `null` veya boş (otomatik algılansın)

### 5. Service Yeniden Başlatma

1. EasyPanel Dashboard → Service → Restart
2. Veya Stop → Start

## 🔍 Detaylı Kontrol

### APP_URL Kontrolü

Console'da:

```bash
php artisan tinker
```

Tinker'da:

```php
config('app.url');
// Çıktı: "https://cronjobs.to" olmalı

url('/try');
// Çıktı: "https://cronjobs.to/try" olmalı
```

### Session Domain Kontrolü

```php
config('session.domain');
// Çıktı: null veya boş olmalı
```

### Route URL Kontrolü

```php
route('guest.preview');
// Çıktı: "https://cronjobs.to/try" olmalı
```

## 🚀 Hızlı Çözüm Scripti

EasyPanel Console'da çalıştır:

```bash
# 1. Cache temizle
php artisan optimize:clear

# 2. Config kontrolü
php artisan tinker --execute="echo config('app.url');"

# 3. Route kontrolü
php artisan tinker --execute="echo route('guest.preview');"

# 4. Production cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## ⚠️ Önemli Notlar

### Cloudflare ile Çalışırken

1. **Trusted Proxies:** Mutlaka ayarlanmalı
2. **HTTPS:** Cloudflare'den gelen istekler HTTPS olarak görünür
3. **Session Cookie:** `SESSION_SECURE_COOKIE=true` olmalı

### Session Cookie Ayarları

```env
SESSION_DOMAIN=          # Boş bırak (otomatik)
SESSION_PATH=/          # Root path
SESSION_SECURE_COOKIE=true  # HTTPS için
SESSION_SAME_SITE=lax   # Cross-site için
```

## 🔄 Alternatif Çözüm (Geçici)

Eğer hala çalışmıyorsa, form action'ını mutlak URL ile düzelt:

`resources/views/landing.blade.php` dosyasında:

```blade
<!-- Şu an: -->
<form action="{{ route('guest.preview') }}" method="POST">

<!-- Geçici çözüm: -->
<form action="https://cronjobs.to/try" method="POST">
```

**Not:** Bu geçici bir çözüm. Asıl sorun cache veya environment variable'larda.

## ✅ Başarı Kontrolü

1. Ana sayfayı yenile: `https://cronjobs.to`
2. Tarayıcı cache'ini temizle: `Ctrl+F5` (Windows) veya `Cmd+Shift+R` (Mac)
3. "Test This Job" butonuna tıkla
4. Artık `https://cronjobs.to/try` sayfasına gitmeli
5. 419 hatası gitmeli

## 🐛 Sorun Giderme

### Problem: Hala yanlış domain'e gidiyor

**Çözüm:**
1. Tarayıcı cache'ini temizle
2. Service'i yeniden başlat
3. `APP_URL` environment variable'ını kontrol et
4. Route cache'i temizle: `php artisan route:clear`

### Problem: 419 hatası devam ediyor

**Çözüm:**
1. `SESSION_DOMAIN` boş olmalı
2. `SESSION_SECURE_COOKIE=true` olmalı
3. `TRUSTED_PROXIES=*` ekle
4. Session tablosunu kontrol et: `php artisan migrate:status`
5. Service'i yeniden başlat

### Problem: CSRF token mismatch

**Çözüm:**
1. Tarayıcı cookie'lerini temizle
2. Session'ı temizle: `php artisan session:clear` (eğer komut varsa)
3. Veritabanı session tablosunu kontrol et

---

**Son Güncelleme:** 23 Aralık 2025

