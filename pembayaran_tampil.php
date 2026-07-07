<?php
// pembayaran_tampil.php
// menampilkan data pembayaran, kalau ada filter id_rekam_medis maka hanya itu yang tampil
$sql = "SELECT pembayaran.*, rekam_medis.tanggal_periksa, pasien.nama_pasien
        FROM pembayaran
        JOIN rekam_medis ON pembayaran.id_rekam_medis = rekam_medis.id_rekam_medis
        JOIN pasien ON rekam_medis.id_pasien = pasien.id_pasien";

if (!empty($filter_rekam_medis)) {
    $sql .= " WHERE pembayaran.id_rekam_medis = '$filter_rekam_medis'";
}
$sql .= " ORDER BY pembayaran.id_pembayaran DESC";

$hasil = mysqli_query($conn, $sql);

if (!$hasil) {
    echo "Query gagal: " . mysqli_error($conn);
} else {
?>
<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th class="text-center">No</th>
        <th>Pasien</th>
        <th>Tgl Periksa</th>
        <th>Biaya</th>
        <th class="text-center">Status</th>
        <th>Tgl Bayar</th>
        <th class="text-center">Aksi</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $no = 1;
    while ($baris = mysqli_fetch_assoc($hasil)) {
    ?>
        <tr>
            <td class="text-center"><?php echo $no++; ?></td>
            <td><?php echo $baris['nama_pasien']; ?></td>
            <td><?php echo $baris['tanggal_periksa']; ?></td>
            <td>Rp <?php echo number_format($baris['biaya'], 0, ',', '.'); ?></td>
            <td class="text-center">
                <?php if ($baris['status_pembayaran'] == 'Lunas'): ?>
                    <span class="badge bg-success">Lunas</span>
                <?php else: ?>
                    <span class="badge bg-danger">Belum Lunas</span>
                <?php endif; ?>
            </td>
            <td><?php echo $baris['tanggal_bayar']; ?></td>
            <td class="text-center">
                <div class="aksi-buttons">
                    <a href="pembayaran_edit.php?id=<?php echo $baris['id_pembayaran']; ?>" class="btn btn-warning btn-sm btn-icon" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <a href="pembayaran_hapus.php?id=<?php echo $baris['id_pembayaran']; ?>" class="btn btn-danger btn-sm btn-icon" title="Hapus"
                       onclick="return confirm('Yakin ingin menghapus?')">
                        <i class="bi bi-trash"></i>
                    </a>
                </div>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<?php } ?>