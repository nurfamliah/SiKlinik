# Sistem Klinik Sederhana

Aplikasi web manajemen klinik kecil, dibuat untuk Tugas Besar Praktikum Pemrograman Web.
Dibangun dengan PHP native (prosedural) + MySQL (mysqli) + Bootstrap, tanpa framework.

## Deskripsi

Sistem ini membantu mengelola operasional klinik kecil, mulai dari data dokter, pasien,
jadwal praktik, rekam medis, resep obat, sampai pembayaran. Setiap kunjungan pasien
tercatat dalam satu rekam medis yang menjadi pusat data — dari satu rekam medis bisa
dilihat resep obat dan status pembayaran yang terkait.

## Fitur

- **Login & Session** — petugas harus login dulu sebelum bisa mengakses dashboard.
- **Cookie** — menyimpan dan menampilkan waktu login terakhir (`last_login`).
- **CRUD lengkap** untuk 6 modul data:
  - Dokter (dengan upload foto)
  - Pasien (dengan validasi NIK 16 digit)
  - Jadwal Praktik (dropdown dokter dari database)
  - Rekam Medis (halaman pusat, terhubung ke resep & pembayaran)
  - Resep Obat
  - Pembayaran
- **Validasi input** di sisi client (HTML5 required + custom validity message) dan
  di sisi server (cek kosong, cek format NIK, cek angka).
- **Penanganan error database** — setiap query dicek hasilnya, kalau gagal pesan error
  MySQL ditampilkan.
- **Dashboard ringkasan** — total pasien, total dokter, jadwal praktik hari ini.
- **Pencarian pasien** langsung di tabel tanpa reload halaman (vanilla JavaScript).
- **Responsive** — pakai Bootstrap grid + meta viewport.

## Struktur Folder

```
sistem-klinik/
├── assets/
│   ├── style.css
│   └── foto_dokter/        (folder upload foto dokter)
├── config.php              (koneksi database)
├── membuat_db.php          (bikin database db_klinik)
├── membuat_tabel.php       (bikin semua tabel + akun admin default)
├── sidebar.php             (menu sidebar dashboard)
├── login.php / ceklogin.php / logout.php
├── index.php               (dashboard)
├── tabel-dokter.php + dokter_tampil/insert/edit/update/hapus.php
├── tabel-pasien.php + pasien_tampil/insert/edit/update/hapus.php
├── tabel-jadwal.php + jadwal_tampil/insert/edit/update/hapus.php
├── tabel-rekam-medis.php + rekammedis_tampil/insert/edit/update/hapus.php
├── tabel-resep.php + resep_tampil/insert/edit/update/hapus.php
└── tabel-pembayaran.php + pembayaran_tampil/insert/edit/update/hapus.php
```

## Cara Install Lokal (XAMPP)

1. Copy folder `sistem-klinik` ke dalam folder `htdocs` XAMPP.
   - Windows: `C:\xampp\htdocs\sistem-klinik`
   - macOS/Linux: `/Applications/XAMPP/htdocs/sistem-klinik` atau `/opt/lampp/htdocs/sistem-klinik`
2. Jalankan **Apache** dan **MySQL** lewat XAMPP Control Panel.
3. Buka browser, akses `http://localhost/sistem-klinik/membuat_db.php` untuk membuat database.
4. Lanjut akses `http://localhost/sistem-klinik/membuat_tabel.php` untuk membuat semua tabel
   sekaligus akun admin default.
5. Akses `http://localhost/sistem-klinik/login.php` lalu login pakai:
   - Username: `admin`
   - Password: `admin123`
6. Selesai — silakan coba semua modul CRUD dari sidebar.

> Catatan: pastikan folder `assets/foto_dokter/` bisa ditulis (writable) supaya upload
> foto dokter berhasil.

## Deploy Online (Hosting)

1. Upload semua file ke hosting yang mendukung PHP + MySQL (misalnya lewat cPanel/FTP).
2. Buat database MySQL lewat panel hosting, lalu sesuaikan kredensial di `config.php`
   (host, user, pass, nama database).
3. Import struktur tabel dengan menjalankan `membuat_tabel.php` sekali lewat browser,
   atau import manual lewat phpMyAdmin.
4. Akses domain hosting untuk login dan mulai memakai aplikasi.

## Screenshot

_(tempel screenshot aplikasi di sini setelah dijalankan)_

- `assets/screenshot-dashboard.png` — Halaman Dashboard
- `assets/screenshot-pasien.png` — Modul Data Pasien
- `assets/screenshot-rekam-medis.png` — Modul Rekam Medis

## Teknologi

- HTML5, CSS3, Bootstrap 5
- JavaScript (vanilla, DOM manipulation)
- PHP native prosedural (mysqli)
- MySQL / MariaDB
