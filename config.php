<?php
date_default_timezone_set('Asia/Makassar');

$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_klinik";

$conn = mysqli_connect($host, $user, $pass, $db);

// cek koneksi, kalau gagal hentikan program
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>