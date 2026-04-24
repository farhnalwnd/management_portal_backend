# Management Portal Backend

Sistem administrasi portal untuk pengelolaan tersentralisasi, SSO, dan manajemen akses.

## Persyaratan Sistem
- Docker & Docker Compose
- Lingkungan pengembangan menggunakan **fvm** (Flutter Version Management) yang terintegrasi.

## Setup & Instalasi (Menggunakan Docker / Sail)

Proyek ini telah dikonfigurasi menggunakan Laravel Sail untuk kemudahan setup *environment* berbasis Docker.

1. **Clone repository:**
   ```bash
   git clone <repo_url>
   cd management_portal_backend
   ```

2. **Setup Environment:**
   Salin file konfigurasi `.env.example` menjadi `.env`.
   ```bash
   cp .env.example .env
   ```
   Pastikan variabel seperti `DB_CONNECTION`, port database (`FORWARD_DB_PORT`), `PGADMIN_PORT`, dan `SSO_PORTAL_URL` sudah terisi dengan benar (sudah tersinkronisasi di `.env.example`).

3. **Install Dependencies:**
   Jika Anda belum memiliki PHP/Composer lokal, gunakan image container kecil untuk meng-install dependensi awal:
   ```bash
   docker run --rm \
       -u "$(id -u):$(id -g)" \
       -v "$(pwd):/var/www/html" \
       -w /var/www/html \
       laravelsail/php84-composer:latest \
       composer install --ignore-platform-reqs
   ```

4. **Jalankan Docker Container:**
   ```bash
   ./vendor/bin/sail up -d
   ```

5. **Generate Application Key:**
   ```bash
   ./vendor/bin/sail artisan key:generate
   ```

6. **Migrasi & Seeding Database:**
   ```bash
   ./vendor/bin/sail artisan migrate --seed
   ```

## ⚠️ PERHATIAN: Penggunaan `sail artisan`

Mengingat kita menggunakan `fvm` di dalam alur pengembangan (yang dapat mempengaruhi *environment* path lokal), Anda **DIWAJIBKAN** untuk menggunakan `sail artisan` untuk seluruh eksekusi command Artisan, dan **jangan menggunakan `php artisan`**.

✅ **BENAR:**
```bash
sail artisan make:model User
```

❌ **SALAH:**
```bash
php artisan make:model User
```
*(Anda dapat mengkonfigurasi alias `alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'` untuk mempersingkat command)*.

## Database & Skema

Proyek ini menggunakan **PostgreSQL** (`pgsql`) sebagai database utamanya di dalam ekosistem Docker.

- **Database Name**: `internal_system`
- **Username**: `postgres`
- **Port Internal (Container)**: `5432`
- **Port Eksternal (Host)**: `5433` (Diatur menggunakan `FORWARD_DB_PORT` untuk mencegah bentrok dengan *service* postgres lokal).

**PGAdmin**
Untuk manajemen database via *browser*, proyek ini menyertakan container PGAdmin.
- Akses melalui browser di: `http://localhost:5050` (cek `PGADMIN_PORT`).
- Login default: `admin@example.com` / `admin` (atau sesuai yang di-*set* pada `.env`).
