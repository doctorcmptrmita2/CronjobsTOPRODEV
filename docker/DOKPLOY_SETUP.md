# 🚀 Dokploy Deployment Guide - Cronjobs.to

## 📋 Gereksinimler

- Dokploy kurulumu (self-hosted veya cloud)
- Docker ve Docker Compose desteği
- Domain (örn: cronjobs.to)
- Minimum 2GB RAM, 2 CPU core

---

## 🔧 Adım 1: Dokploy'da Proje Oluşturma

1. Dokploy Dashboard'a giriş yap
2. **"+ New Project"** butonuna tıkla
3. Proje adı: `cronjobs`
4. **"Docker Compose"** tipini seç

---

## 📝 Adım 2: Repository Bağlama

1. **"Source"** sekmesine git
2. Git repository URL'ini ekle (GitHub, GitLab, vb.)
3. Branch: `main` veya `master`
4. **"Auto Deploy"** aktif et (opsiyonel)

---

## ⚙️ Adım 3: Environment Variables

**"Environment Variables"** sekmesine git ve aşağıdaki değişkenleri ekle:

### Temel Ayarlar
```env
APP_NAME=Cronjobs.to
APP_ENV=production
APP_KEY=base64:XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
APP_DEBUG=false
APP_URL=https://cronjobs.to
APP_PORT=80
```

### Veritabanı Ayarları
```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=cronjobs
DB_USERNAME=cronjobs
DB_PASSWORD=your_secure_password_here
DB_ROOT_PASSWORD=your_root_password_here
```

### Redis Ayarları
```env
REDIS_HOST=redis
REDIS_PORT=6379
REDIS_PASSWORD=
```

### Queue & Cache
```env
QUEUE_CONNECTION=database
CACHE_STORE=database
SESSION_DRIVER=database
```

### Mail Ayarları
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

### Deployment Ayarları
```env
AUTO_MIGRATE=true
DOCKER_IMAGE=cronjobs:latest
```

### APP_KEY Oluşturma
Lokal makinende çalıştır:
```bash
php artisan key:generate --show
```
Çıktıyı `APP_KEY` olarak kullan.

---

## 🐳 Adım 4: Docker Compose Konfigürasyonu

Dokploy, `dokploy.yml` dosyasını otomatik olarak algılar. Dosya zaten projede mevcut.

**Önemli Notlar:**
- `dokploy.yml` dosyası Dokploy tarafından otomatik olarak kullanılır
- Tüm servisler aynı network'te çalışır
- Health check'ler otomatik olarak yapılandırılmıştır

---

## 🌐 Adım 5: Domain ve SSL Ayarları

