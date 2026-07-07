<?php
// pembayaran_insert.php
// proses simpan pembayaran baru
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu'); window.location='login.php';</script>";
    exit;
}
include "config.php";

$id_rekam_medis = $_POST['id_rekam_medis'];
$biaya = $_POST['biaya'];
$status_pembayaran = $_POST['status_pembayaran'];
$tanggal_bayar = !empty($_POST['tanggal_bayar']) ? "'" . $_POST['tanggal_bayar'] . "'" : "NULL";

if (empty($id_rekam_medis) || empty($biaya)) {
    echo "<script>alert('Data tidak boleh kosong'); history.back();</script>";
    exit;
}

// validasi biaya harus angka
if (!is_numeric($biaya)) {
    echo "<script>alert('Biaya harus berupa angka'); history.back();</script>";
    exit;
}

$sql = "INSERT INTO pembayaran (id_rekam_medis, biaya, status_pembayaran, tanggal_bayar)
        VALUES ('$id_rekam_medis', '$biaya', '$status_pembayaran', $tanggal_bayar)";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Pembayaran berhasil ditambahkan');</script>";
    echo "<meta http-equiv='refresh' content='0;url=tabel-pembayaran.php?id_rekam_medis=$id_rekam_medis'>";
} else {
    echo "<script>alert('Gagal menambah pembayaran: " . mysqli_error($conn) . "');</script>";
    echo "<meta http-equiv='refresh' content='0;url=tabel-pembayaran.php'>";
}
?>
