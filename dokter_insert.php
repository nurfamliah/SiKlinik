<?php
// dokter_insert.php
// proses simpan data dokter baru
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu'); window.location='login.php';</script>";
    exit;
}
include "config.php";

$nama_dokter = $_POST['nama_dokter'];
$spesialisasi = $_POST['spesialisasi'];
$no_hp = $_POST['no_hp'];

// validasi server-side sederhana
if (empty($nama_dokter) || empty($spesialisasi)) {
    echo "<script>alert('Nama dan spesialisasi wajib diisi'); history.back();</script>";
    exit;
}

// validasi No HP harus angka 10-15 digit (kalau diisi)
if (!empty($no_hp) && (!is_numeric($no_hp) || strlen($no_hp) < 10 || strlen($no_hp) > 15)) {
    echo "<script>alert('No HP harus angka, minimal 10 dan maksimal 15 digit'); history.back();</script>";
    exit;
}

// proses upload foto (kalau ada file yang diupload)
// validasi dulu: file yang diupload wajib berupa foto (jpg, jpeg, png, gif, webp)
$nama_foto = "";
if (isset($_FILES['foto']) && $_FILES['foto']['name'] != "") {
    $ekstensi_diizinkan = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $tipe_diizinkan = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    $ekstensi_file = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
    $tipe_file = mime_content_type($_FILES['foto']['tmp_name']);

    if (!in_array($ekstensi_file, $ekstensi_diizinkan) || !in_array($tipe_file, $tipe_diizinkan)) {
        echo "<script>alert('File foto harus berupa gambar (JPG, PNG, GIF, atau WEBP)'); history.back();</script>";
        exit;
    }

    $nama_foto = time() . "_" . $_FILES['foto']['name'];
    $lokasi_tujuan = "assets/foto_dokter/" . $nama_foto;
    move_uploaded_file($_FILES['foto']['tmp_name'], $lokasi_tujuan);
}

$sql = "INSERT INTO dokter (nama_dokter, spesialisasi, no_hp, foto)
        VALUES ('$nama_dokter', '$spesialisasi', '$no_hp', '$nama_foto')";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Data dokter berhasil ditambahkan');</script>";
    echo "<meta http-equiv='refresh' content='0;url=tabel-dokter.php'>";
} else {
    echo "<script>alert('Gagal menambah data: " . mysqli_error($conn) . "');</script>";
    echo "<meta http-equiv='refresh' content='0;url=tabel-dokter.php'>";
}
?>