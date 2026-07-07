<?php
// membuat_db.php
// Script untuk membuat database db_klinik
// Jalankan file ini SEKALI saja lewat browser (localhost/sistem-klinik/membuat_db.php)

$host = "localhost";
$user = "root";
$pass = "";

// koneksi tanpa nama database dulu, karena databasenya belum ada
$conn = mysqli_connect($host, $user, $pass);

if (!$conn) {
    die("Koneksi ke MySQL gagal: " . mysqli_connect_error());
}

$sql = "CREATE DATABASE IF NOT EXISTS db_klinik";

if (mysqli_query($conn, $sql)) {
    echo "Database db_klinik berhasil dibuat / sudah ada. <br>";
    echo "Selanjutnya jalankan membuat_tabel.php";
} else {
    echo "Gagal membuat database: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
