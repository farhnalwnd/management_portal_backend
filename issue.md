@iss# [Task] Form Validation Enhancement and Security Audit

## 🎯 Objective (Tujuan)

Melakukan optimalisasi project dengan fokus pada peningkatan kualitas data dan keamanan. Task ini bertujuan untuk meneliti kemungkinan adanya bug pada form input, serta memastikan aplikasi memiliki _security safety_ yang kuat, khususnya dalam menangani input dari pengguna.

## 📝 Tasks (Daftar Pekerjaan)

### 1. Memperbaiki dan Memperketat Validasi Filament

Validasi input saat ini perlu ditingkatkan agar lebih ketat dan mencegah data yang tidak sesuai atau tidak lengkap masuk ke dalam sistem.

- Telusuri file-file Resource, Page, dan Schema/Form pada direktori Filament.
- Terapkan aturan validasi bawaan Filament yang lebih spesifik pada setiap _field input_.
- Gunakan validasi seperti `required()`, `maxLength()`, `minLength()`, validasi format (misal `email()`, `numeric()`), hingga `regex()` atau `pattern` jika field membutuhkan format tertentu (seperti format NIK, nomor telepon, username, atau kode identitas khusus).
- **Penting:** Anda **wajib memeriksa file database** (seperti _migration_ dan _model_) untuk memastikan bahwa aturan validasi yang diterapkan di Filament (misalnya batasan karakter maksimal atau apakah suatu kolom _nullable_) sama dan sejalan dengan skema tabel di database.

### 2. Security Audit: XSS dan Injection

Memastikan aplikasi terhindar dari manipulasi data atau celah keamanan melalui _malicious payload_ yang dikirimkan oleh user.

- Lakukan pemeriksaan terhadap celah-celah yang berpotensi memicu serangan XSS (Cross-Site Scripting) atau SQL/Command Injection dari setiap inputan form user.
- Pastikan semua input sudah divalidasi dengan ketat dan ditangani (di-sanitize/escape) secara benar oleh framework sebelum disimpan ke database atau sebelum dirender kembali ke antarmuka pengguna (UI).
- Jika ditemukan potensi celah keamanan pada _flow_ penyimpanan data, segera perbaiki menggunakan fungsi keamanan standar Laravel dan Eloquent.

## ⚠️ Notes & Development Guidelines (Harap Diperhatikan)

- **Environment (Sail):** Project ini berjalan di atas Docker menggunakan Laravel Sail. Oleh karena itu, **seluruh eksekusi command harus menggunakan `sail artisan`** (contoh: `sail artisan test` atau `sail artisan route:list`), dan **bukan** `php artisan`.
- Pendekatan yang dilakukan harus menyeluruh ke berbagai form, namun kerjakan secara bertahap.
- Buatlah kode yang rapi dan sesuai dengan konvensi penulisan Laravel/Filament. Anda tidak perlu memikirkan perombakan arsitektur besar-besaran, cukup fokus pada validasi ketat dan penutupan celah _security_ dasar.
