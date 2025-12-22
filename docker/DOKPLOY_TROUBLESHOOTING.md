# 🔧 Dokploy Troubleshooting Guide

## ❌ Sorun: MySQL Bağlantı Hatası

### Belirtiler:
```
nc: getaddrinfo for host "mysql" port 3306: Name does not resolve
```

### Olası Nedenler ve Çözümler:

#### 1. MySQL Servisi Dokploy'da Ayrı Olarak Oluşturulmuş Olabilir

**Kontrol:**
- Dokploy Dashboard → Services → MySQL servisinin adını kontrol edin
- MySQL servisinin container adını not edin

**Çözüm:**
- `DB_HOST` environment variable'ını Dokploy'un oluşturduğu MySQL servis adına göre ayarlayın
- Örnek: Eğer MySQL servisi `cronjobs-mysql` ise, `DB_HOST=cronjobs-mysql` olarak ayarlayın

#### 2. Network Sorunu

**Kontrol:**
```bash
# App container'dan network kontrolü
docker exec -it cronjobs-app sh
ping mysql
# veya
nslookup mysql
```

**Çözüm:**
- Tüm servislerin aynı network'te olduğundan emin olun
- `dokploy.yml`'de network tanımını kontrol edin

#### 3. MySQL Servisi Henüz Başlamamış

**Kontrol:**
- Dokploy Dashboard → Services → MySQL servisinin durumunu kontrol edin
- MySQL servisinin loglarını kontrol edin

**Çözüm:**
- MySQL servisinin tamamen başlamasını bekleyin
- Health check'in geçtiğinden emin olun

#### 4. Dokploy'da MySQL Servisi Ayrı Olarak Oluşturulmalı

Eğer Dokploy'da MySQL servisi `dokploy.yml` içinde değil de ayrı bir servis olarak oluşturulmuşsa:

1. Dokploy Dashboard → Services → MySQL servisini oluşturun
2. MySQL servisinin container adını not edin
3. `DB_HOST` environment variable'ını bu adla güncelleyin
4. `dokploy.yml`'den MySQL servisini kaldırın (sadece app ve redis kalmalı)

---

## ❌ Sorun: `bash` Bulunamıyor

### Hata:
```
OCI runtime exec failed: exec failed: unable to start container process: exec: "bash": executable file not found in $PATH
```

### Çözüm:
Alpine Linux kullanıldığı için `bash` yerine `sh` kullanın:

```bash
# ❌ YANLIŞ
docker exec -it cronjobs-app bash

# ✅ DOĞRU
docker exec -it cronjobs-app sh
# veya
docker exec -it cronjobs-app /bin/sh
```

---

## ❌ Sorun: Environment Variables Çalışmıyor

### Kontrol:
1. Dokploy Dashboard → Environment Variables sekmesini kontrol edin
2. Tüm değişkenlerin doğru girildiğinden emin olun
3. Özellikle `DB_ROOT_PASSWORD` ve `DB_PASSWORD` değerlerini kontrol edin

### Çözüm:
- Environment variables'ı tekrar kaydedin
- Container'ı yeniden başlatın
- Logları kontrol edin: `docker logs cronjobs-app`

---

## ❌ Sorun: Health Check Başarısız

### Kontrol:
```bash
# Health check'i manuel test edin
docker exec -it cronjobs-app wget --quiet --tries=1 --spider http://localhost/health
```

### Çözüm:
- Nginx'in çalıştığından emin olun
- PHP-FPM'in çalıştığından emin olun
- `/health` route'unun çalıştığından emin olun

---

## ❌ Sorun: Migration Çalışmıyor

### Kontrol:
1. `AUTO_MIGRATE=true` ayarlandı mı?
2. MySQL bağlantısı çalışıyor mu?
3. Database oluşturuldu mu?

### Çözüm:
```bash
# Manuel migration çalıştırın
docker exec -it cronjobs-app sh
php artisan migrate --force
```

---

## 📋 Genel Kontrol Listesi

- [ ] MySQL servisi çalışıyor mu?
- [ ] Redis servisi çalışıyor mu?
- [ ] Tüm environment variables doğru mu?
- [ ] Network bağlantısı var mı?
- [ ] Health check'ler geçiyor mu?
- [ ] Loglar hatasız mı?
- [ ] Container'lar aynı network'te mi?

---

## 🔍 Debug Komutları

```bash
# Container durumunu kontrol et
docker ps

# Network'ü kontrol et
docker network ls
docker network inspect cronjobs-network

# MySQL bağlantısını test et
docker exec -it cronjobs-app sh
nc -z mysql 3306

# Environment variables'ı kontrol et
docker exec -it cronjobs-app sh
env | grep DB_

# Logları kontrol et
docker logs cronjobs-app
docker logs cronjobs-mysql
docker logs cronjobs-redis
```

---

## 💡 İpuçları

1. **Servis İsimleri:** Dokploy'da servis isimleri genellikle `{project-name}-{service-name}` formatındadır
2. **Network:** Tüm servisler aynı network'te olmalı
3. **Health Checks:** Health check'lerin geçmesini bekleyin
4. **Logs:** Her zaman logları kontrol edin
5. **Alpine Linux:** `bash` yerine `sh` kullanın

