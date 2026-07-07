<?php
// login.php
// halaman form login petugas
session_start();

// kalau sudah login, langsung lempar ke dashboard
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Klinik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="login-box card shadow border-0 overflow-hidden">
        <div class="login-header text-center">
            <div class="login-icon-circle mx-auto mb-3">
                <i class="bi bi-heart-pulse-fill"></i>
            </div>
            <h4 class="text-white mb-1">Login Sistem Klinik</h4>
            <p class="text-white-50 mb-0" style="font-size:14px;">Sistem Manajemen Klinik Sehat</p>
        </div>

        <div class="p-4">
            <?php if (isset($_GET['gagal'])): ?>
                <div class="alert alert-danger">Username atau password salah!</div>
            <?php endif; ?>

            <form action="ceklogin.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan Username" required
                           oninvalid="this.setCustomValidity('Username wajib diisi')"
                           oninput="setCustomValidity('')">
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required
                           oninvalid="this.setCustomValidity('Password wajib diisi')"
                           oninput="setCustomValidity('')">
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
            <p class="text-center text-muted mt-3 mb-0" style="font-size:13px;">Default: admin / admin123</p>
        </div>
    </div>
</body>
</html>