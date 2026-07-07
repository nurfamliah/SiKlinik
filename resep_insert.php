<?php
// resep_insert.php
// proses simpan resep baru
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu'); window.location='login.php';</script>";
    exit;
}
include "config.php";

$id_rekam_medis = $_POST['id_rekam_medis'];
$nama_obat = $_POST['nama_obat'];
$dosis = $_POST['dosis'];
$aturan_pakai = $_POST['aturan_pakai'];

if (empty($id_rekam_medis) || empty($nama_obat)) {
    echo "<script>alert('Data tidak boleh kosong'); history.back();</script>";
    exit;
}

$sql = "INSERT INTO resep (id_rekam_medis, nama_obat, dosis, aturan_pakai)
        VALUES ('$id_rekam_medis', '$nama_obat', '$dosis', '$aturan_pakai')";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Resep berhasil ditambahkan');</script>";
    echo "<meta http-equiv='refresh' content='0;url=tabel-resep.php?id_rekam_medis=$id_rekam_medis'>";
} else {
    echo "<script>alert('Gagal menambah resep: " . mysqli_error($conn) . "');</script>";
    echo "<meta http-equiv='refresh' content='0;url=tabel-resep.php'>";
}
?>
