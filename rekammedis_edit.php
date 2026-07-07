<?php
// rekammedis_edit.php
// ambil 1 data rekam medis berdasarkan id, tampilkan di form edit
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu'); window.location='login.php';</script>";
    exit;
}
include "config.php";
$halaman_aktif = "rekammedis";

$id = $_GET['id'];
$sql = "SELECT * FROM rekam_medis WHERE id_rekam_medis='$id'";
$hasil = mysqli_query($conn, $sql);

if (!$hasil || mysqli_num_rows($hasil) == 0) {
    echo "<script>alert('Data tidak ditemukan'); window.location='tabel-rekam-medis.php';</script>";
    exit;
}
$data = mysqli_fetch_assoc($hasil);

$list_pasien = mysqli_query($conn, "SELECT * FROM pasien ORDER BY nama_pasien ASC");
$list_dokter = mysqli_query($conn, "SELECT * FROM dokter ORDER BY nama_dokter ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Rekam Medis - Sistem Klinik</title>
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
                <h3>Edit Rekam Medis</h3>
                <div class="card p-3">
                    <form action="rekammedis_update.php" method="POST">
                        <input type="hidden" name="id_rekam_medis" value="<?php echo $data['id_rekam_medis']; ?>">

                        <div class="mb-2">
                            <label class="form-label">Pasien</label>
                            <select name="id_pasien" class="form-select" required>
                                <?php while ($p = mysqli_fetch_assoc($list_pasien)) { ?>
                                    <option value="<?php echo $p['id_pasien']; ?>"
                                        <?php if ($p['id_pasien'] == $data['id_pasien']) echo 'selected'; ?>>
                                        <?php echo $p['nama_pasien']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Dokter</label>
                            <select name="id_dokter" class="form-select" required>
                                <?php while ($d = mysqli_fetch_assoc($list_dokter)) { ?>
                                    <option value="<?php echo $d['id_dokter']; ?>"
                                        <?php if ($d['id_dokter'] == $data['id_dokter']) echo 'selected'; ?>>
                                        <?php echo $d['nama_dokter']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Tanggal Periksa</label>
                            <input type="date" name="tanggal_periksa" class="form-control" value="<?php echo $data['tanggal_periksa']; ?>" required
                                   oninvalid="this.setCustomValidity('Tanggal periksa wajib diisi')"
                                   oninput="setCustomValidity('')">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Keluhan</label>
                            <textarea name="keluhan" class="form-control"><?php echo $data['keluhan']; ?></textarea>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Diagnosis</label>
                            <textarea name="diagnosis" class="form-control"><?php echo $data['diagnosis']; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Catatan</label>
                            <textarea name="catatan" class="form-control"><?php echo $data['catatan']; ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="tabel-rekam-medis.php" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
</body>
</html>