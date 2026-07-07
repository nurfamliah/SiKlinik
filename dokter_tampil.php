<?php
// dokter_tampil.php
// menampilkan data dokter dalam bentuk tabel
$sql = "SELECT * FROM dokter ORDER BY id_dokter DESC";
$hasil = mysqli_query($conn, $sql);

if (!$hasil) {
    echo "Query gagal: " . mysqli_error($conn);
} else {
?>
<div class="table-responsive">
<table class="table table-bordered table-striped" id="tabel-dokter">
    <thead>
    <tr>
        <th class="text-center">No</th>
        <th class="text-center">Foto</th>
        <th>Nama Dokter</th>
        <th>Spesialisasi</th>
        <th>No HP</th>
        <th class="text-center">Aksi</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $no = 1;
    while ($baris = mysqli_fetch_assoc($hasil)) {
    ?>
        <tr data-spesialisasi="<?php echo htmlspecialchars($baris['spesialisasi']); ?>">
            <td class="text-center"><?php echo $no++; ?></td>
            <td class="text-center">
                <?php if (!empty($baris['foto']) && file_exists("assets/foto_dokter/" . $baris['foto'])): ?>
                    <img src="assets/foto_dokter/<?php echo $baris['foto']; ?>" class="foto-dokter">
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
            <td class="kolom-nama"><?php echo $baris['nama_dokter']; ?></td>
            <td><?php echo $baris['spesialisasi']; ?></td>
            <td><?php echo $baris['no_hp']; ?></td>
            <td class="text-center">
                <div class="aksi-buttons">
                    <a href="dokter_edit.php?id=<?php echo $baris['id_dokter']; ?>" class="btn btn-warning btn-sm btn-icon" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <a href="dokter_hapus.php?id=<?php echo $baris['id_dokter']; ?>" class="btn btn-danger btn-sm btn-icon" title="Hapus"
                       onclick="return confirm('Yakin ingin menghapus?')">
                        <i class="bi bi-trash"></i>
                    </a>
                </div>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</div>
<?php } ?>