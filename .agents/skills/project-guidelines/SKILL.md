---
name: "project-guidelines"
description: "AI assistant untuk pengembangan portal sentralisasi, SSO, dan manajemen hak akses (Permission Mapping)"
version: "1.0"
---

# 1. Project Context & Objectives

Proyek ini bernama **IT-Framework CMS** (Application Management Portal). Berfungsi sebagai portal sentralisasi untuk berbagai sistem internal. Fokus utamanya adalah:

- Mengelola master data pengguna (`users`).
- Menjadi Identity Provider (IdP) untuk sistem anak menggunakan mekanisme **Single Sign-On (SSO)**.
- Mengelola pemetaan hak akses (Permission Mapping) baik secara _default_ (global) maupun spesifik per aplikasi/modul.

# 2. Tech Stack & Environment

- **OS & Environment:** Linux Ubuntu (Native local development, tidak menggunakan Docker/Laravel Sail).
- **Backend Framework:** Laravel.
- **Admin Panel & UI:** Filament v4 & Livewire.
- **Database:** MySQL.
- **Authentication & SSO:** Laravel Sanctum (menggunakan Bearer Token untuk otorisasi API ke sistem anak).

# 3. Database Architecture & Access Control

Sistem otorisasi menggabungkan struktur standar (mirip Spatie Permission) dengan custom pivot untuk aplikasi spesifik. Database menggunakan skema `aplication_management_portal`.

- **Tabel `users`:** Berisi data master (`id`, `nik`, `email`, `first_name`, `last_name`, `department_id`, `status: active/inactive/locked`).
- **Global / Default Roles:** Menggunakan tabel `roles`, `permissions`, `role_has_permissions`, `model_has_roles`, dan `model_has_permissions`. Ini menentukan hak akses dasar pengguna di dalam portal utama.
- **Per-Application Roles (Spesifik):** Menggunakan tabel custom `project_user_roles`. Relasi ini menghubungkan `user_id` dengan `role_id` secara spesifik pada sebuah aplikasi/modul tertentu (`module_id`).
- **Database Schema:**perhatikan pada folder ./database/migrations untuk melihat schema database.

# 4. Coding Standards & Conventions

- **Clean Code & To The Point:** Tulis kode yang rapi, efisien, dan tidak bertele-tele. Hindari _boilerplate_ atau komentar bawaan yang tidak perlu.
- **Dokumentasi Esensial:** Sertakan PHPDoc block atau komentar _inline_ yang singkat dan padat HANYA pada bagian logika yang kompleks (seperti saat meng-handle _token generation_ Sanctum atau _query filter_ hak akses).
- **Penamaan:** Gunakan _camelCase_ untuk variabel/fungsi, _PascalCase_ untuk Class/Model, dan _snake_case_ untuk nama kolom/tabel di database.
- **API Response:** Pastikan _endpoint_ SSO mengembalikan response JSON yang terstruktur, rapi, dan konsisten saat memvalidasi Bearer token.
