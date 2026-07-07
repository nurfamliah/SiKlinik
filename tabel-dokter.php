<?php
// tabel-dokter.php
// halaman utama modul data dokter
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu'); window.location='login.php';</script>";
    exit;
}
include "config.php";
$halaman_aktif = "dokter";

// ambil daftar spesialisasi unik untuk dropdown filter
$q_spesialisasi = mysqli_query($conn, "SELECT DISTINCT spesialisasi FROM dokter ORDER BY spesialisasi ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Dokter - Sistem Klinik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<?php include "header.php"; ?>
<div class="container-fluid">
    <div class="row">
        <?php include "sidebar.php"; ?>

        <div class="col-md-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="mb-0">Data Dokter</h3>
                    <button type="button" class="btn btn-primary" onclick="toggleForm('form-tambah-dokter')">+ Tambah Dokter</button>
                </div>

                <!-- form tambah data dokter, tersembunyi sampai tombol di atas ditekan -->
                <div class="card p-3 mb-4" id="form-tambah-dokter" style="display:none;">
                    <h5>Tambah Dokter</h5>
                    <form action="dokter_insert.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-2">
                            <label class="form-label">Nama Dokter</label>
                            <input type="text" name="nama_dokter" class="form-control" required
                                   oninvalid="this.setCustomValidity('Nama dokter wajib diisi')"
                                   oninput="setCustomValidity('')">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Spesialisasi</label>
                            <input type="text" name="spesialisasi" class="form-control" required
                                   oninvalid="this.setCustomValidity('Spesialisasi wajib diisi')"
                                   oninput="setCustomValidity('')">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">No HP</label>
                            <input type="text" name="no_hp" class="form-control"
                                   pattern="[0-9]{10,15}" maxlength="15" inputmode="numeric"
                                   oninvalid="this.setCustomValidity('No HP harus angka, 10-15 digit')"
                                   oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,15); setCustomValidity('')">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Foto Dokter</label>
                            <input type="file" name="foto" class="form-control" accept="image/jpeg,image/png,image/gif,image/webp"
                                   onchange="validasiFotoDokter(this)">
                            <div class="form-text">Hanya file foto (JPG, PNG, GIF, WEBP) yang bisa diupload.</div>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" onclick="toggleForm('form-tambah-dokter')">Batal</button>
                    </form>
                </div>

                <!-- kolom pencarian nama dokter dan filter spesialisasi -->
                <div class="row mb-3 g-2">
                    <div class="col-md-8">
                        <input type="text" id="cari-dokter" class="form-control" placeholder="Cari nama dokter...">
                    </div>
                    <div class="col-md-4">
                        <select id="filter-spesialisasi" class="form-select">
                            <option value="">-- Semua Spesialisasi --</option>
                            <?php while ($s = mysqli_fetch_assoc($q_spesialisasi)): ?>
                                <option value="<?php echo htmlspecialchars($s['spesialisasi']); ?>">
                                    <?php echo htmlspecialchars($s['spesialisasi']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>

                <!-- tabel data dokter -->
                <div class="card p-3">
                    <?php include "dokter_tampil.php"; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// validasi file foto dokter harus berupa gambar (jaga-jaga di sisi klien)
function validasiFotoDokter(input) {
    if (input.files && input.files.length > 0) {
        var tipeValid = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (tipeValid.indexOf(input.files[0].type) === -1) {
            alert('File yang diupload harus berupa foto (JPG, PNG, GIF, atau WEBP)');
            input.value = '';
        }
    }
}

// fitur cari nama dokter + filter spesialisasi, pakai vanilla JS tanpa reload
function filterDokter() {
    var kataKunci = document.getElementById('cari-dokter').value.toLowerCase();
    var spesialisasi = document.getElementById('filter-spesialisasi').value.toLowerCase();
    var baris = document.querySelectorAll('#tabel-dokter tbody tr');

    baris.forEach(function (tr) {
        var namaEl = tr.querySelector('.kolom-nama');
        var nama = namaEl ? namaEl.textContent.toLowerCase() : '';
        var specTr = (tr.getAttribute('data-spesialisasi') || '').toLowerCase();

        var cocokNama = nama.indexOf(kataKunci) > -1;
        var cocokSpesialisasi = (spesialisasi === '' || specTr === spesialisasi);

        tr.style.display = (cocokNama && cocokSpesialisasi) ? '' : 'none';
    });
}

document.getElementById('cari-dokter').addEventListener('keyup', filterDokter);
document.getElementById('filter-spesialisasi').addEventListener('change', filterDokter);
</script>

<?php include "footer.php"; ?>
</body>
</html>