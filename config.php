<?php
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('Asia/Makassar');

$host = "sql300.infinityfree.com";
$user = "if0_42358847";
$pass = "lEAU2CaBjfo";
$db   = "if0_42358847_db_klinik";

$conn = mysqli_connect($host, $user, $pass, $db);

// cek koneksi, kalau gagal hentikan program
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
