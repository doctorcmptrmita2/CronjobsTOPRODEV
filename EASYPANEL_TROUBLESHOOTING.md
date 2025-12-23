# 🐛 EasyPanel Troubleshooting Rehberi

Bu rehber, EasyPanel'de karşılaşabileceğiniz yaygın sorunları ve çözümlerini içerir.

---

## ❌ 500 Server Error

### Olası Nedenler ve Çözümler

#### 1. APP_KEY Eksik veya Yanlış

**Belirtiler:**
- 500 Internal Server Error
- Log'larda "No application encryption key has been specified"

**Çözüm:**

EasyPanel Console'da (app servisi) çalıştır:

```bash
php artisan key:generate --force
```

Veya Environment Variables'a ekle:
```env
APP_KEY=base64:XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
```

APP_KEY oluşturma:
```bash
php artisan key:generate --show
```

---

#### 2. Veritabanı Bağlantı Hatası

**Belirtiler:**
- 500 Internal Server Error
- Log'larda "SQLSTATE[HY000] [2002]" veya benzeri hatalar

**Çözüm:**

1. **Environment Variables Kontrolü:**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=mysql
   DB_PORT=3306
   DB_DATABASE=cronjobs
   DB_USERNAME=cronjobs
   DB_PASSWORD=your_secure_password_here
   ```

2. **MySQL Servisinin Çalıştığını Kontrol Et:**
   - EasyPanel Dashboard'da MySQL servisinin yeşil (healthy) olduğundan emin ol

3. **Manuel Bağlantı Testi:**
   ```bash
   php artisan db:show
   ```

4. **Migration Çalıştır:**
   ```bash
   php artisan migrate --force
   ```

---

#### 3. Storage Permissions Hatası

**Belirtiler:**
- 500 Internal Server Error
- Log'larda "Permission denied" veya "failed to open stream"

**Çözüm:**

EasyPanel Console'da çalıştır:

```bash
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache
```

---

#### 4. Storage Link Eksik

**Belirtiler:**
- Resimler/yüklemeler görünmüyor
- 404 hatası public/storage için

**Çözüm:**

```bash
php artisan storage:link
```

---

#### 5. Cache Sorunları

**Belirtiler:**
- Eski ayarlar görünüyor
- Değişiklikler yansımıyor

**Çözüm:**

```bash
# Tüm cache'leri temizle
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Production için cache'leri yeniden oluştur
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

#### 6. Migration Çalışmamış

**Belirtiler:**
- "Table doesn't exist" hatası
- Veritabanı tabloları eksik

**Çözüm:**

```bash
# Migration durumunu kontrol et
php artisan migrate:status

# Migration çalıştır
php artisan migrate --force

# İlk kurulum için seed
php artisan db:seed --force
```

---

## 🔧 Otomatik Troubleshooting Scripti

EasyPanel Console'da (app servisi) çalıştır:

```bash
chmod +x /var/www/html/docker/troubleshoot.sh
/var/www/html/docker/troubleshoot.sh
```

Bu script otomatik olarak:
- ✅ APP_KEY kontrolü ve oluşturma
- ✅ Veritabanı bağlantı testi
- ✅ Migration kontrolü ve çalıştırma
- ✅ Storage permissions düzeltme
- ✅ Storage link oluşturma
- ✅ Cache temizleme
- ✅ Son hataları gösterme

---

## 📊 Log Kontrolü

### Laravel Logları

```bash
# Son 50 satır
tail -n 50 /var/www/html/storage/logs/laravel.log

# Real-time log takibi
tail -f /var/www/html/storage/logs/laravel.log
```

### Nginx Logları

```bash
tail -f /var/log/nginx/error.log
tail -f /var/log/nginx/access.log
```

### PHP-FPM Logları

```bash
tail -f /var/log/php-fpm.log
```

---

## 🔍 Health Check Kontrolü

### Health Endpoint Testi

```bash
# Container içinden
curl http://localhost/health

# Dışarıdan
curl https://yourdomain.com/health
```

**Beklenen Çıktı:**
```json
{
    "status": "ok",
    "timestamp": "2025-12-23T15:20:00Z",
    "service": "cronjobs"
}
```

### Laravel Health Check

```bash
curl https://yourdomain.com/up
```

---

## 🗄️ Veritabanı Sorunları

### MySQL Container'a Bağlanma

```bash
# MySQL container'ına bağlan
docker exec -it cronprojesi_cj-mysql-1 mysql -u root -p

# Veya kullanıcı ile
docker exec -it cronprojesi_cj-mysql-1 mysql -u cronjobs -p
```

### Veritabanı Kontrolü

```sql
-- Veritabanlarını listele
SHOW DATABASES;

-- Tabloları listele
USE cronjobs;
SHOW TABLES;

-- Migration tablosunu kontrol et
SELECT * FROM migrations;
```

---

## 🔄 Servisleri Yeniden Başlatma

### Tüm Servisleri Yeniden Başlat

EasyPanel Dashboard'da:
1. Service'i durdur
2. Service'i tekrar başlat

### Sadece App Servisini Yeniden Başlat

```bash
# Container'ı yeniden başlat
docker restart cronprojesi_cj-app-1
```

---

## 📝 Hızlı Çözüm Checklist

500 hatası için şu adımları sırayla dene:

- [ ] APP_KEY kontrolü: `php artisan key:generate --force`
- [ ] Veritabanı bağlantısı: `php artisan db:show`
- [ ] Migration çalıştır: `php artisan migrate --force`
- [ ] Storage permissions: `chmod -R 775 storage bootstrap/cache`
- [ ] Storage link: `php artisan storage:link`
- [ ] Cache temizle: `php artisan config:clear && php artisan cache:clear`
- [ ] Log kontrolü: `tail -n 50 storage/logs/laravel.log`
- [ ] Health check: `curl http://localhost/health`
- [ ] Servisleri yeniden başlat

---

## 🆘 Hala Sorun Varsa

1. **Logları İncele:**
   ```bash
   tail -n 100 /var/www/html/storage/logs/laravel.log
   ```

2. **Environment Variables Kontrolü:**
   - EasyPanel Dashboard'da tüm environment variables'ların doğru olduğundan emin ol
   - Özellikle: `APP_KEY`, `DB_PASSWORD`, `DB_HOST`

3. **Container Logları:**
   - EasyPanel Dashboard'da her servis için "Logs" sekmesini kontrol et

4. **Health Check:**
   - Tüm servislerin "healthy" durumunda olduğundan emin ol

5. **Troubleshooting Scripti Çalıştır:**
   ```bash
   /var/www/html/docker/troubleshoot.sh
   ```

---

## 📚 Ek Kaynaklar

- **Laravel Logging:** https://laravel.com/docs/logging
- **Laravel Troubleshooting:** https://laravel.com/docs/errors
- **EasyPanel Docs:** https://easypanel.io/docs

---

## ✅ Başarılı Kurulum Kontrolü

Tüm bunlar tamamlandıktan sonra:

- [ ] `https://yourdomain.com/health` → 200 OK
- [ ] `https://yourdomain.com/up` → 200 OK
- [ ] Ana sayfa açılıyor
- [ ] Login sayfası çalışıyor
- [ ] Veritabanı bağlantısı başarılı
- [ ] Storage link çalışıyor
- [ ] Tüm servisler healthy

---

**Son Güncelleme:** 23 Aralık 2025

