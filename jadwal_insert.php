<?php
// jadwal_insert.php
// proses simpan jadwal praktik baru
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu'); window.location='login.php';</script>";
    exit;
}
include "config.php";

$id_dokter = $_POST['id_dokter'];
$hari = $_POST['hari'];
$jam_mulai = $_POST['jam_mulai'];
$jam_selesai = $_POST['jam_selesai'];

if (empty($id_dokter) || empty($hari) || empty($jam_mulai) || empty($jam_selesai)) {
    echo "<script>alert('Data tidak boleh kosong'); history.back();</script>";
    exit;
}

$sql = "INSERT INTO jadwal_praktik (id_dokter, hari, jam_mulai, jam_selesai)
        VALUES ('$id_dokter', '$hari', '$jam_mulai', '$jam_selesai')";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Jadwal berhasil ditambahkan');</script>";
    echo "<meta http-equiv='refresh' content='0;url=tabel-jadwal.php'>";
} else {
    echo "<script>alert('Gagal menambah jadwal: " . mysqli_error($conn) . "');</script>";
    echo "<meta http-equiv='refresh' content='0;url=tabel-jadwal.php'>";
}
?>
