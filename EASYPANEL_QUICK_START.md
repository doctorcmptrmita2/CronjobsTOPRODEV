# 🚀 EasyPanel Hızlı Başlangıç Rehberi

Bu rehber, Cronjobs.to projesini EasyPanel'de sıfırdan kurmak için adım adım talimatlar içerir.

## 📋 Ön Gereksinimler

- ✅ EasyPanel v2.23.0+ kurulu ve çalışıyor
- ✅ Git repository (GitHub/GitLab) bağlantısı
- ✅ Domain adresi (örn: cronjobs.to)
- ✅ VPS/Cloud Server (OVH, DigitalOcean, vb.)

---

## 🎯 Otomatik Kurulum (Önerilen)

### Adım 1: Lokal Hazırlık

Proje dizininde şu komutu çalıştır:

```bash
chmod +x setup-easypanel.sh
./setup-easypanel.sh
```

Bu script:
- ✅ `.env` dosyası oluşturur
- ✅ `APP_KEY` oluşturur
- ✅ Dosya izinlerini ayarlar
- ✅ Storage link oluşturur
- ✅ Composer ve NPM bağımlılıklarını kontrol eder

### Adım 2: Git Repository'ye Push

```bash
git add .
git commit -m "feat: EasyPanel deployment configuration"
git push origin main
```

---

## 🌐 EasyPanel Dashboard Kurulumu

### Adım 1: Proje Oluştur

1. EasyPanel Dashboard'a giriş yap
2. **"+ Create Project"** butonuna tıkla
3. Proje adı: `cronjobs` (veya istediğiniz isim)
4. **"Create"** butonuna tıkla

### Adım 2: Docker Compose Service Ekle

1. Oluşturduğunuz proje içinde **"+ Create Service"** butonuna tıkla
2. **"Docker Compose"** seçeneğini seç
3. Service adı: `cronjobs-stack`
4. **"Source"** sekmesine git:
   - Git repository URL'ini ekle
   - Branch: `main` veya `master`
   - **"Auto Deploy"** aktif et (opsiyonel)
5. **"Docker Compose File"** alanına: `easypanel.yml` yaz

### Adım 3: Environment Variables Ekle

**"Environment Variables"** sekmesine git ve aşağıdaki değişkenleri ekle:

#### Temel Ayarlar

```env
APP_NAME=Cronjobs.to
APP_ENV=production
APP_KEY=base64:XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
APP_DEBUG=false
APP_URL=https://cronjobs.to
```

**APP_KEY Oluşturma:**
```bash
php artisan key:generate --show
```
Çıktıyı kopyala ve `APP_KEY` değişkenine yapıştır.

#### Veritabanı Ayarları

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=cronjobs
DB_USERNAME=cronjobs
DB_PASSWORD=your_secure_password_here
DB_ROOT_PASSWORD=your_root_password_here
```

**Önemli Notlar:**
- `DB_PASSWORD` **ZORUNLU** - MySQL kullanıcı şifresi
- `DB_ROOT_PASSWORD` **OPSİYONEL** - Eğer set edilmezse, `DB_PASSWORD` otomatik kullanılır
- Güvenlik için `DB_ROOT_PASSWORD` için ayrı ve güçlü bir şifre kullanmanız önerilir
- Her iki şifre için de güçlü şifreler kullanın!

#### Redis Ayarları

```env
REDIS_HOST=redis
REDIS_PORT=6379
REDIS_PASSWORD=
REDIS_CLIENT=phpredis
```

#### Queue & Cache

```env
QUEUE_CONNECTION=database
CACHE_STORE=database
SESSION_DRIVER=database
```

#### Mail Ayarları

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_USERNAME=noreply@cronjobs.to
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=noreply@cronjobs.to
MAIL_FROM_NAME="Cronjobs.to"
```

#### Deployment Ayarları

```env
DOCKER_IMAGE=cronjobs:latest
AUTO_MIGRATE=true
AUTO_SEED=false
```

**Not:** `AUTO_MIGRATE=true` ile her deploy'da otomatik migration çalışır.

### Adım 4: Domain ve SSL

