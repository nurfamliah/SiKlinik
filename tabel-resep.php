<?php
// tabel-resep.php
// halaman utama modul resep obat, terhubung dari rekam medis
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu'); window.location='login.php';</script>";
    exit;
}
include "config.php";
$halaman_aktif = "resep";

// kalau datang dari tombol "Lihat Resep" di rekam medis, ada id_rekam_medis di URL
$filter_rekam_medis = isset($_GET['id_rekam_medis']) ? $_GET['id_rekam_medis'] : "";

$list_rekam_medis = mysqli_query($conn, "SELECT rekam_medis.*, pasien.nama_pasien
                                          FROM rekam_medis
                                          JOIN pasien ON rekam_medis.id_pasien = pasien.id_pasien
                                          ORDER BY rekam_medis.id_rekam_medis DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resep Obat - Sistem Klinik</title>
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
                    <h3 class="mb-0">Resep Obat</h3>
                    <button type="button" class="btn btn-primary" onclick="toggleForm('form-tambah-resep')">+ Tambah Resep</button>
                </div>

                <?php if (!empty($filter_rekam_medis)): ?>
                    <div class="alert alert-secondary">
                        Menampilkan resep untuk Rekam Medis ID: <b><?php echo $filter_rekam_medis; ?></b>
                        - <a href="tabel-resep.php">Lihat semua resep</a>
                    </div>
                <?php endif; ?>

                <!-- form tambah resep, tersembunyi sampai tombol di atas ditekan -->
                <div class="card p-3 mb-4" id="form-tambah-resep" style="display:none;">
                    <h5>Tambah Resep</h5>
                    <form action="resep_insert.php" method="POST">
                        <div class="mb-2">
                            <label class="form-label">Rekam Medis</label>
                            <select name="id_rekam_medis" class="form-select" required>
                                <option value="">-- Pilih Rekam Medis --</option>
                                <?php while ($r = mysqli_fetch_assoc($list_rekam_medis)) { ?>
                                    <option value="<?php echo $r['id_rekam_medis']; ?>"
                                        <?php if ($r['id_rekam_medis'] == $filter_rekam_medis) echo 'selected'; ?>>
                                        #<?php echo $r['id_rekam_medis']; ?> - <?php echo $r['nama_pasien']; ?> (<?php echo $r['tanggal_periksa']; ?>)
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Nama Obat</label>
                            <input type="text" name="nama_obat" class="form-control" required
                                   oninvalid="this.setCustomValidity('Nama obat wajib diisi')"
                                   oninput="setCustomValidity('')">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Dosis</label>
                            <input type="text" name="dosis" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Aturan Pakai</label>
                            <input type="text" name="aturan_pakai" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" onclick="toggleForm('form-tambah-resep')">Batal</button>
                    </form>
                </div>

                <div class="card p-3">
                    <?php include "resep_tampil.php"; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
</body>
</html>