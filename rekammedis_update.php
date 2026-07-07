<?php
// rekammedis_update.php
// proses update data rekam medis
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu'); window.location='login.php';</script>";
    exit;
}
include "config.php";

$id_rekam_medis = $_POST['id_rekam_medis'];
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

$sql = "UPDATE rekam_medis SET id_pasien='$id_pasien', id_dokter='$id_dokter',
        tanggal_periksa='$tanggal_periksa', keluhan='$keluhan', diagnosis='$diagnosis', catatan='$catatan'
        WHERE id_rekam_medis='$id_rekam_medis'";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Rekam medis berhasil diupdate');</script>";
    echo "<meta http-equiv='refresh' content='0;url=tabel-rekam-medis.php'>";
} else {
    echo "<script>alert('Gagal update data: " . mysqli_error($conn) . "');</script>";
    echo "<meta http-equiv='refresh' content='0;url=tabel-rekam-medis.php'>";
}
?>