1. **"Domains"** sekmesine git
2. Domain ekle: `cronjobs.to` veya `app.cronjobs.to`
3. **"SSL"** aktif et (Let's Encrypt otomatik)
4. **"Force HTTPS"** aktif et

---

## 🚀 Adım 6: İlk Deployment

1. **"Deploy"** butonuna tıkla
2. Build loglarını takip et
3. Deployment tamamlanınca **"Console"** sekmesine git
4. Aşağıdaki komutları çalıştır:

```bash
# Migration (AUTO_MIGRATE=true ise otomatik çalışır)
php artisan migrate --force

# Cache'leri temizle ve yeniden oluştur
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Storage link
php artisan storage:link

# Permissions
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Seed data (opsiyonel)
php artisan db:seed --force
```

---

## 📊 Adım 7: Monitoring ve Logs

### Logs
- Dokploy Dashboard → **"Logs"** sekmesi
- Real-time log takibi
- Her servis için ayrı log görüntüleme

### Health Checks
- Otomatik health check'ler yapılandırılmıştır
- App: `/health` endpoint'i
- MySQL: `mysqladmin ping`
- Redis: `redis-cli ping`

### Metrics
- CPU ve Memory kullanımı
- Network trafiği
- Container durumları

---

## 🔄 Adım 8: Auto-Deploy (CI/CD)

### GitHub/GitLab Integration
1. **"Source"** sekmesine git
2. Repository bağla
3. **"Auto Deploy"** aktif et
4. Her push'ta otomatik deploy

### Webhook URL
Dokploy size bir webhook URL'i verir. Bunu GitHub/GitLab repository settings'e ekleyebilirsiniz.

---

## ⚡ Adım 9: Performance Tuning

### Resource Limits
Dokploy'da **"Resources"** sekmesinden ayarlayın:

**App Service:**
- CPU: 1-2 cores
- Memory: 512MB - 1GB
- Replicas: 1 (production için 2 önerilir)

**MySQL Service:**
- CPU: 1 core
- Memory: 512MB - 1GB

**Redis Service:**
- CPU: 0.5 core
- Memory: 256MB - 512MB

---

## 🔒 Adım 10: Security Best Practices

### Environment Variables
- Hassas bilgileri environment variables olarak saklayın
- Dokploy'da **"Secrets"** özelliğini kullanın
- `.env` dosyasını asla commit etmeyin

### Network Security
- Servisler arası iletişim internal network üzerinden
- Sadece app servisi dışarıya açık (port 80)
- MySQL ve Redis sadece internal network'te

### SSL/TLS
- Let's Encrypt ile otomatik SSL
- HTTPS zorunlu kılın
- Security headers nginx.conf'da yapılandırılmış

---

## 🐛 Troubleshooting

### 502 Bad Gateway
- PHP-FPM çalışmıyor olabilir
- Logs'u kontrol et: Dokploy → Logs → app
- Health check'i kontrol et

### Database Connection Error
- MySQL servisinin çalıştığından emin ol
- Environment variables'ı kontrol et
- Network bağlantısını kontrol et

### Build Fails
- Dockerfile'ı kontrol et
- `.dockerignore` dosyasını kontrol et
- Build loglarını incele

### Migration Errors
- Database'in hazır olduğundan emin ol
- `AUTO_MIGRATE=true` ayarını kontrol et
- Manuel olarak migration çalıştır

### Queue Not Working
- Supervisor'ın çalıştığından emin ol
- Logs'u kontrol et: `storage/logs/worker.log`
- Queue connection'ı kontrol et

---

## 📝 Önemli Notlar

1. **Storage Persistence**: Storage ve cache klasörleri volume'lerde saklanır
2. **Database Backups**: Dokploy'da backup özelliğini kullanın
3. **Log Rotation**: Log dosyaları otomatik rotate edilir
4. **Updates**: Dokploy üzerinden kolayca güncelleme yapabilirsiniz
5. **Rollback**: Her deployment'ta önceki versiyona dönebilirsiniz

---

## 🔗 Faydalı Komutlar

### Container'a Bağlanma
```bash
# Dokploy Console'dan veya SSH ile
docker exec -it cronjobs-app sh
```

### Artisan Komutları
```bash
php artisan cache:clear
php artisan queue:restart
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Log Görüntüleme
```bash
# Laravel logs
tail -f storage/logs/laravel.log

# Worker logs
tail -f storage/logs/worker.log

# Scheduler logs
tail -f storage/logs/scheduler.log
```

---

## 📚 Ek Kaynaklar

- [Dokploy Documentation](https://dokploy.com/docs)
- [Laravel Deployment](https://laravel.com/docs/deployment)
- [Docker Best Practices](https://docs.docker.com/develop/dev-best-practices/)

---

## ✅ Deployment Checklist

- [ ] Dokploy'da proje oluşturuldu
- [ ] Repository bağlandı
- [ ] Environment variables ayarlandı
- [ ] Domain ve SSL yapılandırıldı
- [ ] İlk deployment yapıldı
- [ ] Migration çalıştırıldı
- [ ] Storage link oluşturuldu
- [ ] Permissions ayarlandı
- [ ] Health checks çalışıyor
- [ ] Logs kontrol edildi
- [ ] Queue worker çalışıyor
- [ ] Scheduler çalışıyor
- [ ] SSL sertifikası aktif
- [ ] Auto-deploy yapılandırıldı (opsiyonel)

---

**Son Güncelleme:** 2025-01-XX

