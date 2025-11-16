# E-Posyandu - Laravel Migration

**e-Posyandu** adalah sistem manajemen data kesehatan posyandu yang telah dimigrasikan dari PHP prosedural ke framework **Laravel 12.x**.

## Daftar Isi

- [Fitur Utama](#fitur-utama)
- [Instalasi & Setup](#instalasi--setup)
- [Konfigurasi Database](#konfigurasi-database)
- [Menjalankan Aplikasi](#menjalankan-aplikasi)
- [Modul & Routes](#modul--routes)
- [Strategi Password](#strategi-password)
- [Testing & Troubleshooting](#testing--troubleshooting)
- [Catatan Migrasi](#catatan-migrasi)

---

## Fitur Utama

✅ **Manajemen Pegawai** — CRUD staff dengan role dan data kontak  
✅ **Manajemen Pasien** — Data demografis pasien + catatan medis  
✅ **Manajemen Produk** — Inventori produk kesehatan dengan barcode dan gambar  
✅ **Laporan Medis** — Generate PDF catatan kesehatan pasien  
✅ **Manajemen User** — CRUD user dengan level akses (admin, kasir, dsb)  
✅ **Ubah Password** — Change password dengan validasi password lama  
✅ **Authentication** — Login dengan session-based auth; bcrypt + legacy MD5 fallback support  

---

## Instalasi & Setup

### 1. Clone Repository

```bash
git clone <repo-url>
cd e-posyandu
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Copy Environment File

```bash
cp .env.example .env
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Konfigurasi Database

Edit file `.env` dan sesuaikan dengan database legacy Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=posyandu_db
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Buat Symlink Storage (Untuk Upload Gambar)

```bash
php artisan storage:link
```

> **Catatan**: Perintah ini membuat symlink dari `storage/app/public` ke `public/storage`, sehingga file yang diupload dapat diakses via URL.

---

## Konfigurasi Database

Aplikasi ini menggunakan **database legacy yang tidak diubah**. Tidak ada migration yang harus dijalankan karena struktur tabel tetap sama dengan versi PHP lama.

**Database yang digunakan:**
- `users` (PK: `id_pegawai`) — User login, password (bcrypt/MD5), level akses
- `pegawai` — Data staff/pegawai
- `pasien` — Data pasien + fields demografi
- `medical_record` / tabel serupa — Catatan kesehatan pasien
- `produk` — Daftar produk dengan harga, stok, gambar
- `persediaan` — Tracking stok produk

> **Catatan Penting**: Jika diperlukan, Anda dapat membuat migration file untuk dokumentasi skema. Namun, aplikasi saat ini menggunakan database yang sudah ada tanpa perubahan struktur.

---

## Menjalankan Aplikasi

### Development Server

```bash
php artisan serve
```

Aplikasi akan berjalan di `http://127.0.0.1:8000`

### Login

- **URL**: `http://127.0.0.1:8000`
- **Username/Password**: Gunakan kredensial dari tabel `users` di database legacy
- **Catatan Password**: Sistem mendukung bcrypt (modern), MD5 (legacy), dan plaintext. Password akan otomatis di-rehash ke bcrypt saat login berhasil.

---

## Modul & Routes

### Tabel Routes

| Method | Path | Controller | Nama Route | Deskripsi |
|--------|------|------------|-----------|-----------|
| GET | `/` | AuthController | `login.form` | Login page |
| POST | `/login` | AuthController | `login` | Process login |
| GET | `/logout` | AuthController | `logout` | Logout |
| GET | `/home` | HomeController | `home` | Dashboard (protected) |
| — | **PEGAWAI** | — | — | — |
| GET | `/pegawai` | PegawaiController | `pegawai.index` | List staff |
| GET | `/pegawai/create` | PegawaiController | `pegawai.create` | Create form |
| POST | `/pegawai` | PegawaiController | `pegawai.store` | Store staff |
| GET | `/pegawai/{id}/edit` | PegawaiController | `pegawai.edit` | Edit form |
| PUT | `/pegawai/{id}` | PegawaiController | `pegawai.update` | Update staff |
| DELETE | `/pegawai/{id}` | PegawaiController | `pegawai.destroy` | Delete staff |
| — | **USERS** | — | — | — |
| GET | `/users` | UsersController | `users.index` | List users |
| GET | `/users/create` | UsersController | `users.create` | Create form |
| POST | `/users` | UsersController | `users.store` | Store user |
| GET | `/users/{id}/edit` | UsersController | `users.edit` | Edit form |
| PUT | `/users/{id}` | UsersController | `users.update` | Update user |
| DELETE | `/users/{id}` | UsersController | `users.destroy` | Delete user |
| — | **POSYANDU** | — | — | — |
| GET | `/posyandu` | PosyanduController | `posyandu.index` | List patients |
| GET | `/posyandu/create` | PosyanduController | `posyandu.create` | Create form |
| POST | `/posyandu` | PosyanduController | `posyandu.store` | Store patient |
| GET | `/posyandu/{id}` | PosyanduController | `posyandu.show` | Patient detail |
| GET | `/posyandu/{id}/edit` | PosyanduController | `posyandu.edit` | Edit form |
| PUT | `/posyandu/{id}` | PosyanduController | `posyandu.update` | Update patient |
| DELETE | `/posyandu/{id}` | PosyanduController | `posyandu.destroy` | Delete patient |
| — | **PRODUK** | — | — | — |
| GET | `/produk` | ProdukController | `produk.index` | List products |
| GET | `/produk/create` | ProdukController | `produk.create` | Create form |
| POST | `/produk` | ProdukController | `produk.store` | Store product |
| GET | `/produk/{id}/edit` | ProdukController | `produk.edit` | Edit form |
| PUT | `/produk/{id}` | ProdukController | `produk.update` | Update product |
| DELETE | `/produk/{id}` | ProdukController | `produk.destroy` | Delete product |
| — | **PASSWORD** | — | — | — |
| GET | `/password/change` | PasswordController | `password.form` | Change password form |
| POST | `/password/change` | PasswordController | `password.change` | Process password change |
| — | **LAPORAN** | — | — | — |
| GET | `/laporan/pasien/{id}/pdf` | LaporanController | `laporan.pasien.pdf` | Generate PDF medical record |

**Semua routes di atas dilindungi oleh middleware `auth` kecuali login dan logout.**

---

## Strategi Password

Aplikasi mendukung **migrasi password gradual** dari legacy ke modern:

### Deteksi Otomatis

- **Bcrypt** (modern): Password dengan prefix `$2y$` atau `$2a$`
- **MD5** (legacy): Password hex 32 karakter
- **Plaintext** (fallback): Password teks biasa (jarang; untuk compatibility)

### Rehashing pada Login

Saat user login dengan password lama (MD5/plaintext), sistem:
1. ✅ Validasi password lama (cocok dengan hash atau plaintext)
2. ✅ Buat hash bcrypt baru dari password input
3. ✅ Simpan hash bcrypt ke database
4. ✅ Set session untuk user login

Proses ini terjadi **otomatis di `AuthController@login()`**, sehingga user tidak perlu reset password. Migrasi terjadi secara gradual seiring user login.

### Ubah Password

Fitur **Ubah Password** tersedia di `/password/change` dan mendukung:
- Validasi password lama (bcrypt, MD5, plaintext)
- Hash password baru ke bcrypt
- Optional: Update legacy `admin` table jika ada (untuk backward compatibility)

---

## Testing & Troubleshooting

### Checklist Pre-Production

- [ ] **Database Connected**: Jalankan `php artisan tinker` dan exec `DB::connection()->getPdo()` untuk validasi koneksi
- [ ] **Storage Symlink**: Verifikasi `public/storage` exists (jalankan `php artisan storage:link` jika belum)
- [ ] **Login Test**: Login dengan user dari database legacy; verifikasi password di-rehash ke bcrypt
- [ ] **CRUD Test**: Test create/read/update/delete di minimal satu modul (contoh: pegawai)
- [ ] **File Upload**: Upload gambar produk; verifikasi file tersimpan di `storage/app/public/photos/produk/` dan accessible via `/storage/photos/produk/`
- [ ] **PDF Generation**: Generate laporan medis untuk pasien; verifikasi PDF terbuka
- [ ] **Flash Messages**: Test validasi form; verifikasi error messages tampil di UI
- [ ] **Logout**: Logout dan verifikasi session hilang, redirect ke login

### Issues Umum

#### 1. Error: "Class 'ezpdf' not found"
**Solusi**: Laporan PDF menggunakan legacy `class.ezpdf.php` di `modul/mod_laporan/`. Pastikan file tersebut ada di path yang benar, atau update `LaporanController` untuk menggunakan library PDF modern (contoh: `barryvdh/laravel-dompdf`).

#### 2. Error: "SQLSTATE[HY000]: General error: 1030"
**Solusi**: Database tidak terhubung. Verifikasi `.env` DB credentials match dengan server MySQL. Cek MySQL running.

#### 3. Image upload tidak muncul
**Solusi**: Jalankan `php artisan storage:link` untuk create symlink public storage.

#### 4. Password lama tidak valid
**Solusi**: Password stored sebagai plaintext di DB? Sistem fallback support plaintext, tapi check apakah password di `users.password` column cocok exact dengan input user (case-sensitive).

#### 5. Routes tidak ditemukan
**Solusi**: Jalankan `php artisan route:cache` untuk cache routes (production), atau clear cache dengan `php artisan route:clear`. Di development, `php artisan serve` auto-detect routes.

---

## Catatan Migrasi

### Apa yang Dipindahkan

| Komponen | Status | Catatan |
|----------|--------|---------|
| **Modul Pegawai** | ✅ Migrated | PegawaiController + views |
| **Modul Posyandu** | ✅ Migrated | PosyanduController + extended forms |
| **Modul Users** | ✅ Migrated | UsersController + MD5 password support |
| **Modul Produk** | ✅ Migrated | ProdukController + barcode + persediaan |
| **Modul Laporan** | ✅ Migrated | LaporanController + legacy ezpdf wrapper |
| **Modul Password** | ✅ Migrated | PasswordController + bcrypt + MD5 fallback |
| **Assets (CSS/JS)** | ✅ Migrated | Copied to `public/assets/`, `public/plugins/` |
| **Database** | ✅ Preserved | Legacy schema unchanged; no migrations applied |
| **Legacy PHP Files** | ✅ Deleted | All `modul/` directory removed |

### Struktur Project

```
e-posyandu/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php         (login/logout + password rehash)
│   │   │   ├── HomeController.php
│   │   │   ├── PegawaiController.php      (staff CRUD)
│   │   │   ├── PosyanduController.php     (patients CRUD)
│   │   │   ├── UsersController.php        (user management)
│   │   │   ├── ProdukController.php       (products CRUD)
│   │   │   ├── PasswordController.php     (password change)
│   │   │   └── LaporanController.php      (PDF reports)
│   │   └── Middleware/
│   ├── Models/
│   │   ├── User.php                       (PK: id_pegawai)
│   │   ├── Pegawai.php
│   │   ├── Pasien.php
│   │   └── Produk.php
│   └── ...
├── resources/
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php              (main layout + flash/errors)
│       │   ├── head.blade.php
│       │   ├── header.blade.php
│       │   └── footer.blade.php
│       ├── auth/
│       │   └── login.blade.php
│       ├── pegawai/                       (index, create, edit)
│       ├── posyandu/                      (index, create, show, edit)
│       ├── users/                         (index, create, edit)
│       ├── produk/                        (index, create, edit)
│       ├── password/
│       │   └── change.blade.php
│       └── home.blade.php
├── routes/
│   └── web.php                            (34 routes total)
├── public/
│   ├── assets/                            (Bootstrap, jQuery, etc)
│   ├── plugins/                           (DataTables, CKEditor, etc)
│   └── storage/                           (symlink to storage/app/public)
├── storage/
│   └── app/
│       └── public/
│           └── photos/
│               └── produk/                (product images)
├── config/
│   └── ...
└── .env                                   (database credentials)
```

### Fitur Tambahan Terbuka

- **Navigation Menu**: Update `resources/views/layouts/header.blade.php` untuk add links ke semua modul
- **Batch Password Migration**: Create Artisan command untuk rehash semua legacy passwords sekaligus
- **API Layer**: Tambahkan API routes (endpoints) untuk mobile/frontend integration
- **Testing**: Buat test suites (Unit/Feature tests) untuk validasi CRUD operations
- **Database Seeding**: Create factories dan seeders untuk test data

---

## Kontribusi

Proyek ini adalah hasil migrasi dari legacy PHP ke Laravel modern. Untuk kontribusi, silakan buat feature branch dan submit pull request.

## Credits

**Laravel Migration & Development by:**

- **Khairul Adha**
- Email: [r4dioz.88@gmail.com](mailto:r4dioz.88@gmail.com)
- Website: [www.rainbowcodec.com](https://www.rainbowcodec.com)

## License

Distributed under MIT License. See LICENSE file for details.

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
