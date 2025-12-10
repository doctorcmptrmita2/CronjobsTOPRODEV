# Cronjobs.to – Project Rules (rules.md)

Bu dosya, Cursor AI ve projeye katkı veren herkes için **tek kaynaktan geçen kurallar** dosyasıdır.  
Amaç: Cronjobs.to’yu, “sadece URL çağıran basit cron servisi” olmaktan çıkarıp, **para kazanabilir**, uzun vadeli bir SaaS ürünü haline getirmek.

---

## 1. Proje Kimliği

- Proje adı: **Cronjobs.to**
- Kısa tanım: Kullanıcıların HTTP endpoint’lerini belirli aralıklarla tetikleyebildiği, loglarını izleyebildiği, hata durumlarında uyarı alabileceği **cron job scheduler SaaS**.
- Hedef kitle:
  - Geliştiriciler
  - Küçük/mid-size SaaS sahipleri
  - WordPress, Laravel, Node vb. backend kullanıp jobları kendi sunucusuna yıkmak istemeyenler

---

## 2. Teknoloji Seçimleri (MVP için sabit)

- Backend: **Laravel 10+**
- PHP: **8.2+**
- Veritabanı: **MySQL**
- Queue & Cache: **Redis**
- Frontend: **Blade + Tailwind CSS**
- Queue driver: `redis`
- Zamanlama: Laravel Scheduler (`app/Console/Kernel.php`)

Bu MVP aşamasında:

- **FastAPI, Python, Node.js** gibi ek backend teknolojileri **kullanılmayacak**.
- İleride “Runner Service” (Python/FastAPI) eklenebilir ama şu an **scope dışı**.

---

## 3. Mimari ve Kod Organizasyonu

- Tüm business logic:
  - Mümkün olduğunca **Service** katmanına itilecek:
    - `App\Services\JobSchedulerService`
    - `App\Services\JobRunnerService`
- Controller’lar ince tutulacak, sadece:
  - Request validation
  - Service çağrıları
  - Response / view seçimi
  yapacak.
- Eloquent Modeller:
  - `User`, `Plan`, `Job`, `JobRun`, `ApiToken`
  - Mutlaka ilişkiler tanımlı olacak (`user()->jobs()`, `job()->runs()` vs.).
- Migration’lar:
  - Gerçekçi column tipleri (gereksiz `text` veya `longText` bolluğundan kaçın).
  - Index’ler: `user_id`, `job_id`, `next_run_at`, `ran_at` gibi alanlarda gerektikçe index.
- Kod standardı:
  - PSR-12
  - Anlaşılır method isimleri
  - Gereksiz abstraction yok; ama tekrar eden kodlar service/layer’a alınacak.

---

## 4. MVP Feature Scope (Kapsam)

**MVP’de mutlaka olacak:**

1. **Auth & Hesap:**
   - Register / Login / Logout
   - Forgot/reset password
   - Kullanıcı profili: timezone, notification email, plan bilgisi

2. **Plan & Limitler (Free plan):**
   - `max_jobs`: en fazla job sayısı (örn: 5)
   - `min_interval_minutes`: minimum interval (örn: 15 dk)
   - `log_retention_days`: log saklama süresi (örn: 30 gün)
   - Bu limitler backend’de **gerçekten enforce edilecek**:
     - Free kullanıcı 6. job’ı oluşturamaz.
     - Free kullanıcı interval’i 5 dakikaya çekemez (min 15 dk).

3. **Job Yönetimi:**
   - Job oluşturma / düzenleme / silme
   - İş alanları:
     - URL
     - HTTP method
     - Headers (JSON)
     - Body
     - Timeout
     - Beklenen status aralığı (200–299 default)
     - Schedule: Interval / Daily / Weekly / Cron
     - Timezone
     - Aktif / pasif toggle
     - Max retries
     - Failure alert threshold
   - Job listesi (dashboard + jobs index)
   - Job detay sayfası + “Run now” butonu

4. **Çalıştırma Motoru:**
   - `cronjobs:dispatch-due` komutu:
     - Her dakika çalışacak
     - `next_run_at <= now` olan aktif jobları queue’ya atacak
   - Queue job `RunJob`:
     - HTTP isteğini atacak
     - Süreyi ölçecek
     - `JobRun` log kaydı oluşturacak
     - `Job` üzerindeki:
       - `last_run_at`
       - `last_status_code`
       - `last_duration_ms`
       - `consecutive_failures`
       - `next_run_at`
       alanlarını güncelleyecek

5. **Loglama:**
   - Her run için:
     - `ran_at`
     - `status_code`
     - `duration_ms`
     - `success` (boolean)
     - `error_message`
     - `response_snippet` (ilk ~500 char)
   - Job detay sayfasında son run’ların listesi

