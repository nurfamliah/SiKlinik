<?php
// resep_hapus.php
// proses hapus data resep
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu'); window.location='login.php';</script>";
    exit;
}
include "config.php";

$id = $_GET['id'];
$sql = "DELETE FROM resep WHERE id_resep='$id'";

if (mysqli_query($conn, $sql)) {
    header("Location: tabel-resep.php");
    exit;
} else {
    echo "<script>alert('Gagal menghapus resep: " . mysqli_error($conn) . "'); window.location='tabel-resep.php';</script>";
    exit;
}
?>
