<?php
// footer.php
// footer bawah, full width, warna menyatu dengan header & sidebar
?>
<footer class="main-footer text-center text-white py-3">
    &copy; <?php echo date('Y'); ?> Sistem Klinik Sehat &mdash; Nur Fadhilah Amaliah
</footer>

<script>
// fungsi buat tampil/sembunyi form tambah data, dipakai di semua modul
function toggleForm(idForm) {
    var form = document.getElementById(idForm);
    if (form.style.display === 'none' || form.style.display === '') {
        form.style.display = 'block';
    } else {
        form.style.display = 'none';
    }
}

// fungsi buka/tutup sidebar, dipakai di semua halaman
function toggleSidebar() {
    var sidebar = document.getElementById('sidebar-klinik');
    if (!sidebar) return;

    var tertutup = sidebar.classList.toggle('sidebar-collapsed');

    // simpan status biar tetap konsisten saat pindah halaman
    localStorage.setItem('sidebarTertutup', tertutup ? '1' : '0');
}

// pas halaman dimuat, terapkan status sidebar terakhir (buka/tutup)
document.addEventListener('DOMContentLoaded', function () {
    var sidebar = document.getElementById('sidebar-klinik');
    if (!sidebar) return;

    if (localStorage.getItem('sidebarTertutup') === '1') {
        sidebar.classList.add('sidebar-collapsed');
    }
});
</script>