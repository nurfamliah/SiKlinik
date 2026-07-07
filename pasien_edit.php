<?php
// pasien_edit.php
// ambil 1 data pasien berdasarkan id, tampilkan di form edit
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu'); window.location='login.php';</script>";
    exit;
}
include "config.php";
$halaman_aktif = "pasien";

$id = $_GET['id'];
$sql = "SELECT * FROM pasien WHERE id_pasien='$id'";
$hasil = mysqli_query($conn, $sql);

if (!$hasil || mysqli_num_rows($hasil) == 0) {
    echo "<script>alert('Data tidak ditemukan'); window.location='tabel-pasien.php';</script>";
    exit;
}
$data = mysqli_fetch_assoc($hasil);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pasien - Sistem Klinik</title>
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
                <h3>Edit Data Pasien</h3>
                <div class="card p-3">
                    <form action="pasien_update.php" method="POST">
                        <input type="hidden" name="id_pasien" value="<?php echo $data['id_pasien']; ?>">

                        <div class="mb-2">
                            <label class="form-label">Nama Pasien</label>
                            <input type="text" name="nama_pasien" class="form-control" value="<?php echo $data['nama_pasien']; ?>" required
                                   oninvalid="this.setCustomValidity('Nama pasien wajib diisi')"
                                   oninput="setCustomValidity('')">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">NIK</label>
                            <input type="text" name="nik" class="form-control" value="<?php echo $data['nik']; ?>" required
                                   pattern="[0-9]{16}" maxlength="16" inputmode="numeric"
                                   oninvalid="this.setCustomValidity('NIK wajib 16 digit angka')"
                                   oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,16); setCustomValidity('')">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="L" <?php if ($data['jenis_kelamin'] == 'L') echo 'selected'; ?>>L</option>
                                <option value="P" <?php if ($data['jenis_kelamin'] == 'P') echo 'selected'; ?>>P</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" value="<?php echo $data['tanggal_lahir']; ?>" required
                                   oninvalid="this.setCustomValidity('Tanggal lahir wajib diisi')"
                                   oninput="setCustomValidity('')">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control"><?php echo $data['alamat']; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No HP</label>
                            <input type="text" name="no_hp" class="form-control" value="<?php echo $data['no_hp']; ?>"
                                   pattern="[0-9]{10,15}" maxlength="15" inputmode="numeric"
                                   oninvalid="this.setCustomValidity('No HP harus angka, 10-15 digit')"
                                   oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,15); setCustomValidity('')">
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="tabel-pasien.php" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
</body>
</html>