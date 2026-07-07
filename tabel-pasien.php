<?php
// tabel-pasien.php
// halaman utama modul data pasien
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu'); window.location='login.php';</script>";
    exit;
}
include "config.php";
$halaman_aktif = "pasien";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pasien - Sistem Klinik</title>
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
                    <h3 class="mb-0">Data Pasien</h3>
                    <button type="button" class="btn btn-primary" onclick="toggleForm('form-tambah-pasien')">+ Tambah Pasien</button>
                </div>

                <!-- form tambah data pasien, tersembunyi sampai tombol di atas ditekan -->
                <div class="card p-3 mb-4" id="form-tambah-pasien" style="display:none;">
                    <h5>Tambah Pasien</h5>
                    <form action="pasien_insert.php" method="POST">
                        <div class="mb-2">
                            <label class="form-label">Nama Pasien</label>
                            <input type="text" name="nama_pasien" class="form-control" required
                                   oninvalid="this.setCustomValidity('Nama pasien wajib diisi')"
                                   oninput="setCustomValidity('')">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">NIK (16 digit)</label>
                            <input type="text" name="nik" class="form-control" required
                                   pattern="[0-9]{16}" maxlength="16" inputmode="numeric"
                                   oninvalid="this.setCustomValidity('NIK wajib 16 digit angka')"
                                   oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,16); setCustomValidity('')">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="L">L</option>
                                <option value="P">P</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" required
                                   oninvalid="this.setCustomValidity('Tanggal lahir wajib diisi')"
                                   oninput="setCustomValidity('')">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No HP</label>
                            <input type="text" name="no_hp" class="form-control"
                                   pattern="[0-9]{10,15}" maxlength="15" inputmode="numeric"
                                   oninvalid="this.setCustomValidity('No HP harus angka, 10-15 digit')"
                                   oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,15); setCustomValidity('')">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" onclick="toggleForm('form-tambah-pasien')">Batal</button>
                    </form>
                </div>

                <!-- kotak pencarian, pakai vanilla JS, tanpa reload halaman -->
                <div class="mb-3">
                    <input type="text" id="cari-pasien" class="form-control" placeholder="Cari nama pasien...">
                </div>

                <!-- tabel data pasien -->
                <div class="card p-3">
                    <?php include "pasien_tampil.php"; ?>
                </div>
            </div>

            <?php include "footer.php"; ?>
        </div>
    </div>
</div>

<script>
// fitur search sederhana pakai vanilla JS, tanpa reload
document.getElementById('cari-pasien').addEventListener('keyup', function () {
    var kata_kunci = this.value.toLowerCase();
    var baris = document.querySelectorAll('#tabel-pasien tbody tr');

    baris.forEach(function (tr) {
        var nama = tr.querySelector('.kolom-nama').textContent.toLowerCase();
        if (nama.indexOf(kata_kunci) > -1) {
            tr.style.display = '';
        } else {
            tr.style.display = 'none';
        }
    });
});
</script>
</body>
</html>