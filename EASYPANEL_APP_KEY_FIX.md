# 🔑 APP_KEY Sorunu Çözümü - EasyPanel

## ❌ Sorun

EasyPanel'de `.env` dosyası yok, environment variables direkt container'a enjekte ediliyor. `php artisan key:generate` komutu `.env` dosyasına yazmaya çalıştığı için hata veriyor.

## ✅ Çözüm

### Yöntem 1: Manuel APP_KEY Oluşturma (Önerilen)

EasyPanel Console'da (app servisi) çalıştır:

```bash
php -r "echo 'base64:' . base64_encode(random_bytes(32));"
```

Çıktıyı kopyala (örn: `base64:XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX`)

### Yöntem 2: Lokal Makinede Oluştur

Lokal Laravel projende:

```bash
php artisan key:generate --show
```

Çıktıyı kopyala.

### Yöntem 3: Online Generator

https://generate-random.org/api-key-generator?count=1&length=32&type=base64

Base64 formatında 32 byte key oluştur ve başına `base64:` ekle.

---

## 📝 EasyPanel'de APP_KEY Ekleme

1. EasyPanel Dashboard'a git
2. Projen → Service (cj) → **Environment Variables** sekmesine git
3. **"+ Add Variable"** butonuna tıkla
4. **Name:** `APP_KEY`
5. **Value:** Oluşturduğun key'i yapıştır (örn: `base64:XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX`)
6. **Save** butonuna tıkla
7. Service'i **yeniden başlat** (Restart)

---

## ✅ Kontrol

Service yeniden başladıktan sonra, Console'da kontrol et:

```bash
echo $APP_KEY
```

Çıktı görünmeli. Sonra:

```bash
php artisan config:clear
php artisan config:cache
```

---

## 🚀 Hızlı Çözüm Scripti

EasyPanel Console'da çalıştır:

```bash
# APP_KEY oluştur ve göster
php -r "echo 'APP_KEY=base64:' . base64_encode(random_bytes(32)) . PHP_EOL;"
```

Çıktıyı kopyala ve EasyPanel Environment Variables'a ekle.

---

## ⚠️ Önemli Notlar

1. **APP_KEY değiştirilmemeli** - Mevcut şifrelenmiş veriler bozulur
2. **Her environment için farklı key** kullan (production, staging, vb.)
3. **Key'i güvenli tut** - Git'e commit etme, sadece environment variable olarak sakla

---

## 🔄 Container Yeniden Başlatma

APP_KEY ekledikten sonra:

1. EasyPanel Dashboard'da service'i **Stop** et
2. **Start** et
3. Veya **Restart** butonuna tıkla

---

## ✅ Başarı Kontrolü

APP_KEY doğru eklendiyse:

```bash
# Bu komut hata vermemeli
php artisan config:cache

# Health check çalışmalı
curl http://localhost/health
```

Ana sayfa artık 500 hatası vermemeli!

---

**Son Güncelleme:** 23 Aralık 2025

