# Peningkatan Tampilan Antarmuka Audit Log (Activity Log)

## Tujuan
Memperbaiki fitur Audit Log agar memiliki tampilan yang lebih baik, rapi, dan mudah dibaca oleh pengguna (Admin) di halaman panel Filament.

## Lingkungan Pengembangan (Penting!)
Project ini menggunakan **Laravel Sail**. Oleh karena itu, saat menjalankan perintah Artisan, **pastikan menggunakan `sail artisan`** (contoh: `./vendor/bin/sail artisan ...`) dan **bukan** `php artisan`.

## Task / Pekerjaan yang Harus Dilakukan

1. **Penambahan Badge pada Tabel Audit Log (Filament Resource)**
   - Pada halaman tabel (List) *Audit Activity*, modifikasi kolom `log_name` dan kolom `event`/action agar menggunakan *badge* UI Filament.
   - Atur pewarnaan (*color*) badge secara dinamis agar berbeda-beda menyesuaikan dengan teks/nilai dari `log_name` maupun aksi yang dilakukan (misalnya: hijau untuk create, kuning untuk update, merah untuk delete).

2. **Perbaikan Tampilan Detail (View Record) Audit Log**
   - Pada saat menekan aksi **View** untuk melihat detail riwayat, perbaiki tampilan struktur Infolist (atau View page), khususnya pada bagian yang menampilkan detail perubahan atribut (`properties` / `attribute changes`).
   - Buat agar bagian perubahan atribut tersebut terstruktur dan rapi dengan meng-handle 3 (tiga) kondisi *event* berikut:
     - **Jika aksi UPDATE**: Tampilkan dua bagian terpisah, yaitu atribut baru (data `attributes`) dan atribut lama (data `old`). Valuenya dalam database biasanya berupa: `{"attributes": {...}, "old": {...}}`.
     - **Jika aksi DELETE**: Tampilkan bagian atribut lama (data `old`) saja, karena data telah dihapus. Valuenya: `{"old": {...}}`.
     - **Jika aksi CREATE**: Tampilkan bagian atribut baru (data `attributes`) saja. Valuenya: `{"attributes": {...}}`.

## Catatan Tambahan
- Gunakan komponen bawaan Filament seperti `TextEntry`, `Section`, `KeyValueEntry`, atau skema Infolist lainnya untuk menyusun tampilan "View" yang rapi.
- Jangan lupa membersihkan cache komponen jika tampilan Filament tidak langsung berubah (gunakan `sail artisan filament:clear-cached-components`).
