<?php
// pasien_insert.php
// proses simpan data pasien baru
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu'); window.location='login.php';</script>";
    exit;
}
include "config.php";

$nama_pasien = $_POST['nama_pasien'];
$nik = $_POST['nik'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$alamat = $_POST['alamat'];
$no_hp = $_POST['no_hp'];

// validasi server-side
if (empty($nama_pasien) || empty($nik) || empty($jenis_kelamin) || empty($tanggal_lahir)) {
    echo "<script>alert('Data tidak boleh kosong'); history.back();</script>";
    exit;
}

// validasi NIK harus 16 digit angka
if (!is_numeric($nik) || strlen($nik) != 16) {
    echo "<script>alert('NIK harus 16 digit angka'); history.back();</script>";
    exit;
}

// validasi No HP harus angka 10-15 digit (kalau diisi)
if (!empty($no_hp) && (!is_numeric($no_hp) || strlen($no_hp) < 10 || strlen($no_hp) > 15)) {
    echo "<script>alert('No HP harus angka, minimal 10 dan maksimal 15 digit'); history.back();</script>";
    exit;
}

$sql = "INSERT INTO pasien (nama_pasien, nik, jenis_kelamin, tanggal_lahir, alamat, no_hp)
        VALUES ('$nama_pasien', '$nik', '$jenis_kelamin', '$tanggal_lahir', '$alamat', '$no_hp')";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Data pasien berhasil ditambahkan');</script>";
    echo "<meta http-equiv='refresh' content='0;url=tabel-pasien.php'>";
} else {
    echo "<script>alert('Gagal menambah data: " . mysqli_error($conn) . "');</script>";
    echo "<meta http-equiv='refresh' content='0;url=tabel-pasien.php'>";
}
?>