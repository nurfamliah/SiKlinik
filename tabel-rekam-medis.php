<?php
// tabel-rekam-medis.php
// halaman utama modul rekam medis (halaman pusat, terhubung ke resep & pembayaran)
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu'); window.location='login.php';</script>";
    exit;
}
include "config.php";
$halaman_aktif = "rekammedis";

$list_pasien = mysqli_query($conn, "SELECT * FROM pasien ORDER BY nama_pasien ASC");
$list_dokter = mysqli_query($conn, "SELECT * FROM dokter ORDER BY nama_dokter ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekam Medis - Sistem Klinik</title>
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
                    <h3 class="mb-0">Rekam Medis</h3>
                    <button type="button" class="btn btn-primary" onclick="toggleForm('form-tambah-rekammedis')">+ Tambah Rekam Medis</button>
                </div>

                <!-- form tambah rekam medis, tersembunyi sampai tombol di atas ditekan -->
                <div class="card p-3 mb-4" id="form-tambah-rekammedis" style="display:none;">
                    <h5>Tambah Rekam Medis</h5>
                    <form action="rekammedis_insert.php" method="POST">
                        <div class="mb-2">
                            <label class="form-label">Pasien</label>
                            <select name="id_pasien" class="form-select" required>
                                <option value="">-- Pilih Pasien --</option>
                                <?php while ($p = mysqli_fetch_assoc($list_pasien)) { ?>
                                    <option value="<?php echo $p['id_pasien']; ?>"><?php echo $p['nama_pasien']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Dokter</label>
                            <select name="id_dokter" class="form-select" required>
                                <option value="">-- Pilih Dokter --</option>
                                <?php while ($d = mysqli_fetch_assoc($list_dokter)) { ?>
                                    <option value="<?php echo $d['id_dokter']; ?>"><?php echo $d['nama_dokter']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Tanggal Periksa</label>
                            <input type="date" name="tanggal_periksa" class="form-control" required
                                   oninvalid="this.setCustomValidity('Tanggal periksa wajib diisi')"
                                   oninput="setCustomValidity('')">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Keluhan</label>
                            <textarea name="keluhan" class="form-control"></textarea>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Diagnosis</label>
                            <textarea name="diagnosis" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Catatan</label>
                            <textarea name="catatan" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" onclick="toggleForm('form-tambah-rekammedis')">Batal</button>
                    </form>
                </div>

                <div class="card p-3">
                    <?php include "rekammedis_tampil.php"; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
</body>
</html>