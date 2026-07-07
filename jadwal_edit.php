<?php
// jadwal_edit.php
// ambil 1 data jadwal berdasarkan id, tampilkan di form edit
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu'); window.location='login.php';</script>";
    exit;
}
include "config.php";
$halaman_aktif = "jadwal";

$id = $_GET['id'];
$sql = "SELECT * FROM jadwal_praktik WHERE id_jadwal='$id'";
$hasil = mysqli_query($conn, $sql);

if (!$hasil || mysqli_num_rows($hasil) == 0) {
    echo "<script>alert('Data tidak ditemukan'); window.location='tabel-jadwal.php';</script>";
    exit;
}
$data = mysqli_fetch_assoc($hasil);

$list_dokter = mysqli_query($conn, "SELECT * FROM dokter ORDER BY nama_dokter ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jadwal - Sistem Klinik</title>
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
                <h3>Edit Jadwal Praktik</h3>
                <div class="card p-3">
                    <form action="jadwal_update.php" method="POST">
                        <input type="hidden" name="id_jadwal" value="<?php echo $data['id_jadwal']; ?>">

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
                            <label class="form-label">Hari</label>
                            <select name="hari" class="form-select" required>
                                <?php
                                $daftar_hari = array('Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');
                                foreach ($daftar_hari as $h) {
                                    $selected = ($h == $data['hari']) ? 'selected' : '';
                                    echo "<option value='$h' $selected>$h</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Jam Mulai</label>
                            <input type="time" name="jam_mulai" class="form-control" value="<?php echo $data['jam_mulai']; ?>" required
                                   oninvalid="this.setCustomValidity('Jam mulai wajib diisi')"
                                   oninput="setCustomValidity('')">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jam Selesai</label>
                            <input type="time" name="jam_selesai" class="form-control" value="<?php echo $data['jam_selesai']; ?>" required
                                   oninvalid="this.setCustomValidity('Jam selesai wajib diisi')"
                                   oninput="setCustomValidity('')">
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="tabel-jadwal.php" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
</body>
</html>