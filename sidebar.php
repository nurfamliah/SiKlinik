<?php
// sidebar.php
// menu sidebar, di-include di semua halaman dashboard
// variabel $halaman_aktif dipakai buat kasih tanda menu yang lagi dibuka
if (!isset($halaman_aktif)) {
    $halaman_aktif = "";
}
?>
<div class="col-md-2 sidebar d-flex flex-column" id="sidebar-klinik">
    <div class="sidebar-menu">
        <a href="index.php" class="<?php echo ($halaman_aktif == 'dashboard') ? 'active' : ''; ?>" title="Dashboard">
            <i class="bi bi-speedometer2"></i> <span class="menu-text">Dashboard</span>
        </a>
        <a href="tabel-dokter.php" class="<?php echo ($halaman_aktif == 'dokter') ? 'active' : ''; ?>" title="Dokter">
            <i class="bi bi-person-badge"></i> <span class="menu-text">Dokter</span>
        </a>
        <a href="tabel-pasien.php" class="<?php echo ($halaman_aktif == 'pasien') ? 'active' : ''; ?>" title="Pasien">
            <i class="bi bi-people"></i> <span class="menu-text">Pasien</span>
        </a>
        <a href="tabel-jadwal.php" class="<?php echo ($halaman_aktif == 'jadwal') ? 'active' : ''; ?>" title="Jadwal Praktik">
            <i class="bi bi-calendar-week"></i> <span class="menu-text">Jadwal Praktik</span>
        </a>
        <a href="tabel-rekam-medis.php" class="<?php echo ($halaman_aktif == 'rekammedis') ? 'active' : ''; ?>" title="Rekam Medis">
            <i class="bi bi-file-earmark-medical"></i> <span class="menu-text">Rekam Medis</span>
        </a>
        <a href="tabel-resep.php" class="<?php echo ($halaman_aktif == 'resep') ? 'active' : ''; ?>" title="Resep">
            <i class="bi bi-capsule"></i> <span class="menu-text">Resep</span>
        </a>
        <a href="tabel-pembayaran.php" class="<?php echo ($halaman_aktif == 'pembayaran') ? 'active' : ''; ?>" title="Pembayaran">
            <i class="bi bi-cash-coin"></i> <span class="menu-text">Pembayaran</span>
        </a>
    </div>

    <!-- opsi keluar didorong ke paling bawah sidebar -->
    <div class="sidebar-logout mt-auto">
        <a href="logout.php" title="Keluar" onclick="return confirm('Apakah Anda yakin ingin logout?');">
            <i class="bi bi-box-arrow-right"></i> <span class="menu-text">Keluar</span>
        </a>
    </div>
</div>