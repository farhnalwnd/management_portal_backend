# Audit: Security Review & Improvement — Management Portal API & Cookie Auth

> Dokumen ini berisi hasil audit menyeluruh dari sisi **keamanan (security)** dan **kualitas kode (code quality)** pada sistem autentikasi berbasis HttpOnly Cookie dan API yang telah dibangun. Setiap temuan dilengkapi dengan penjelasan risiko dan rekomendasi perbaikan.

---

## 🏗️ Arsitektur Saat Ini

```
[Flutter App (Frontend)]
        ↓  HTTP + Cookie (kIsWeb)
        ↓  PersistCookieJar (native)
[Laravel API (Backend)]
    ├── PortalTokenMiddleware   → Inject cookie ke Authorization header
    ├── auth:sanctum            → Validasi token dari header
    ├── AuthController          → Login / Logout / SSO Ticket
    └── DashboardController     → /me & /my-dashboard
```

---

## 🔴 Critical — Harus Diperbaiki

### 1. `allowed_origins: ['*']` + `supports_credentials: true` di `config/cors.php`

**File:** `config/cors.php`

**Masalah:** Ini adalah kombinasi yang **dilarang secara spesifikasi browser** dan sangat berbahaya. Ketika `supports_credentials: true`, maka `allowed_origins` TIDAK BOLEH berisi wildcard `*`. Browser modern akan langsung memblokir request ini.

Selain itu, membuka CORS ke semua origin memungkinkan situs berbahaya manapun (misalnya `evil.com`) untuk membuat request ke API kamu dengan membawa cookie pengguna yang sudah login — inilah inti dari serangan **CSRF + CORS bypass**.

**Solusi:**
```php
// config/cors.php
'allowed_origins' => [
    env('FRONTEND_URL', 'http://localhost:3000'),
    env('PORTAL_URL', 'http://localhost'),
],
'supports_credentials' => true,
```

Definisikan `FRONTEND_URL` dan `PORTAL_URL` di file `.env` per environment.

---

### 2. Token Masih Bocor ke JSON Response

**File:** `app/Http/Service/AuthService.php` (baris 47)

**Masalah:** Meskipun cookie sudah diset sebagai `HttpOnly`, plaintext token masih dikembalikan di dalam body JSON response:

```php
return [
    'user' => new UserResource($user),
    'token' => $token, // ❌ BAHAYA: Token tidak boleh ada di sini
    'cookie' => $cookie,
];
```

Tujuan utama `HttpOnly` cookie adalah agar **JavaScript tidak bisa membaca token**. Jika token juga dikembalikan di JSON body, maka proteksi ini tidak ada artinya — JavaScript (dan potensial skrip XSS) tetap bisa mencuri token.

**Solusi:** Hapus `'token' => $token` dari return array.

```php
return [
    'user' => new UserResource($user),
    'cookie' => $cookie,
];
```

> **Catatan:** Frontend Flutter juga perlu diperbarui karena di `auth_service.dart` baris 35 masih mengambil `data['data']['token']` dan menyimpannya ke model.

---

### 3. Cookie Attributes Hardcoded untuk Production di AuthService

**File:** `app/Http/Service/AuthService.php` (baris 43)

**Masalah:** Atribut cookie `secure: true` dan `same_site: 'none'` di-hardcode. Ini menyebabkan **cookie tidak berfungsi di localhost** (HTTP), karena browser menolak cookie `Secure` pada koneksi non-HTTPS.

```php
// ❌ Saat ini
$cookie = Cookie::make('portal_access_token', $token, 0, '/', null, true, true, false, 'none');
```

**Solusi:** Gunakan nilai dari konfigurasi environment, seperti yang sudah ada di `config/session.php`:

```php
// ✅ Perbaikan
$cookie = Cookie::make(
    'portal_access_token', $token, 0, '/', null,
    config('session.secure'),   // null di local, true di prod
    true,
    false,
    config('session.same_site') // 'lax' di local, 'none' di prod (jika cross-site)
);
```

Dan di `.env`:
```
# Development
SESSION_SECURE_COOKIE=false
SESSION_SAME_SITE=lax

# Production (WAJIB HTTPS)
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=none
```

---

### 4. `SameSite: none` pada `Cookie::forget` di Logout — Hardcoded

**File:** `app/Http/Controllers/Api/AuthController.php` (baris 112)

**Masalah:** Sama dengan poin 3. Atribut cookie saat logout di-hardcode:

```php
$cookie = Cookie::forget('portal_access_token')->withSameSite('none')->withSecure(true);
```

**Solusi:** Samakan dengan konfigurasi session:
```php
$cookie = Cookie::forget('portal_access_token')
    ->withSameSite(config('session.same_site'))
    ->withSecure(config('session.secure', false));
```

---

## 🟡 Medium — Sebaiknya Diperbaiki

### 5. Tidak Ada Rate Limiting pada Endpoint Login

**File:** `routes/api.php`

