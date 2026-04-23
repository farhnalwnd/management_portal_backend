# Issue: Penyesuaian Tema Medis untuk Dashboard Admin

## Deskripsi Tugas
Kita perlu mengubah tampilan visual (tema) dari portal manajemen agar lebih sesuai dengan identitas perusahaan medis. Saat ini, aplikasi masih menggunakan tema bawaan dari Filament (hitam dan putih). Tema bawaan ini perlu diganti dengan palet warna yang lebih profesional, bersih, dan merepresentasikan industri kesehatan (medical/healthcare).

## Tujuan Utama
1. **Mengganti Tema Bawaan:** Hapus atau sesuaikan pengaturan tema default Filament yang saat ini masih dominan hitam putih.
2. **Implementasi Warna Medis:** Terapkan palet warna yang cocok untuk perusahaan medis (misalnya kombinasi dominan biru bersih, cyan/hijau tosca, putih, dan abu-abu lembut).
3. **Fokus pada Satu Gaya:** Pastikan menggunakan satu panduan gaya yang konsisten di seluruh komponen UI. Kamu bisa mencari referensi gaya yang sesuai dengan menggunakan *skill* yang tersedia pada folder `.agent/skills/ui-ux-pro-max`.

## Referensi & Panduan Eksekusi
- **Pencarian Sistem Desain:** Kamu dapat memanfaatkan script yang ada di folder `.agent` untuk mendapatkan rekomendasi desain. Contohnya, jalankan pencarian sistem desain untuk "healthcare medical professional".
- **Kustomisasi Filament:** Eksplorasi dokumentasi Filament v4 mengenai kustomisasi tema (Panel Provider, modifikasi warna pada `theme.css`, dll).
- **Environment Docker (PENTING):** Project ini berjalan menggunakan ekosistem Docker (Laravel Sail). Oleh karena itu, command PHP biasa tidak dapat digunakan secara langsung.
  - ❌ *Jangan gunakan:* `php artisan ...` atau `npm run ...` secara langsung di host jika tidak didukung.
  - ✅ *Gunakan:* `sail artisan ...` atau `sail npm ...` untuk mengeksekusi perintah.

## Catatan Eksekusi
Tugas ini sengaja tidak dibuat terlalu detail agar memberikan ruang eksplorasi. Silakan cari referensi warna yang paling tepat, ubah konfigurasi Filament, build aset (jika diperlukan), dan pastikan hasilnya terlihat seperti aplikasi medis modern yang rapi dan dapat diandalkan. Selamat mengeksplorasi!