1. **"Domains"** sekmesine git
2. **"+ Add Domain"** butonuna tıkla
3. Domain adını gir: `cronjobs.to` veya `app.cronjobs.to`
4. **"HTTPS"** seçeneğini aktif et (Let's Encrypt otomatik SSL)

### Adım 5: İlk Deployment

1. Tüm environment variables'ları eklediğinden emin ol
2. **"Deploy"** veya **"Save & Deploy"** butonuna tıkla
3. Build işlemi başlayacak (5-10 dakika sürebilir)

**Build İşlemi:**
- ✅ Docker image build edilir
- ✅ MySQL container başlatılır
- ✅ Redis container başlatılır
- ✅ App container başlatılır
- ✅ Tüm servisler aynı network'te birleştirilir

### Adım 6: İlk Kurulum Komutları

Build tamamlandıktan sonra, `app` servisinin **"Console"** sekmesine git:

```bash
# Storage link (otomatik oluşturulmuş olmalı)
php artisan storage:link

# Migration (AUTO_MIGRATE=true ise otomatik çalışmış olmalı)
php artisan migrate --force

# Cache'leri temizle ve yeniden oluştur
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Production cache'leri oluştur
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Seed data (opsiyonel - ilk kurulum için)
php artisan db:seed --force
```

---

## ✅ Kurulum Kontrolü

### Health Check

Tüm servislerin durumunu kontrol et:

- **App:** `http://yourdomain.com/health` endpoint'i çalışmalı
- **MySQL:** Health check otomatik çalışıyor
- **Redis:** Health check otomatik çalışıyor

### Servis Durumları

EasyPanel Dashboard'da:
- ✅ Yeşil: Servis çalışıyor
- ⚠️ Sarı: Servis başlatılıyor
- ❌ Kırmızı: Servis hata veriyor

### Log Kontrolü

Her servis için **"Logs"** sekmesinden real-time log takibi yapabilirsin.

---

## 🔄 Auto-Deploy (CI/CD)

### GitHub Auto-Deploy

1. Docker Compose service'inde **"Source"** sekmesine git
2. **"Auto Deploy"** seçeneğini aktif et
3. Her `main` branch'ine push yapıldığında otomatik deploy başlar

---

## 🐛 Sorun Giderme

### Problem: 502 Bad Gateway

**Çözüm:**
1. App service'in **"Logs"** sekmesini kontrol et
2. PHP-FPM çalışıyor mu kontrol et
3. Health check endpoint'i çalışıyor mu: `http://yourdomain.com/health`

### Problem: Database Connection Error

**Çözüm:**
1. MySQL service'in çalıştığından emin ol
2. Environment variables'ı kontrol et:
   - `DB_HOST=mysql` (container adı, IP değil!)
   - `DB_PASSWORD` doğru mu?
3. MySQL service'in **"Logs"** sekmesini kontrol et

### Problem: Migration Çalışmıyor

**Çözüm:**
1. `AUTO_MIGRATE=true` environment variable'ını kontrol et
2. Console'da manuel çalıştır:
   ```bash
   php artisan migrate --force
   ```

### Problem: Permission Denied

**Çözüm:**
Console'da çalıştır:
```bash
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache
```

---

## 📊 Servis Yapısı

`easypanel.yml` dosyası şu servisleri içerir:

- **app** - Laravel uygulaması (PHP 8.3, Nginx, PHP-FPM)
- **mysql** - MySQL 8.0 veritabanı
- **redis** - Redis 7 cache/queue

Tüm servisler:
- ✅ Aynı network'te (`cronjobs-network`)
- ✅ Health check ile izleniyor
- ✅ Otomatik restart yapılandırıldı
- ✅ Volume'ler ile veri kalıcılığı sağlandı

---

## 📚 Ek Kaynaklar

- **Detaylı Dokümantasyon:** `docker/EASYPANEL_SETUP.md`
- **EasyPanel Docs:** https://easypanel.io/docs
- **Laravel Docs:** https://laravel.com/docs

---

## ✅ Kurulum Checklist

- [ ] Lokal hazırlık scripti çalıştırıldı (`setup-easypanel.sh`)
- [ ] Git repository'ye push yapıldı
- [ ] EasyPanel'de proje oluşturuldu
- [ ] Docker Compose service eklendi
- [ ] Git repository bağlandı
- [ ] Tüm environment variables eklendi
- [ ] `APP_KEY` oluşturuldu ve eklendi
- [ ] Domain eklendi ve SSL aktif
- [ ] İlk deployment yapıldı
- [ ] Migration çalıştırıldı (otomatik veya manuel)
- [ ] Storage link oluşturuldu
- [ ] Cache'ler temizlendi ve yeniden oluşturuldu
- [ ] Tüm servisler çalışıyor (yeşil durum)
- [ ] Health check başarılı
- [ ] Domain erişilebilir

---

## 🎉 Kurulum Tamamlandı!

Artık tüm servisleriniz (App, MySQL, Redis) tek bir Docker Compose service'i altında çalışıyor.

**Sonraki Adımlar:**
1. İlk admin kullanıcısını oluştur
2. Queue worker'ın çalıştığını kontrol et
3. Scheduler'ın çalıştığını kontrol et
4. Monitoring ve logging ayarlarını yapılandır

