<?php
// dokter_edit.php
// ambil 1 data dokter berdasarkan id, tampilkan di form edit
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu'); window.location='login.php';</script>";
    exit;
}
include "config.php";
$halaman_aktif = "dokter";

$id = $_GET['id'];
$sql = "SELECT * FROM dokter WHERE id_dokter='$id'";
$hasil = mysqli_query($conn, $sql);

if (!$hasil || mysqli_num_rows($hasil) == 0) {
    echo "<script>alert('Data tidak ditemukan'); window.location='tabel-dokter.php';</script>";
    exit;
}
$data = mysqli_fetch_assoc($hasil);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Dokter - Sistem Klinik</title>
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
                <h3>Edit Data Dokter</h3>
                <div class="card p-3">
                    <form action="dokter_update.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id_dokter" value="<?php echo $data['id_dokter']; ?>">

                        <div class="mb-2">
                            <label class="form-label">Foto saat ini</label><br>
                            <?php if (!empty($data['foto']) && file_exists("assets/foto_dokter/" . $data['foto'])): ?>
                                <img src="assets/foto_dokter/<?php echo $data['foto']; ?>" class="foto-dokter">
                            <?php else: ?>
                                <span class="text-muted">Belum ada foto</span>
                            <?php endif; ?>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Nama Dokter</label>
                            <input type="text" name="nama_dokter" class="form-control" value="<?php echo $data['nama_dokter']; ?>" required
                                   oninvalid="this.setCustomValidity('Nama dokter wajib diisi')"
                                   oninput="setCustomValidity('')">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Spesialisasi</label>
                            <input type="text" name="spesialisasi" class="form-control" value="<?php echo $data['spesialisasi']; ?>" required
                                   oninvalid="this.setCustomValidity('Spesialisasi wajib diisi')"
                                   oninput="setCustomValidity('')">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">No HP</label>
                            <input type="text" name="no_hp" class="form-control" value="<?php echo $data['no_hp']; ?>"
                                   pattern="[0-9]{10,15}" maxlength="15" inputmode="numeric"
                                   oninvalid="this.setCustomValidity('No HP harus angka, 10-15 digit')"
                                   oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,15); setCustomValidity('')">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ganti Foto (kosongkan jika tidak diganti)</label>
                            <input type="file" name="foto" class="form-control" accept="image/jpeg,image/png,image/gif,image/webp"
                                   onchange="validasiFotoDokter(this)">
                            <div class="form-text">Hanya file foto (JPG, PNG, GIF, WEBP) yang bisa diupload.</div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="tabel-dokter.php" class="btn btn-secondary">Batal</a>
                    </form>
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
</script>

<?php include "footer.php"; ?>
</body>
</html>