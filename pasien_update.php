<?php
// pasien_update.php
// proses update data pasien
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu'); window.location='login.php';</script>";
    exit;
}
include "config.php";

$id_pasien = $_POST['id_pasien'];
$nama_pasien = $_POST['nama_pasien'];
$nik = $_POST['nik'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$alamat = $_POST['alamat'];
$no_hp = $_POST['no_hp'];

if (empty($nama_pasien) || empty($nik)) {
    echo "<script>alert('Data tidak boleh kosong'); history.back();</script>";
    exit;
}

if (!is_numeric($nik) || strlen($nik) != 16) {
    echo "<script>alert('NIK harus 16 digit angka'); history.back();</script>";
    exit;
}

// validasi No HP harus angka 10-15 digit (kalau diisi)
if (!empty($no_hp) && (!is_numeric($no_hp) || strlen($no_hp) < 10 || strlen($no_hp) > 15)) {
    echo "<script>alert('No HP harus angka, minimal 10 dan maksimal 15 digit'); history.back();</script>";
    exit;
}

$sql = "UPDATE pasien SET nama_pasien='$nama_pasien', nik='$nik', jenis_kelamin='$jenis_kelamin',
        tanggal_lahir='$tanggal_lahir', alamat='$alamat', no_hp='$no_hp' WHERE id_pasien='$id_pasien'";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Data pasien berhasil diupdate');</script>";
    echo "<meta http-equiv='refresh' content='0;url=tabel-pasien.php'>";
} else {
    echo "<script>alert('Gagal update data: " . mysqli_error($conn) . "');</script>";
    echo "<meta http-equiv='refresh' content='0;url=tabel-pasien.php'>";
}
?>