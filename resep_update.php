<?php
// resep_update.php
// proses update data resep
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu'); window.location='login.php';</script>";
    exit;
}
include "config.php";

$id_resep = $_POST['id_resep'];
$id_rekam_medis = $_POST['id_rekam_medis'];
$nama_obat = $_POST['nama_obat'];
$dosis = $_POST['dosis'];
$aturan_pakai = $_POST['aturan_pakai'];

if (empty($id_rekam_medis) || empty($nama_obat)) {
    echo "<script>alert('Data tidak boleh kosong'); history.back();</script>";
    exit;
}

$sql = "UPDATE resep SET id_rekam_medis='$id_rekam_medis', nama_obat='$nama_obat',
        dosis='$dosis', aturan_pakai='$aturan_pakai' WHERE id_resep='$id_resep'";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Resep berhasil diupdate');</script>";
    echo "<meta http-equiv='refresh' content='0;url=tabel-resep.php'>";
} else {
    echo "<script>alert('Gagal update resep: " . mysqli_error($conn) . "');</script>";
    echo "<meta http-equiv='refresh' content='0;url=tabel-resep.php'>";
}
?>
