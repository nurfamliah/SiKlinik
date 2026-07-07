<?php
// dokter_hapus.php
// proses hapus data dokter
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu'); window.location='login.php';</script>";
    exit;
}
include "config.php";

$id = $_GET['id'];
$sql = "DELETE FROM dokter WHERE id_dokter='$id'";

if (mysqli_query($conn, $sql)) {
    header("Location: tabel-dokter.php");
    exit;
} else {
    // kalau gagal karena masih dipakai di jadwal/rekam medis (foreign key), kasih tau
    echo "<script>alert('Gagal menghapus, data mungkin masih dipakai di jadwal atau rekam medis: " . mysqli_error($conn) . "'); window.location='tabel-dokter.php';</script>";
    exit;
}
?>