6. **Basit Uyarı Sistemi:**
   - `consecutive_failures >= failure_alert_threshold` ise:
     - Kullanıcıya email atılacak (Mailable).
   - Kullanıcı bazında:
     - `alert_email_enabled` + `notification_email` kullanılacak.

7. **Admin Panel (Basic):**
   - Total kullanıcı
   - Total job
   - Son 24 saat total run
   - Son 24 saat fail run
   - En çok hata veren job listesi
   - Kullanıcı listesi
   - Job listesi

---

## 5. Scope Dışı (Şimdilik YOK)

MVP’de **özellikle yapılmayacak olanlar**:

- Ödeme sistemi (Stripe, Paddle vs.)
- Gelişmiş chart kütüphaneleri (complex JS graph library)
- Çoklu dil desteği (i18n)
- Gelişmiş API (dışarıya açılmış full REST API)
- Subdomain/tenant bazlı complex multi-tenancy (tek base domain + user_id ile izolasyon yeterli)
- FastAPI / Python runner servisi

---

## 6. Dürüst Görüş / Ürün Gerçekliği (Mutlaka Dikkate Al)

**Bu bölüm, proje boyunca asla unutulmaması gereken “gerçeklik kuralı”dır.**

> Sadece “URL çağıran basit cron servisi” yaparsan:
> - Teknik olarak kolay,
> - Ama piyasada çok rakip var, **paraya çevirmen zor**.

Yani:

- “Sıradan bir cron-as-a-service” inşa etmek bu projenin hedefi **DEĞİL**.
- Her özellik, şu soruya cevap vermeli:
  > “Bu, Cronjobs.to’yu mevcut çözümlerden nasıl farklılaştırıyor?”

Bu nedenle **fark yaratmak için minimum şu 3 alanda özen şart**:

1. **Çok temiz ve developer-friendly API + doküman**
   - Gelecekte eklenecek REST API:
     - Tutarlı endpoint isimleri
     - Net rate limitler
     - API key mantığı
   - Örnek kodlarla basit entegrasyon anlatımı
   - Dökümanları okuyan bir developer:
     - “Bu çok net, 10 dakikada entegre ederim” demeli.

2. **Çok iyi uptime + status page (geleceğe yönelik kural)**
   - Projeyi tasarlarken:
     - Health check mantığı
     - Worker’ların düzgün çalışıp çalışmadığını izleme
     - İleride status sayfası açmaya uygun monitoring altyapısı
   - Admin tarafında:
     - “Sistem sağlığı”na dair metrikler (run sayısı, error oranı, vb.)

3. **Basit ama şık bir UI (grafikli loglar, response time grafiği vs.)**
   - MVP’de:
     - Şimdilik tablolar + basit istatistik kartları yeterli.
   - Ancak:
     - Tüm UI, ileride:
       - Response time grafikleri,
       - Success/fail oran grafikleri,
       - Per-job chart’lar
     eklenebilecek şekilde düşünülmeli.
   - Tasarım prensipleri:
     - Temiz, modern, aşırı karışık olmayan layout
     - Geliştirici dostu (her şey hızlı okunabilir, kompleks form yokmuş gibi basit hissettirmeli)

**Özet Kural:**

- “Çalışıyor olması” tek başına başarı sayılmayacak.
- Her adımda:
  - **Kullanıcı deneyimi**
  - **Geliştirici deneyimi (DX)**
  - **Uzun vadeli monetizasyon**  
  göz önünde tutulacak.

---

## 7. Cursor AI İçin Operasyon Kuralları

- Mevcut dosyaları güncellerken:
  - Mümkünse **diff mantığında** çalış:
    - “Şu dosyanın tamamı yerine şu kısmı değiştir” yaklaşımı.
- Rastgele dosya/klasör yaratma:
  - Sadece gerçekten ihtiyaç varsa yeni dosya aç.
  - Mevcut mimariyi bozmadan ilerle.
- Placeholder kod yazma:
  - `// TODO` dolu iskeletler yerine:
    - MVP’de **çalışır implementasyon** üret.
- Gereksiz abstraction veya premature optimization’dan kaçın:
  - Basit ve okunabilir bir çözüm, aşırı soyutlanmış mimariden daha değerlidir.

---

Bu `rules.md`, proje boyunca **değişmez referans** kabul edilecek.  
Yeni ihtiyaçlar doğdukça genişletilebilir; ancak buradaki **temel prensipler** (özellikle Dürüst Görüş / Ürün Gerçekliği bölümü) ihlal edilmemelidir.

