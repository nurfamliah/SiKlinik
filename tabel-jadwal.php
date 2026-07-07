<?php
// tabel-jadwal.php
// halaman utama modul jadwal praktik dokter
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu'); window.location='login.php';</script>";
    exit;
}
include "config.php";
$halaman_aktif = "jadwal";

// ambil data dokter buat dropdown
$list_dokter = mysqli_query($conn, "SELECT * FROM dokter ORDER BY nama_dokter ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Praktik - Sistem Klinik</title>
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
                    <h3 class="mb-0">Jadwal Praktik Dokter</h3>
                    <button type="button" class="btn btn-primary" onclick="toggleForm('form-tambah-jadwal')">+ Tambah Jadwal</button>
                </div>

                <!-- form tambah jadwal, tersembunyi sampai tombol di atas ditekan -->
                <div class="card p-3 mb-4" id="form-tambah-jadwal" style="display:none;">
                    <h5>Tambah Jadwal</h5>
                    <form action="jadwal_insert.php" method="POST">
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
                            <label class="form-label">Hari</label>
                            <select name="hari" class="form-select" required>
                                <option value="">-- Pilih Hari --</option>
                                <option value="Senin">Senin</option>
                                <option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option>
                                <option value="Kamis">Kamis</option>
                                <option value="Jumat">Jumat</option>
                                <option value="Sabtu">Sabtu</option>
                                <option value="Minggu">Minggu</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Jam Mulai</label>
                            <input type="time" name="jam_mulai" class="form-control" required
                                   oninvalid="this.setCustomValidity('Jam mulai wajib diisi')"
                                   oninput="setCustomValidity('')">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jam Selesai</label>
                            <input type="time" name="jam_selesai" class="form-control" required
                                   oninvalid="this.setCustomValidity('Jam selesai wajib diisi')"
                                   oninput="setCustomValidity('')">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" onclick="toggleForm('form-tambah-jadwal')">Batal</button>
                    </form>
                </div>

                <!-- kolom pencarian nama dokter dan filter hari -->
                <div class="row mb-3 g-2">
                    <div class="col-md-8">
                        <input type="text" id="cari-jadwal" class="form-control" placeholder="Cari nama dokter...">
                    </div>
                    <div class="col-md-4">
                        <select id="filter-hari" class="form-select">
                            <option value="">-- Semua Hari --</option>
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                            <option value="Sabtu">Sabtu</option>
                            <option value="Minggu">Minggu</option>
                        </select>
                    </div>
                </div>

                <div class="card p-3">
                    <?php include "jadwal_tampil.php"; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// fitur cari nama dokter + filter hari, pakai vanilla JS tanpa reload
// data tabel sudah terurut dari server: Senin -> Minggu, jam paling awal duluan
function filterJadwal() {
    var kataKunci = document.getElementById('cari-jadwal').value.toLowerCase();
    var hariPilihan = document.getElementById('filter-hari').value;
    var baris = document.querySelectorAll('#tabel-jadwal tbody tr');

    baris.forEach(function (tr) {
        var namaEl = tr.querySelector('.kolom-nama');
        var nama = namaEl ? namaEl.textContent.toLowerCase() : '';
        var hariTr = tr.getAttribute('data-hari') || '';

        var cocokNama = nama.indexOf(kataKunci) > -1;
        var cocokHari = (hariPilihan === '' || hariTr === hariPilihan);

        tr.style.display = (cocokNama && cocokHari) ? '' : 'none';
    });
}

document.getElementById('cari-jadwal').addEventListener('keyup', filterJadwal);
document.getElementById('filter-hari').addEventListener('change', filterJadwal);
</script>

<?php include "footer.php"; ?>
</body>
</html>