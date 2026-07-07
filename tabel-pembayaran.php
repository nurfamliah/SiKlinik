<?php
// tabel-pembayaran.php
// halaman utama modul pembayaran, terhubung dari rekam medis
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu'); window.location='login.php';</script>";
    exit;
}
include "config.php";
$halaman_aktif = "pembayaran";

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
    <title>Pembayaran - Sistem Klinik</title>
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
                    <h3 class="mb-0">Pembayaran</h3>
                    <button type="button" class="btn btn-primary" onclick="toggleForm('form-tambah-pembayaran')">+ Tambah Pembayaran</button>
                </div>

                <?php if (!empty($filter_rekam_medis)): ?>
                    <div class="alert alert-secondary">
                        Menampilkan pembayaran untuk Rekam Medis ID: <b><?php echo $filter_rekam_medis; ?></b>
                        - <a href="tabel-pembayaran.php">Lihat semua pembayaran</a>
                    </div>
                <?php endif; ?>

                <!-- form tambah pembayaran, tersembunyi sampai tombol di atas ditekan -->
                <div class="card p-3 mb-4" id="form-tambah-pembayaran" style="display:none;">
                    <h5>Tambah Pembayaran</h5>
                    <form action="pembayaran_insert.php" method="POST">
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
                            <label class="form-label">Biaya</label>
                            <input type="number" name="biaya" class="form-control" required
                                   oninvalid="this.setCustomValidity('Biaya wajib diisi')"
                                   oninput="setCustomValidity('')">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Status Pembayaran</label>
                            <select name="status_pembayaran" class="form-select" required>
                                <option value="Belum Lunas">Belum Lunas</option>
                                <option value="Lunas">Lunas</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Bayar</label>
                            <input type="date" name="tanggal_bayar" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" onclick="toggleForm('form-tambah-pembayaran')">Batal</button>
                    </form>
                </div>

                <div class="card p-3">
                    <?php include "pembayaran_tampil.php"; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
</body>
</html>