<?php
// pembayaran_update.php
// proses update data pembayaran
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu'); window.location='login.php';</script>";
    exit;
}
include "config.php";

$id_pembayaran = $_POST['id_pembayaran'];
$id_rekam_medis = $_POST['id_rekam_medis'];
$biaya = $_POST['biaya'];
$status_pembayaran = $_POST['status_pembayaran'];
$tanggal_bayar = !empty($_POST['tanggal_bayar']) ? "'" . $_POST['tanggal_bayar'] . "'" : "NULL";

if (empty($id_rekam_medis) || empty($biaya)) {
    echo "<script>alert('Data tidak boleh kosong'); history.back();</script>";
    exit;
}

if (!is_numeric($biaya)) {
    echo "<script>alert('Biaya harus berupa angka'); history.back();</script>";
    exit;
}

$sql = "UPDATE pembayaran SET id_rekam_medis='$id_rekam_medis', biaya='$biaya',
        status_pembayaran='$status_pembayaran', tanggal_bayar=$tanggal_bayar
        WHERE id_pembayaran='$id_pembayaran'";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Pembayaran berhasil diupdate');</script>";
    echo "<meta http-equiv='refresh' content='0;url=tabel-pembayaran.php'>";
} else {
    echo "<script>alert('Gagal update pembayaran: " . mysqli_error($conn) . "');</script>";
    echo "<meta http-equiv='refresh' content='0;url=tabel-pembayaran.php'>";
}
?>