**Masalah:** Endpoint `/v1/auth/login` tidak memiliki proteksi *rate limiting*. Ini membuka peluang serangan **brute force** — penyerang bisa mencoba ribuan kombinasi password tanpa hambatan.

**Solusi:** Tambahkan throttle middleware spesifik untuk login:

```php
// routes/api.php
Route::post('/v1/auth/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1'); // max 5 attempt per menit
```

Atau definisikan custom rate limiter di `AppServiceProvider`:
```php
RateLimiter::for('login', function (Request $request) {
    return Limit::perMinute(5)->by($request->input('email'));
});
```

---

### 6. Dead Code: Method CRUD Kosong di AuthController

**File:** `app/Http/Controllers/Api/AuthController.php`

**Masalah:** Ada 5 method CRUD boilerplate yang kosong (`index`, `store`, `show`, `update`, `destroy`). Method kosong ini tidak berguna, menambah noise kode, dan berpotensi menjadi **attack surface** di masa depan jika seseorang tidak sengaja mendaftarkan route ke method-method ini.

```php
public function index(){}   // ❌ Kosong
public function store() {}  // ❌ Kosong
// ... dst
```

**Solusi:** Hapus semua method yang tidak digunakan.

---

### 7. Return Type Hilang di Beberapa Method

**File:** `app/Http/Service/AuthService.php`, `app/Http/Controllers/Api/DashboardController.php`

**Masalah:** Method `login()`, `getUserLogin()` di `AuthService`, serta `me()` dan `index()` di `DashboardController` tidak memiliki return type declaration. Ini melanggar standar PHP modern (PSR-12) dan membuat kode sulit untuk di-refactor dan di-test.

**Solusi:**
```php
// AuthService
public function login(array $data): array|string { ... }
public function getUserLogin(): User|string { ... }

// DashboardController
public function me(): Response { ... }
public function index(): Response { ... }
```

---

### 8. Webhook Secret Memiliki Fallback Value yang Lemah

**File:** `config/services.php`

**Masalah:**
```php
'webhook_secret' => env('CATERA_WEBHOOK_SECRET', 'secret1234567890'),
```

Nilai default `'secret1234567890'` yang ada di config dapat terbaca oleh siapapun yang mengakses repository. Jika `CATERA_WEBHOOK_SECRET` tidak di-set di `.env` production, maka secret yang digunakan adalah nilai yang sudah bocor.

**Solusi:** Hapus fallback value, biarkan `null` jika tidak di-set. Handle kasusnya di kode.
```php
'webhook_secret' => env('CATERA_WEBHOOK_SECRET'),
```

Tambahkan validasi di `CreateRole.php` dan `EditRole.php`:
```php
$secret = config('services.catera.webhook_secret');
if (empty($secret)) {
    Log::error('CATERA_WEBHOOK_SECRET is not configured.');
    return;
}
```

---

### 9. Route `/v1/auth/refresh` Terdaftar tapi Tidak Ada Method-nya

**File:** `routes/api.php` (baris 8)

**Masalah:**
```php
Route::get('/v1/auth/refresh', [AuthController::class, 'refresh']); // ❌ Method tidak ada!
```

Route ini akan melempar error 500 (`Action App\Http\Controllers\Api\AuthController@refresh not defined`). Ini adalah **dead route** yang berbahaya.

**Solusi:** Hapus route ini jika memang belum diimplementasi, atau implementasikan method `refresh()` di `AuthController`.

---

### 10. Konstruktor Kosong yang Tidak Perlu

**File:** `app/Http/Service/AuthService.php`, `app/Http/Service/DashboardService.php`

**Masalah:** Kedua service memiliki `__construct()` kosong yang tidak diperlukan.

```php
public function __construct()
{
    // ❌ Tidak ada gunanya
}
```

**Solusi:** Hapus konstruktor kosong tersebut. Sesuai panduan PHP modern, jangan punya `__construct()` kosong tanpa parameter.

---

### 11. `use Illuminate\Support\Facades\Log` Tidak Digunakan

**File:** `app/Http/Service/AuthService.php`, `app/Http/Controllers/Api/AuthController.php`

**Masalah:** Import `Log` facade ada tapi tidak digunakan. Ini adalah dead code yang menyumbat namespace.

**Solusi:** Hapus import yang tidak digunakan. Jalankan `vendor/bin/pint --dirty` untuk otomatis membersihkannya.

---

## 🔵 Low — Improvement & Best Practice

### 12. `AuthService::login()` Menggunakan String sebagai Error Flag

**Masalah:** Pattern ini *fragile* dan tidak idiomatis di PHP/Laravel:
```php
if ($result === 'user not found') { ... }
if ($result === 'password not match') { ... }
```

Jika ada typo di string, bug-nya sangat sulit dilacak dan tidak ada type safety sama sekali.

**Solusi:** Gunakan Enum untuk merepresentasikan error state yang mungkin terjadi:

```php
enum AuthError: string
{
    case UserNotFound = 'user_not_found';
    case UserNotActive = 'user_not_active';
    case PasswordMismatch = 'password_mismatch';
}

// Penggunaan di controller
if ($result === AuthError::UserNotFound) { ... }
```

