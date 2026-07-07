<?php
// dokter_update.php
// proses update data dokter
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu'); window.location='login.php';</script>";
    exit;
}
include "config.php";

$id_dokter = $_POST['id_dokter'];
$nama_dokter = $_POST['nama_dokter'];
$spesialisasi = $_POST['spesialisasi'];
$no_hp = $_POST['no_hp'];

if (empty($nama_dokter) || empty($spesialisasi)) {
    echo "<script>alert('Nama dan spesialisasi wajib diisi'); history.back();</script>";
    exit;
}

// validasi No HP harus angka 10-15 digit (kalau diisi)
if (!empty($no_hp) && (!is_numeric($no_hp) || strlen($no_hp) < 10 || strlen($no_hp) > 15)) {
    echo "<script>alert('No HP harus angka, minimal 10 dan maksimal 15 digit'); history.back();</script>";
    exit;
}

// kalau ada foto baru diupload, timpa fotonya. kalau tidak, foto lama tetap dipakai
// validasi dulu: file yang diupload wajib berupa foto (jpg, jpeg, png, gif, webp)
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

    $sql = "UPDATE dokter SET nama_dokter='$nama_dokter', spesialisasi='$spesialisasi',
            no_hp='$no_hp', foto='$nama_foto' WHERE id_dokter='$id_dokter'";
} else {
    $sql = "UPDATE dokter SET nama_dokter='$nama_dokter', spesialisasi='$spesialisasi',
            no_hp='$no_hp' WHERE id_dokter='$id_dokter'";
}

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Data dokter berhasil diupdate');</script>";
    echo "<meta http-equiv='refresh' content='0;url=tabel-dokter.php'>";
} else {
    echo "<script>alert('Gagal update data: " . mysqli_error($conn) . "');</script>";
    echo "<meta http-equiv='refresh' content='0;url=tabel-dokter.php'>";
}
?>