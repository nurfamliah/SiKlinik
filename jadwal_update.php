<?php
// jadwal_update.php
// proses update data jadwal praktik
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu'); window.location='login.php';</script>";
    exit;
}
include "config.php";

$id_jadwal = $_POST['id_jadwal'];
$id_dokter = $_POST['id_dokter'];
$hari = $_POST['hari'];
$jam_mulai = $_POST['jam_mulai'];
$jam_selesai = $_POST['jam_selesai'];

if (empty($id_dokter) || empty($hari) || empty($jam_mulai) || empty($jam_selesai)) {
    echo "<script>alert('Data tidak boleh kosong'); history.back();</script>";
    exit;
}

$sql = "UPDATE jadwal_praktik SET id_dokter='$id_dokter', hari='$hari',
        jam_mulai='$jam_mulai', jam_selesai='$jam_selesai' WHERE id_jadwal='$id_jadwal'";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Jadwal berhasil diupdate');</script>";
    echo "<meta http-equiv='refresh' content='0;url=tabel-jadwal.php'>";
} else {
    echo "<script>alert('Gagal update jadwal: " . mysqli_error($conn) . "');</script>";
    echo "<meta http-equiv='refresh' content='0;url=tabel-jadwal.php'>";
}
?>
