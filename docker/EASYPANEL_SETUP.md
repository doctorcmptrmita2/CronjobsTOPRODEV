# 🚀 EasyPanel Kurulum Rehberi - Cronjobs.to

## 📋 Gereksinimler

- EasyPanel v2.23.0+
- OVH VPS veya Cloud Server
- Domain (örn: cronjobs.to)
- Git repository (GitHub/GitLab) bağlantısı

## 🎯 Tek Seferde Otomatik Kurulum

Bu rehber, tüm servisleri (App, MySQL, Redis) tek bir Docker Compose dosyası ile otomatik olarak kuracak şekilde hazırlanmıştır.

---

## 📁 Dosya Yapısı

Proje root dizininde şu dosyalar bulunmalı:
- `easypanel.yml` - EasyPanel Docker Compose yapılandırması (TÜM SERVİSLER İÇERİR)
- `Dockerfile` - Docker image build dosyası
- `.env.example` - Environment variables şablonu (referans için)

---

## 🚀 Adım 1: EasyPanel'de Proje Oluşturma

1. EasyPanel Dashboard'a giriş yap
2. **"+ Create Project"** butonuna tıkla
3. Proje adı: `cronjobs` (veya istediğiniz isim)
4. **"Create"** butonuna tıkla

---

## 🐳 Adım 2: Docker Compose Service Oluşturma (TEK SEFERDE TÜM SERVİSLER)

### 2.1. Service Oluşturma

1. Oluşturduğunuz proje içinde **"+ Create Service"** butonuna tıkla
2. **"Docker Compose"** seçeneğini seç
3. Service adı: `cronjobs-stack` (veya istediğiniz isim)

### 2.2. Repository Bağlama

