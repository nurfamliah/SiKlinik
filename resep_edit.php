<?php
// pembayaran_edit.php
// ambil 1 data pembayaran berdasarkan id, tampilkan di form edit
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu'); window.location='login.php';</script>";
    exit;
}
include "config.php";
$halaman_aktif = "pembayaran";

$id = $_GET['id'];
$sql = "SELECT * FROM pembayaran WHERE id_pembayaran='$id'";
$hasil = mysqli_query($conn, $sql);

if (!$hasil || mysqli_num_rows($hasil) == 0) {
    echo "<script>alert('Data tidak ditemukan'); window.location='tabel-pembayaran.php';</script>";
    exit;
}
$data = mysqli_fetch_assoc($hasil);

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
    <title>Edit Pembayaran - Sistem Klinik</title>
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
                <h3>Edit Pembayaran</h3>
                <div class="card p-3">
                    <form action="pembayaran_update.php" method="POST">
                        <input type="hidden" name="id_pembayaran" value="<?php echo $data['id_pembayaran']; ?>">

                        <div class="mb-2">
                            <label class="form-label">Rekam Medis</label>
                            <select name="id_rekam_medis" class="form-select" required>
                                <?php while ($r = mysqli_fetch_assoc($list_rekam_medis)) { ?>
                                    <option value="<?php echo $r['id_rekam_medis']; ?>"
                                        <?php if ($r['id_rekam_medis'] == $data['id_rekam_medis']) echo 'selected'; ?>>
                                        #<?php echo $r['id_rekam_medis']; ?> - <?php echo $r['nama_pasien']; ?> (<?php echo $r['tanggal_periksa']; ?>)
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Biaya</label>
                            <input type="number" name="biaya" class="form-control" value="<?php echo $data['biaya']; ?>" required
                                   oninvalid="this.setCustomValidity('Biaya wajib diisi')"
                                   oninput="setCustomValidity('')">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Status Pembayaran</label>
                            <select name="status_pembayaran" class="form-select" required>
                                <option value="Belum Lunas" <?php if ($data['status_pembayaran'] == 'Belum Lunas') echo 'selected'; ?>>Belum Lunas</option>
                                <option value="Lunas" <?php if ($data['status_pembayaran'] == 'Lunas') echo 'selected'; ?>>Lunas</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Bayar</label>
                            <input type="date" name="tanggal_bayar" class="form-control" value="<?php echo $data['tanggal_bayar']; ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="tabel-pembayaran.php" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
</body>
</html>