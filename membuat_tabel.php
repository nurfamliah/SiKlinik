<?php
// membuat_tabel.php
// Script untuk membuat semua tabel di database db_klinik
// Jalankan file ini SEKALI lewat browser SETELAH membuat_db.php

include "config.php";

// ------- tabel dokter -------
$sql_dokter = "CREATE TABLE IF NOT EXISTS dokter (
    id_dokter INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_dokter VARCHAR(50) NOT NULL,
    spesialisasi VARCHAR(50) NOT NULL,
    no_hp VARCHAR(15),
    foto VARCHAR(100)
)";

if (mysqli_query($conn, $sql_dokter)) {
    echo "Tabel dokter berhasil dibuat. <br>";
} else {
    echo "Gagal membuat tabel dokter: " . mysqli_error($conn) . "<br>";
}

// ------- tabel pasien -------
$sql_pasien = "CREATE TABLE IF NOT EXISTS pasien (
    id_pasien INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_pasien VARCHAR(50) NOT NULL,
    nik VARCHAR(20) NOT NULL,
    jenis_kelamin ENUM('L','P') NOT NULL,
    tanggal_lahir DATE NOT NULL,
    alamat TEXT,
    no_hp INT(12)
)";

if (mysqli_query($conn, $sql_pasien)) {
    echo "Tabel pasien berhasil dibuat. <br>";
} else {
    echo "Gagal membuat tabel pasien: " . mysqli_error($conn) . "<br>";
}

// ------- tabel jadwal_praktik -------
$sql_jadwal = "CREATE TABLE IF NOT EXISTS jadwal_praktik (
    id_jadwal INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_dokter INT(6) UNSIGNED NOT NULL,
    hari VARCHAR(15) NOT NULL,
    jam_mulai TIME NOT NULL,
    jam_selesai TIME NOT NULL,
    FOREIGN KEY (id_dokter) REFERENCES dokter(id_dokter)
)";

if (mysqli_query($conn, $sql_jadwal)) {
    echo "Tabel jadwal_praktik berhasil dibuat. <br>";
} else {
    echo "Gagal membuat tabel jadwal_praktik: " . mysqli_error($conn) . "<br>";
}

// ------- tabel rekam_medis -------
$sql_rekam = "CREATE TABLE IF NOT EXISTS rekam_medis (
    id_rekam_medis INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_pasien INT(6) UNSIGNED NOT NULL,
    id_dokter INT(6) UNSIGNED NOT NULL,
    tanggal_periksa DATE NOT NULL,
    keluhan TEXT,
    diagnosis TEXT,
    catatan TEXT,
    FOREIGN KEY (id_pasien) REFERENCES pasien(id_pasien),
    FOREIGN KEY (id_dokter) REFERENCES dokter(id_dokter)
)";

if (mysqli_query($conn, $sql_rekam)) {
    echo "Tabel rekam_medis berhasil dibuat. <br>";
} else {
    echo "Gagal membuat tabel rekam_medis: " . mysqli_error($conn) . "<br>";
}

// ------- tabel resep -------
$sql_resep = "CREATE TABLE IF NOT EXISTS resep (
    id_resep INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_rekam_medis INT(6) UNSIGNED NOT NULL,
    nama_obat VARCHAR(50) NOT NULL,
    dosis VARCHAR(30),
    aturan_pakai VARCHAR(100),
    FOREIGN KEY (id_rekam_medis) REFERENCES rekam_medis(id_rekam_medis)
)";

if (mysqli_query($conn, $sql_resep)) {
    echo "Tabel resep berhasil dibuat. <br>";
} else {
    echo "Gagal membuat tabel resep: " . mysqli_error($conn) . "<br>";
}

// ------- tabel pembayaran -------
$sql_bayar = "CREATE TABLE IF NOT EXISTS pembayaran (
    id_pembayaran INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_rekam_medis INT(6) UNSIGNED NOT NULL,
    biaya INT NOT NULL,
    status_pembayaran ENUM('Lunas','Belum Lunas') DEFAULT 'Belum Lunas',
    tanggal_bayar DATE,
    FOREIGN KEY (id_rekam_medis) REFERENCES rekam_medis(id_rekam_medis)
)";

if (mysqli_query($conn, $sql_bayar)) {
    echo "Tabel pembayaran berhasil dibuat. <br>";
} else {
    echo "Gagal membuat tabel pembayaran: " . mysqli_error($conn) . "<br>";
}

// ------- tabel petugas -------
$sql_petugas = "CREATE TABLE IF NOT EXISTS petugas (
    id_petugas INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    password VARCHAR(30) NOT NULL,
    nama_lengkap VARCHAR(50)
)";

if (mysqli_query($conn, $sql_petugas)) {
    echo "Tabel petugas berhasil dibuat. <br>";

    // cek dulu supaya tidak dobel kalau file dijalankan berkali-kali
    $cek = mysqli_query($conn, "SELECT * FROM petugas WHERE username='admin'");
    if (mysqli_num_rows($cek) == 0) {
        $sql_insert_admin = "INSERT INTO petugas (username, password, nama_lengkap)
                              VALUES ('admin', 'admin123', 'Administrator Klinik')";
        if (mysqli_query($conn, $sql_insert_admin)) {
            echo "Akun default admin/admin123 berhasil ditambahkan. <br>";
        } else {
            echo "Gagal menambah akun admin: " . mysqli_error($conn) . "<br>";
        }
    } else {
        echo "Akun admin sudah ada, tidak ditambahkan lagi. <br>";
    }
} else {
    echo "Gagal membuat tabel petugas: " . mysqli_error($conn) . "<br>";
}

echo "<br>Semua proses selesai. Silakan login lewat login.php";

mysqli_close($conn);
?>
