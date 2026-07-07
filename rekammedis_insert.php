<?php
// rekammedis_insert.php
// proses simpan data rekam medis baru
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu'); window.location='login.php';</script>";
    exit;
}
include "config.php";

$id_pasien = $_POST['id_pasien'];
$id_dokter = $_POST['id_dokter'];
$tanggal_periksa = $_POST['tanggal_periksa'];
$keluhan = $_POST['keluhan'];
$diagnosis = $_POST['diagnosis'];
$catatan = $_POST['catatan'];

if (empty($id_pasien) || empty($id_dokter) || empty($tanggal_periksa)) {
    echo "<script>alert('Data tidak boleh kosong'); history.back();</script>";
    exit;
}

$sql = "INSERT INTO rekam_medis (id_pasien, id_dokter, tanggal_periksa, keluhan, diagnosis, catatan)
        VALUES ('$id_pasien', '$id_dokter', '$tanggal_periksa', '$keluhan', '$diagnosis', '$catatan')";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Rekam medis berhasil ditambahkan');</script>";
    echo "<meta http-equiv='refresh' content='0;url=tabel-rekam-medis.php'>";
} else {
    echo "<script>alert('Gagal menambah data: " . mysqli_error($conn) . "');</script>";
    echo "<meta http-equiv='refresh' content='0;url=tabel-rekam-medis.php'>";
}
?>
