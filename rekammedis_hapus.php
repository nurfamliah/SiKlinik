<?php
// rekammedis_hapus.php
// proses hapus data rekam medis
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu'); window.location='login.php';</script>";
    exit;
}
include "config.php";

$id = $_GET['id'];
$sql = "DELETE FROM rekam_medis WHERE id_rekam_medis='$id'";

if (mysqli_query($conn, $sql)) {
    header("Location: tabel-rekam-medis.php");
    exit;
} else {
    echo "<script>alert('Gagal menghapus, data mungkin masih dipakai di resep/pembayaran: " . mysqli_error($conn) . "'); window.location='tabel-rekam-medis.php';</script>";
    exit;
}
?>