---

### 13. Frontend: `UserModel` Masih Punya Field `token`

**File:** `frontend/lib/features/auth/models/user_model.dart`

**Masalah:** Model `UserModel` masih memiliki field `token` opsional. Setelah autentikasi berbasis cookie, token seharusnya tidak pernah disimpan di sisi client. Keberadaan field ini mendorong pengembang berikutnya untuk "menggunakannya" padahal berbahaya.

**Solusi:** Hapus field `token` dari `UserModel` dan logika `data['data']['token']` di `auth_service.dart`.

---

### 14. Frontend: `PersistCookieJar` dengan `ignoreExpires: true`

**File:** `frontend/lib/core/config/api_config.dart` (baris 42)

**Masalah:**
```dart
final cookieJar = PersistCookieJar(
    ignoreExpires: true,  // ❌ Cookie expired pun tetap dikirim
    ...
);
```

Dengan `ignoreExpires: true`, cookie yang sudah expired tetap akan dikirim ke server. Ini membuat token yang sudah logout / expired di server tetap "dikirimkan", meskipun server akan menolaknya. Secara semantik ini tidak benar.

**Solusi:** Set ke `false` agar cookie expired tidak dikirim:
```dart
final cookieJar = PersistCookieJar(
    ignoreExpires: false,
    ...
);
```

---

### 15. Frontend: Log Error Membocorkan Detail Internal

**File:** `frontend/lib/features/auth/services/auth_service.dart`

**Masalah:**
```dart
return Result.failure('Unexpected error: $e'); // ❌ Bocorkan stack trace ke UI
```

Pesan error internal (`$e`) tidak seharusnya dikembalikan ke layer UI, apalagi ditampilkan ke pengguna.

**Solusi:** Log error secara internal, kembalikan pesan generik ke UI:
```dart
Log.e('[AuthService] Unexpected error: $e');
return Result.failure('Terjadi kesalahan, silakan coba lagi.');
```

---

## ✅ Hal yang Sudah Benar (Good Practices)

| Aspek | Status |
|---|---|
| Cookie menggunakan flag `HttpOnly: true` | ✅ Aman |
| Middleware priority dikonfigurasi dengan benar di `bootstrap/app.php` | ✅ Benar |
| `PortalTokenMiddleware` tidak menimpa header `Authorization` yang sudah ada | ✅ Aman |
| Validasi request menggunakan `AuthRequest` (Form Request) | ✅ Benar |
| Response error autentikasi mengembalikan 401 (bukan 403) | ✅ Benar |
| SSO Ticket memiliki TTL (expired dalam 1 menit) | ✅ Aman |
| SSO Ticket dihapus setelah digunakan (one-time use) | ✅ Aman |
| Frontend menggunakan `dio` + `CookieManager` untuk manajemen cookie otomatis | ✅ Benar |
| Frontend menggunakan `flutter_secure_storage` untuk cache profil | ✅ Benar |
| Frontend memiliki pemisahan layer Repository → Service | ✅ Baik |

---

## 📋 Ringkasan Prioritas Pengerjaan

| No. | Temuan | Prioritas | Lokasi |
|---|---|---|---|
| 1 | CORS wildcard + credentials | 🔴 Critical | `config/cors.php` |
| 2 | Token bocor di JSON response | 🔴 Critical | `AuthService.php` |
| 3 | Cookie attr hardcoded (`secure`, `same_site`) | 🔴 Critical | `AuthService.php` |
| 4 | Cookie::forget hardcoded | 🔴 Critical | `AuthController.php` |
| 5 | Tidak ada rate limiting login | 🟡 Medium | `routes/api.php` |
| 6 | Dead code method CRUD kosong | 🟡 Medium | `AuthController.php` |
| 7 | Return type hilang | 🟡 Medium | Service & Controller |
| 8 | Webhook secret ada fallback lemah | 🟡 Medium | `config/services.php` |
| 9 | Route `/refresh` tidak ada handler | 🟡 Medium | `routes/api.php` |
| 10 | Konstruktor kosong tidak perlu | 🟡 Medium | Service classes |
| 11 | Import `Log` tidak digunakan | 🟡 Medium | AuthService & AuthController |
| 12 | String sebagai error flag | 🔵 Low | `AuthService.php` |
| 13 | `UserModel.token` di Flutter | 🔵 Low | `user_model.dart` |
| 14 | `ignoreExpires: true` di CookieJar | 🔵 Low | `api_config.dart` |
| 15 | Error detail bocor ke UI | 🔵 Low | `auth_service.dart` |

---

> **Note untuk implementasi:** Pastikan semua perubahan yang menyentuh Docker/Sail environment diuji menggunakan perintah `./vendor/bin/sail artisan` bukan `php artisan`. Setelah mengubah konfigurasi, jalankan `./vendor/bin/sail artisan optimize:clear` agar cache konfigurasi lama tidak mengganggu.
