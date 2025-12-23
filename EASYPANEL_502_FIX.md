# 🔧 502 Bad Gateway Hatası Çözümü

## ❌ Sorun

Cloudflare 502 Bad Gateway hatası veriyor. Bu, Cloudflare'in çalıştığını ama origin server'ın (EasyPanel uygulaması) yanıt vermediğini gösterir.

## 🔍 Kontrol Listesi

### 1. EasyPanel Servis Durumu

EasyPanel Dashboard'da kontrol et:
- ✅ App servisi **yeşil** (healthy) olmalı
- ✅ Tüm servisler çalışıyor olmalı
- ❌ Eğer kırmızı/sarı ise → Restart et

### 2. Cloudflare DNS Ayarları

Cloudflare Dashboard → DNS → Records:

**A Kaydı (IP ile):**
```
Type: A
Name: cronjobs.to (veya @)
Content: EasyPanel sunucunun IP adresi
Proxy: Proxied (turuncu bulut) ✅
TTL: Auto
```

**VEYA CNAME Kaydı (Domain ile):**
```
Type: CNAME
Name: cronjobs.to (veya @)
Target: cronprojesi-cj.lc58dd.easypanel.host
Proxy: Proxied (turuncu bulut) ✅
TTL: Auto
```

**Önemli:** 
- `www` subdomain için ayrı kayıt ekle
- Her iki kayıt da **Proxied** (turuncu bulut) olmalı

### 3. EasyPanel Domain Ayarları

EasyPanel Dashboard → Service → Domains:

**Domain Ayarları:**
- Host: `cronjobs.to` (sadece domain, `https://` olmadan)
- Path: `/`
- Protocol: `HTTP`
- Port: `80`
- Compose Service: `app`
- HTTPS: ✅ Aktif (Let's Encrypt SSL)

### 4. Origin Server Kontrolü

EasyPanel Console'da (app servisi) çalıştır:

```bash
# Health check
curl http://localhost/health

# Veya
curl http://localhost/up
```

**Beklenen Çıktı:**
```json
{"status":"ok","timestamp":"...","service":"cronjobs"}
```

Eğer hata veriyorsa → APP_KEY veya diğer sorunlar var

### 5. Log Kontrolü

EasyPanel Console'da:

```bash
# Son hataları gör
tail -n 50 /var/www/html/storage/logs/laravel.log

# Nginx error log
tail -n 50 /var/log/nginx/error.log
```

### 6. Cloudflare SSL/TLS Ayarları

Cloudflare Dashboard → SSL/TLS:

- **SSL/TLS encryption mode:** Full (strict) veya Full
- **Always Use HTTPS:** ✅ Aktif
- **Minimum TLS Version:** 1.2

### 7. Cloudflare Origin Certificate (Opsiyonel)

Eğer "Full (strict)" kullanıyorsan:

1. EasyPanel'de SSL certificate'i al
2. Cloudflare Dashboard → SSL/TLS → Origin Server
3. Origin Certificate oluştur ve EasyPanel'e ekle

## 🚀 Hızlı Çözüm Adımları

### Adım 1: EasyPanel Servisini Kontrol Et

```bash
# EasyPanel Console'da
curl http://localhost/health
```

Eğer çalışmıyorsa:
```bash
php artisan config:clear
php artisan cache:clear
```

### Adım 2: Cloudflare DNS'i Kontrol Et

Cloudflare Dashboard'da:
- DNS kayıtlarının doğru olduğundan emin ol
- Proxy durumunun **Proxied** olduğundan emin ol
- DNS propagation için 5-10 dakika bekle

### Adım 3: Cloudflare Cache Temizle

Cloudflare Dashboard → Caching → Purge Everything

### Adım 4: Test Et

```bash
# Direct IP ile test (Cloudflare bypass)
curl -H "Host: cronjobs.to" http://EASYPANEL_IP/

# Cloudflare üzerinden test
curl https://cronjobs.to/health
```

## 🔍 Sorun Giderme

### Problem: DNS Propagation

**Çözüm:**
```bash
# DNS'i kontrol et
nslookup cronjobs.to
dig cronjobs.to

# Eğer yanlış IP gösteriyorsa, DNS propagation bekleniyor (5-10 dakika)
```

### Problem: Origin Server Yanıt Vermiyor

**Çözüm:**
1. EasyPanel Dashboard'da servisi restart et
2. Health check çalıştır: `curl http://localhost/health`
3. Logları kontrol et

### Problem: SSL Sertifika Hatası

**Çözüm:**
1. Cloudflare SSL/TLS → Full (strict yerine Full kullan)
2. Veya EasyPanel'de SSL certificate'i yenile

### Problem: Port/Protocol Yanlış

**Çözüm:**
EasyPanel Domain ayarlarında:
- Protocol: `HTTP` (HTTPS değil!)
- Port: `80` (443 değil!)
- EasyPanel otomatik SSL yönetir

## ✅ Başarı Kontrolü

Tüm adımlar tamamlandıktan sonra:

1. **Direct test (Cloudflare bypass):**
   ```bash
   curl -H "Host: cronjobs.to" http://EASYPANEL_IP/health
   ```

2. **Cloudflare üzerinden test:**
   ```bash
   curl https://cronjobs.to/health
   ```

3. **Tarayıcıdan test:**
   - `https://cronjobs.to` açılmalı
   - 502 hatası gitmeli

## 📝 Önemli Notlar

- DNS değişiklikleri 5-10 dakika sürebilir
- Cloudflare cache'i temizlemek gerekebilir
- EasyPanel servisinin çalışıyor olması gerekir
- Origin server'ın health check'i geçmesi gerekir

---

**Son Güncelleme:** 23 Aralık 2025

