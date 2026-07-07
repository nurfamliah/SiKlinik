<?php
// pembayaran_hapus.php
// proses hapus data pembayaran
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu'); window.location='login.php';</script>";
    exit;
}
include "config.php";

$id = $_GET['id'];
$sql = "DELETE FROM pembayaran WHERE id_pembayaran='$id'";

if (mysqli_query($conn, $sql)) {
    header("Location: tabel-pembayaran.php");
    exit;
} else {
    echo "<script>alert('Gagal menghapus pembayaran: " . mysqli_error($conn) . "'); window.location='tabel-pembayaran.php';</script>";
    exit;
}
?>
