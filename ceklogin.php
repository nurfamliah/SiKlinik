<?php
session_start();
include "config.php";

$username = $_POST['username'];
$password = $_POST['password'];

if (empty($username) || empty($password)) {
    echo "<script>alert('Username dan password wajib diisi'); window.location='login.php';</script>";
    exit;
}

$sql = "SELECT * FROM petugas WHERE username='$username' AND password='$password'";
$hasil = mysqli_query($conn, $sql);

if (!$hasil) {
    echo "<script>alert('Terjadi kesalahan database: " . mysqli_error($conn) . "');</script>";
    exit;
}

if (mysqli_num_rows($hasil) > 0) {
    $data = mysqli_fetch_assoc($hasil);

    $_SESSION['username'] = $data['username'];
    $_SESSION['nama_lengkap'] = $data['nama_lengkap'];

    setcookie('last_login', date('d-m-Y H:i'), time() + 86400 * 30);

    header("Location: index.php");
    exit;
} else {
    header("Location: login.php?gagal=1");
    exit;
}
?>
