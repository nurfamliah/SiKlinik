<?php
// pasien_hapus.php
// proses hapus data pasien
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu'); window.location='login.php';</script>";
    exit;
}
include "config.php";

$id = $_GET['id'];
$sql = "DELETE FROM pasien WHERE id_pasien='$id'";

if (mysqli_query($conn, $sql)) {
    header("Location: tabel-pasien.php");
    exit;
} else {
    echo "<script>alert('Gagal menghapus, data mungkin masih dipakai di rekam medis: " . mysqli_error($conn) . "'); window.location='tabel-pasien.php';</script>";
    exit;
}
?>
