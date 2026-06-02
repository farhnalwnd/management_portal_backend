# Management Portal Backend

Sistem administrasi portal untuk pengelolaan tersentralisasi, SSO, dan manajemen akses.

## Persyaratan Sistem
- Docker & Docker Compose

## Setup & Instalasi (Menggunakan Docker / Sail)

Proyek ini menggunakan Laravel Sail untuk environment berbasis Docker.

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
   Pastikan variabel seperti `DB_CONNECTION`, port database (`FORWARD_DB_PORT`), `PGADMIN_PORT`, dan `SSO_PORTAL_URL` sudah sesuai.

3. **Install Composer Dependencies:**
   Jalankan container temporary untuk install dependensi awal:
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

7. **Install Node Dependencies & Build Assets:**
   ```bash
   ./vendor/bin/sail npm install
   ./vendor/bin/sail npm run build
   ```

## ⚠️ PERHATIAN: Penggunaan `sail`

Untuk menjaga konsistensi environment, gunakan `sail` untuk seluruh eksekusi command (Artisan, Composer, NPM). Jangan gunakan command lokal seperti `php` atau `npm` langsung di host.

*(Tips: Buat alias untuk mempermudah: `alias sail="./vendor/bin/sail"`)*

✅ **BENAR:**
```bash
sail artisan make:model User
sail npm run dev
```

❌ **SALAH:**
```bash
php artisan make:model User
npm run dev
```

## Database & Skema

Proyek ini menggunakan **PostgreSQL** (`pgsql`) sebagai database utama.

- **Database Name**: `internal_system`
- **Username**: `postgres`
- **Port Internal (Container)**: `5432`
- **Port Eksternal (Host)**: `5433` (Diatur menggunakan `FORWARD_DB_PORT` untuk mencegah bentrok dengan postgres lokal).

**PGAdmin**
Untuk manajemen database via browser:
- Akses: `http://localhost:5050`
- Login: `admin@example.com` / `admin` (atau sesuai yang di-set pada `.env`).

## Mengakses Aplikasi

Setelah semua container berjalan, akses aplikasi melalui:
- **Laravel Application**: `http://localhost` (atau port yang di-set di `APP_PORT`)
- **PGAdmin**: `http://localhost:5050`

### Default Login (Setelah Seeding)

| Email | Password | Role |
|---|---|---|
| `superadmin@example.com` | `password` | super_admin |

Akun tambahan (random) bisa dicek langsung di database via PGAdmin atau Tinker (`sail artisan tinker` -> `User::all()`).

## Development Workflow

### Menjalankan Development Server
```bash
sail up -d
sail npm run dev
```

### Menjalankan Queue Worker
```bash
sail artisan queue:work
```

### Melihat Logs
```bash
sail artisan pail
```

### Menjalankan Semua Services Development (Concurrent)
Gunakan composer script yang sudah tersedia:
```bash
sail composer dev
```
Script ini akan menjalankan: server, queue worker, logs (pail), dan vite secara bersamaan.

## Testing

Jalankan test suite:
```bash
sail artisan test
```

Atau gunakan composer script:
```bash
sail composer test
```

## Code Quality

Format code menggunakan Laravel Pint:
```bash
sail php vendor/bin/pint
```

## Docker Commands

### Menghentikan Container
```bash
sail down
```

### Restart Container
```bash
sail restart
```

### Melihat Status Container
```bash
sail ps
```

### Membuka Shell di Container
```bash
sail shell
```

### Menjalankan Tinker
```bash
sail artisan tinker
```

## Troubleshooting

### Port Sudah Digunakan
Jika port 5433 atau 5050 sudah digunakan, ubah nilai `FORWARD_DB_PORT` atau `PGADMIN_PORT` di file `.env`.

### Permission Denied
Jika mengalami masalah permission, pastikan user ID dan group ID sudah sesuai saat install dependencies.

### Container Tidak Bisa Start
```bash
sail down
docker system prune -f
sail up -d
```

### Frontend Changes Tidak Muncul
Build ulang assets:
```bash
sail npm run build
```

Atau jalankan dalam mode development:
```bash
sail npm run dev
```

## Dokumentasi Tambahan

- [Laravel Documentation](https://laravel.com/docs)
- [Filament Documentation](https://filamentphp.com/docs)
- [Laravel Sail Documentation](https://laravel.com/docs/sail)
- [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)
