<?php
// jadwal_hapus.php
// proses hapus data jadwal praktik
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu'); window.location='login.php';</script>";
    exit;
}
include "config.php";

$id = $_GET['id'];
$sql = "DELETE FROM jadwal_praktik WHERE id_jadwal='$id'";

if (mysqli_query($conn, $sql)) {
    header("Location: tabel-jadwal.php");
    exit;
} else {
    echo "<script>alert('Gagal menghapus jadwal: " . mysqli_error($conn) . "'); window.location='tabel-jadwal.php';</script>";
    exit;
}
?>
