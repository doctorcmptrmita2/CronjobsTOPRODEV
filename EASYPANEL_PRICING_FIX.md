# 💰 Pricing Sayfası Sorunu Çözümü

## ❌ Sorun

Pricing sayfası (`/pricing`) boş görünüyor veya hata veriyor.

**Neden:** Veritabanında planlar (Free, Pro) yok. Seeder çalışmamış.

## ✅ Çözüm

EasyPanel Console'da (app servisi) şu komutu çalıştır:

```bash
php artisan db:seed --class=PlanSeeder
```

Veya tüm seeder'ları çalıştır:

```bash
php artisan db:seed --force
```

## 📋 Kontrol

Seeder çalıştıktan sonra kontrol et:

```bash
php artisan tinker
```

Tinker'da:

```php
App\Models\Plan::all();
```

Çıktıda 2 plan görünmeli:
- Free Plan (5 jobs, 15 min interval)
- Pro Plan (100 jobs, 1 min interval)

## 🔄 Cache Temizleme

Seeder çalıştırdıktan sonra cache'leri temizle:

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

## ✅ Başarı Kontrolü

Pricing sayfasını yenile: `https://yourdomain.com/pricing`

Artık Free ve Pro plan kartları görünmeli!

---

**Not:** Eğer `AUTO_SEED=true` environment variable'ı set edilirse, her deploy'da otomatik olarak seeder çalışır.

