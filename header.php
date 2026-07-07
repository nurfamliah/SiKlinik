<?php
// header.php
// header atas full width, warna menyatu dengan sidebar (satu bar biru di paling atas)
?>
<header class="main-header d-flex justify-content-between align-items-center px-4">
    <div class="d-flex align-items-center gap-3">
        <button type="button" id="tombol-toggle-sidebar" class="btn-toggle-sidebar" onclick="toggleSidebar()" title="Buka/Tutup Menu">
            <i class="bi bi-list"></i>
        </button>
        <h5 class="mb-0 text-white">Sistem Klinik Sehat</h5>
    </div>
    <div class="text-white text-end" style="font-size:14px;">
        <?php if (isset($_SESSION['nama_lengkap'])): ?>
            Halo, <b><?php echo $_SESSION['nama_lengkap']; ?></b>
            <?php if (isset($_COOKIE['last_login'])): ?>
                <br><span style="font-size:12px; opacity:0.85;">Terakhir login: <?php echo $_COOKIE['last_login']; ?></span>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</header>