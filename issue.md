# [Task] UI/UX Optimization: Permission Grouping on Role Management

## 🎯 Objective (Tujuan)

Saat ini, tampilan pemilihan hak akses (Permission) pada halaman Create/Edit Role di Filament (berada pada fungsi `buildPermissionTabs`) terlihat kurang rapi. Permission hanya dikelompokkan pada level Modul (berdasarkan `module_id`), sehingga di dalam satu modul, semua permission menumpuk menjadi satu list yang sangat panjang dan sulit dibaca oleh user.

Tujuan dari task ini adalah **memperbaiki UI/UX dengan mengelompokkan kembali list permission berdasarkan "Fitur" di dalam masing-masing modul**.
Sebagai contoh: Jika di dalam modul `portal` terdapat fitur `menu_mgt`, maka semua action untuk `menu_mgt` (read, create, export, dll) harus dikelompokkan ke dalam satu "Card" atau "Fieldset" tersendiri yang terpisah dari fitur lainnya.

## 📝 Tasks (Daftar Pekerjaan)

### 1. Refactor Logika Grouping pada Schema Role

- Perhatikan metode/skema pada file form Role (`app/Filament/Resources/Roles/Schemas/RoleForm.php`).
- Saat ini, data di-_query_ per modul dan langsung dilempar ke satu komponen `CheckboxList`.
- Anda perlu memodifikasi logika pembacaan data ini. Karena nama permission sudah memiliki format `namamodul:fitur:action`, pecahlah string tersebut (misalnya dengan fungsi `explode` di PHP) untuk mengekstrak elemen kedua, yaitu nama **Fitur**.
- Lakukan proses _grouping_ (pengelompokan) _collection_ permission berdasarkan nama Fitur tersebut sebelum dirender ke tampilan.

### 2. Implementasi UI yang Lebih Baik (User Friendly)

- Setelah data berhasil dikelompokkan menjadi hierarki Modul $\rightarrow$ Fitur, ubah struktur _Schema_ Filament.
- Buatkan komponen UI pemisah di dalam Modul. Anda bisa menggunakan komponen Filament seperti `Fieldset`, `Section` kecil, atau `Grid` untuk setiap "Fitur".
- Di dalam wadah "Fitur" tersebut, barulah tampilkan daftar "Action" menggunakan _Checkbox_.

### 3. Perhatian Terhadap Flow Penyimpanan Filament (Catatan Teknis Penting)

- **Warning:** Pada framework Filament, memecah satu relasi database (`permissions`) menjadi banyak komponen `CheckboxList` yang terpisah-pisah terkadang dapat menimbulkan isu saat proses _save_. Filament mungkin hanya menyimpan nilai dari _CheckboxList_ terakhir yang di-render.
- **Tugas Tambahan:** Pikirkan solusi terbaik jika kendala tersebut terjadi. Beberapa cara yang umum digunakan:
    1. Menangani _state_ checkbox secara manual dengan `mutateFormDataBeforeSave` dan `mutateFormDataBeforeFill`.
    2. Atau, sekadar meng-override view kustom bawaan dari `CheckboxList` sehingga dari segi UI terlihat terkelompok, namun di balik layar tetap dianggap sebagai satu komponen oleh Filament.
       Silakan cari referensi dan pilih cara yang paling efektif tanpa menulis kode yang terlalu berbelit-belit (spaghetti code).

## ⚠️ Notes & Development Guidelines

- **Database Consistency:** Sebelum mengerjakan kodenya, **periksa tabel `permissions` di database**. Pastikan format _naming convention_-nya benar-benar konsisten menggunakan pemisah titik dua (`:`). Jika ada data lama yang tidak sesuai format, itu bisa menyebabkan _error_ saat fungsi `explode` dijalankan.
- **Lingkungan Docker (Sail):** Project ini beroperasi dengan Laravel Sail. Ingat bahwa seluruh perintah terminal (terutama migrasi, _tinkering_, atau testing) **WAJIB menggunakan `sail artisan`** dan bukan `php artisan` biasa.
- Tujuan akhir task ini adalah kenyamanan Admin. Buatlah antar muka senyaman dan semudah mungkin untuk dibaca.
