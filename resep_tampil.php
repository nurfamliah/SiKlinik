<?php
// resep_tampil.php
// menampilkan data resep, kalau ada filter id_rekam_medis maka hanya resep itu yang tampil
$sql = "SELECT resep.*, rekam_medis.tanggal_periksa, pasien.nama_pasien
        FROM resep
        JOIN rekam_medis ON resep.id_rekam_medis = rekam_medis.id_rekam_medis
        JOIN pasien ON rekam_medis.id_pasien = pasien.id_pasien";

if (!empty($filter_rekam_medis)) {
    $sql .= " WHERE resep.id_rekam_medis = '$filter_rekam_medis'";
}
$sql .= " ORDER BY resep.id_resep DESC";

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
        <th>Nama Obat</th>
        <th>Dosis</th>
        <th>Aturan Pakai</th>
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
            <td><?php echo $baris['nama_obat']; ?></td>
            <td><?php echo $baris['dosis']; ?></td>
            <td><?php echo $baris['aturan_pakai']; ?></td>
            <td class="text-center">
                <div class="aksi-buttons">
                    <a href="resep_edit.php?id=<?php echo $baris['id_resep']; ?>" class="btn btn-warning btn-sm btn-icon" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <a href="resep_hapus.php?id=<?php echo $baris['id_resep']; ?>" class="btn btn-danger btn-sm btn-icon" title="Hapus"
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