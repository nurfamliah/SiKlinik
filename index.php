<?php
// index.php
// halaman dashboard, wajib login
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu'); window.location='login.php';</script>";
    exit;
}

include "config.php";
$halaman_aktif = "dashboard";

// hitung total pasien
$q_pasien = mysqli_query($conn, "SELECT COUNT(*) AS total FROM pasien");
$total_pasien = mysqli_fetch_assoc($q_pasien)['total'];

// hitung total dokter
$q_dokter = mysqli_query($conn, "SELECT COUNT(*) AS total FROM dokter");
$total_dokter = mysqli_fetch_assoc($q_dokter)['total'];

// hitung jadwal praktik hari ini (berdasarkan nama hari sekarang)
$hari_ini = date('l'); // contoh: Monday
// mapping ke bahasa Indonesia karena di tabel disimpan pakai nama hari Indonesia
$nama_hari_indo = array(
    'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
    'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'
);
$hari_ini_indo = $nama_hari_indo[$hari_ini];

$q_jadwal = mysqli_query($conn, "SELECT COUNT(*) AS total FROM jadwal_praktik WHERE hari='$hari_ini_indo'");
$total_jadwal_hari_ini = mysqli_fetch_assoc($q_jadwal)['total'];

// ambil detail dokter yang praktik hari ini beserta jamnya, diurutkan berdasarkan jam mulai
$q_jadwal_detail = mysqli_query($conn, "SELECT jadwal_praktik.jam_mulai, jadwal_praktik.jam_selesai,
    dokter.nama_dokter, dokter.spesialisasi, dokter.foto
    FROM jadwal_praktik
    JOIN dokter ON jadwal_praktik.id_dokter = dokter.id_dokter
    WHERE jadwal_praktik.hari='$hari_ini_indo'
    ORDER BY jadwal_praktik.jam_mulai ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Klinik</title>
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
                <h3 class="mb-4">Dashboard</h3>

                <!-- kartu tanggal & jam realtime, update tiap detik pakai JS -->
                <div class="card card-dashboard shadow-sm mb-4">
                    <h6>Tanggal &amp; Waktu Sekarang</h6>
                    <h2 id="jam-realtime">--:--:--</h2>
                    <div id="tanggal-realtime" class="text-muted"></div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-dashboard shadow-sm">
                            <h6>Total Pasien</h6>
                            <h2><?php echo $total_pasien; ?></h2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-dashboard shadow-sm">
                            <h6>Total Dokter</h6>
                            <h2><?php echo $total_dokter; ?></h2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-dashboard shadow-sm">
                            <h6>Jadwal Praktik Hari Ini (<?php echo $hari_ini_indo; ?>)</h6>
                            <h2><?php echo $total_jadwal_hari_ini; ?></h2>
                        </div>
                    </div>
                </div>

                <!-- daftar dokter yang praktik hari ini beserta jamnya -->
                <div class="card shadow-sm mt-4">
                    <div class="card-body">
                        <h6 class="mb-3">Daftar Dokter Praktik Hari Ini (<?php echo $hari_ini_indo; ?>)</h6>

                        <?php if (mysqli_num_rows($q_jadwal_detail) > 0) { ?>
                            <div class="list-group list-group-flush">
                                <?php while ($row = mysqli_fetch_assoc($q_jadwal_detail)) { ?>
                                    <div class="list-group-item d-flex align-items-center px-0 py-3">
                                        <?php
                                        $foto_path = "assets/foto_dokter/" . $row['foto'];
                                        if (!empty($row['foto']) && file_exists($foto_path)) {
                                        ?>
                                            <img src="<?php echo $foto_path; ?>" class="foto-dokter me-3" alt="Foto Dokter">
                                        <?php } else { ?>
                                            <div class="foto-dokter me-3 d-flex align-items-center justify-content-center bg-primary text-white">
                                                <i class="bi bi-person-fill"></i>
                                            </div>
                                        <?php } ?>

                                        <div class="flex-grow-1">
                                            <div class="fw-semibold"><?php echo htmlspecialchars($row['nama_dokter']); ?></div>
                                            <div class="text-muted small"><?php echo htmlspecialchars($row['spesialisasi']); ?></div>
                                        </div>

                                        <span class="badge bg-primary rounded-pill px-3 py-2">
                                            <i class="bi bi-clock me-1"></i>
                                            <?php
                                            echo substr($row['jam_mulai'], 0, 5) . " - " . substr($row['jam_selesai'], 0, 5);
                                            ?>
                                        </span>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } else { ?>
                            <p class="text-muted mb-0">Tidak ada dokter yang praktik hari ini.</p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// jam & tanggal realtime, update tiap detik seperti jam di laptop
var namaHari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
var namaBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                  'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

function updateJamRealtime() {
    var sekarang = new Date();

    var jam = String(sekarang.getHours()).padStart(2, '0');
    var menit = String(sekarang.getMinutes()).padStart(2, '0');
    var detik = String(sekarang.getSeconds()).padStart(2, '0');

    var hari = namaHari[sekarang.getDay()];
    var tanggal = sekarang.getDate();
    var bulan = namaBulan[sekarang.getMonth()];
    var tahun = sekarang.getFullYear();

    document.getElementById('jam-realtime').textContent = jam + ':' + menit + ':' + detik;
    document.getElementById('tanggal-realtime').textContent = hari + ', ' + tanggal + ' ' + bulan + ' ' + tahun;
}

updateJamRealtime();
setInterval(updateJamRealtime, 1000);
</script>

<?php include "footer.php"; ?>
</body>
</html>