1. **"Source"** sekmesine git
2. Git repository URL'ini ekle (GitHub, GitLab, vb.)
3. Branch: `main` veya `master`
4. **"Auto Deploy"** aktif et (opsiyonel - her push'ta otomatik deploy)

### 2.3. Docker Compose Dosyası

1. **"Docker Compose File"** alanına: `easypanel.yml` yaz
2. EasyPanel otomatik olarak dosyayı bulacak ve yükleyecek

**NOT:** `easypanel.yml` dosyası şu servisleri içerir:
- ✅ **app** - Laravel uygulaması
- ✅ **mysql** - MySQL 8.0 veritabanı
- ✅ **redis** - Redis cache/queue

---

## ⚙️ Adım 3: Environment Variables Ekleme

### 3.1. Proje Seviyesinde Environment Variables

Docker Compose service'inde **"Environment Variables"** sekmesine git ve aşağıdaki değişkenleri ekle:

#### Temel Uygulama Ayarları

```env
APP_NAME=Cronjobs.to
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://cronjobs.to
```

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

#### Redis Ayarları

```env
REDIS_HOST=redis
REDIS_PORT=6379
REDIS_PASSWORD=
```

#### Queue & Cache Ayarları

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

#### Docker & Deployment Ayarları

```env
DOCKER_IMAGE=cronjobs:latest
AUTO_MIGRATE=false
```

### 3.2. APP_KEY Oluşturma

Lokal makinende veya başka bir Laravel projesinde çalıştır:

```bash
php artisan key:generate --show
```

Çıktıyı kopyala ve `APP_KEY` environment variable'ına yapıştır.

**Örnek:**
```env
APP_KEY=base64:XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
```

### 3.3. .env Dosyası Oluşturma (Opsiyonel - Referans İçin)

Eğer lokal geliştirme için `.env` dosyası oluşturmak istersen:

1. Proje root dizininde `.env.example` dosyasını kopyala:
   ```bash
   cp .env.example .env
   ```

2. `.env` dosyasını düzenle ve yukarıdaki değerleri ekle

**NOT:** EasyPanel'de environment variables proje seviyesinde tanımlanır, `.env` dosyasına gerek yoktur.

---

## 🌐 Adım 4: Domain ve SSL Ayarları

### 4.1. Domain Ekleme

1. Docker Compose service'inde **"Domains"** sekmesine git
2. **"+ Add Domain"** butonuna tıkla
3. Domain adını gir: `cronjobs.to` veya `app.cronjobs.to`
4. **"HTTPS"** seçeneğini aktif et (Let's Encrypt otomatik SSL)

### 4.2. Port Mapping

EasyPanel otomatik olarak port mapping yapar. `easypanel.yml` dosyasında `ports` tanımı yoktur çünkü EasyPanel bunu otomatik yönetir.

---

## 🚀 Adım 5: İlk Deployment

### 5.1. Deploy Başlatma

1. Tüm environment variables'ları eklediğinden emin ol
2. **"Deploy"** veya **"Save & Deploy"** butonuna tıkla
3. Build işlemi başlayacak (5-10 dakika sürebilir)

### 5.2. Build İşlemi

EasyPanel şunları yapacak:
- ✅ Docker image'ı build edecek
- ✅ MySQL container'ını başlatacak
- ✅ Redis container'ını başlatacak
- ✅ App container'ını başlatacak
- ✅ Tüm servisleri aynı network'te birleştirecek

### 5.3. İlk Kurulum Komutları

Build tamamlandıktan sonra, `app` servisinin **"Console"** sekmesine git ve şu komutları çalıştır:

```bash
# Storage link oluştur
php artisan storage:link

# Migration çalıştır
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

### 5.4. Otomatik Migration (Opsiyonel)

Her deploy'da otomatik migration çalışması için:

1. Environment variables'a ekle:
   ```env
   AUTO_MIGRATE=true
   ```

2. `Dockerfile` veya `start.sh` dosyasında migration komutu tanımlı olmalı

---

## 📊 Adım 6: Servis Durumunu Kontrol Etme

### 6.1. Health Check

`easypanel.yml` dosyasında health check tanımlıdır:
- **App:** `http://localhost/health` endpoint'i kontrol edilir
- **MySQL:** `mysqladmin ping` komutu ile kontrol edilir
- **Redis:** `redis-cli ping` komutu ile kontrol edilir

### 6.2. Logs Kontrolü

1. Her servis için **"Logs"** sekmesine git
2. Real-time log takibi yapabilirsin
3. Hata varsa loglardan görebilirsin

### 6.3. Servis Durumu

- ✅ Yeşil: Servis çalışıyor
- ⚠️ Sarı: Servis başlatılıyor
- ❌ Kırmızı: Servis hata veriyor

---

## 🔄 Adım 7: Auto-Deploy (CI/CD)

### 7.1. GitHub Auto-Deploy

1. Docker Compose service'inde **"Source"** sekmesine git
2. **"Auto Deploy"** seçeneğini aktif et
3. Her `main` veya `master` branch'ine push yapıldığında otomatik deploy başlar

### 7.2. Webhook URL (Opsiyonel)

EasyPanel bir webhook URL'i sağlar. Bu URL'i GitHub repository settings'te webhook olarak ekleyebilirsin.

---

## ⚡ Adım 8: Performance Tuning

### 8.1. Resource Limits

EasyPanel'de her servis için resource limitleri ayarlayabilirsin:

**App Service:**
- CPU: 1-2 cores
- Memory: 512MB - 2GB

**MySQL Service:**
- CPU: 1 core
- Memory: 512MB - 1GB

**Redis Service:**
- CPU: 0.5 core
- Memory: 256MB - 512MB

### 8.2. Scaling

Production ortamında app service'i scale edebilirsin:
- **Replicas:** 2-3 (load balancing için)

---

## 🐛 Troubleshooting

### Problem: 502 Bad Gateway

**Çözüm:**
1. App service'in **"Logs"** sekmesini kontrol et
2. PHP-FPM çalışıyor mu kontrol et
3. Health check endpoint'i çalışıyor mu kontrol et: `http://yourdomain.com/health`

### Problem: Database Connection Error

**Çözüm:**
1. MySQL service'in çalıştığından emin ol
2. Environment variables'ı kontrol et:
   - `DB_HOST=mysql` (container adı, IP değil!)
   - `DB_PASSWORD` doğru mu?
3. MySQL service'in **"Logs"** sekmesini kontrol et

### Problem: Container Name Conflict

**Çözüm:**
- `easypanel.yml` dosyasında `container_name` kullanılmamalı
- EasyPanel otomatik olarak container isimlerini oluşturur
- Eğer hala conflict varsa, proje adını değiştir

### Problem: Port Conflict

**Çözüm:**
- `easypanel.yml` dosyasında `ports` tanımı olmamalı
- EasyPanel otomatik olarak port mapping yapar
- Eğer hala conflict varsa, EasyPanel'de domain ayarlarından port'u değiştir

### Problem: Permission Denied

**Çözüm:**
App service'in **"Console"** sekmesinde çalıştır:

```bash
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache
```

### Problem: Queue Worker Çalışmıyor

**Çözüm:**
1. Supervisord loglarını kontrol et
2. App service'in **"Console"** sekmesinde:
   ```bash
   ps aux | grep queue
   ```
3. Eğer çalışmıyorsa, `supervisord.conf` dosyasını kontrol et

### Problem: Migration Çalışmıyor

**Çözüm:**
1. `AUTO_MIGRATE=true` environment variable'ını ekle
2. Veya manuel olarak Console'da çalıştır:
   ```bash
   php artisan migrate --force
   ```

---

## 📞 Destek ve Dokümantasyon

- **EasyPanel Docs:** https://easypanel.io/docs
- **Laravel Docs:** https://laravel.com/docs
- **Docker Docs:** https://docs.docker.com

---

## ✅ Kurulum Checklist

Kurulumdan önce bu checklist'i kontrol et:

- [ ] EasyPanel kurulu ve çalışıyor
- [ ] Git repository bağlandı
- [ ] `easypanel.yml` dosyası projede mevcut
- [ ] `Dockerfile` dosyası projede mevcut
- [ ] Tüm environment variables eklendi
- [ ] `APP_KEY` oluşturuldu ve eklendi
- [ ] Domain eklendi ve SSL aktif
- [ ] İlk deployment yapıldı
- [ ] Migration çalıştırıldı
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
