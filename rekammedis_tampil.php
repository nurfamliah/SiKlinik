<?php
// rekammedis_tampil.php
// menampilkan data rekam medis, join ke pasien & dokter
$sql = "SELECT rekam_medis.*, pasien.nama_pasien, dokter.nama_dokter
        FROM rekam_medis
        JOIN pasien ON rekam_medis.id_pasien = pasien.id_pasien
        JOIN dokter ON rekam_medis.id_dokter = dokter.id_dokter
        ORDER BY rekam_medis.id_rekam_medis DESC";
$hasil = mysqli_query($conn, $sql);

if (!$hasil) {
    echo "Query gagal: " . mysqli_error($conn);
} else {
?>
<div class="table-responsive">
<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th class="text-center">No</th>
        <th>Pasien</th>
        <th>Dokter</th>
        <th>Tanggal Periksa</th>
        <th>Keluhan</th>
        <th>Diagnosis</th>
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
            <td><?php echo $baris['nama_dokter']; ?></td>
            <td><?php echo $baris['tanggal_periksa']; ?></td>
            <td><?php echo $baris['keluhan']; ?></td>
            <td><?php echo $baris['diagnosis']; ?></td>
            <td class="text-center">
                <div class="aksi-buttons">
                    <a href="rekammedis_edit.php?id=<?php echo $baris['id_rekam_medis']; ?>" class="btn btn-warning btn-sm btn-icon" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <a href="rekammedis_hapus.php?id=<?php echo $baris['id_rekam_medis']; ?>" class="btn btn-danger btn-sm btn-icon" title="Hapus"
                       onclick="return confirm('Yakin ingin menghapus?')">
                        <i class="bi bi-trash"></i>
                    </a>
                    <a href="tabel-resep.php?id_rekam_medis=<?php echo $baris['id_rekam_medis']; ?>" class="btn btn-info btn-sm btn-icon text-white" title="Lihat Resep">
                        <i class="bi bi-capsule"></i>
                    </a>
                    <a href="tabel-pembayaran.php?id_rekam_medis=<?php echo $baris['id_rekam_medis']; ?>" class="btn btn-success btn-sm btn-icon" title="Lihat Pembayaran">
                        <i class="bi bi-cash-coin"></i>
                    </a>
                </div>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</div>
<?php } ?>