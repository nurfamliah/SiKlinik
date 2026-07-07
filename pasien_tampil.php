<?php
// pasien_tampil.php
// menampilkan data pasien dalam bentuk tabel
$sql = "SELECT * FROM pasien ORDER BY id_pasien DESC";
$hasil = mysqli_query($conn, $sql);

if (!$hasil) {
    echo "Query gagal: " . mysqli_error($conn);
} else {
?>
<table class="table table-bordered table-striped" id="tabel-pasien">
    <thead>
    <tr>
        <th class="text-center">ID</th>
        <th>Nama Pasien</th>
        <th>NIK</th>
        <th class="text-center">JK</th>
        <th>Tgl Lahir</th>
        <th>Alamat</th>
        <th>No HP</th>
        <th class="text-center">Aksi</th>
    </tr>
    </thead>
    <tbody>
    <?php
    while ($baris = mysqli_fetch_assoc($hasil)) {
    ?>
        <tr>
            <td class="text-center"><?php echo str_pad($baris['id_pasien'], 6, '0', STR_PAD_LEFT); ?></td>
            <td class="kolom-nama"><?php echo $baris['nama_pasien']; ?></td>
            <td><?php echo $baris['nik']; ?></td>
            <td class="text-center"><?php echo $baris['jenis_kelamin']; ?></td>
            <td><?php echo $baris['tanggal_lahir']; ?></td>
            <td><?php echo $baris['alamat']; ?></td>
            <td><?php echo $baris['no_hp']; ?></td>
            <td class="text-center">
                <div class="aksi-buttons">
                    <a href="pasien_edit.php?id=<?php echo $baris['id_pasien']; ?>" class="btn btn-warning btn-sm btn-icon" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <a href="pasien_hapus.php?id=<?php echo $baris['id_pasien']; ?>" class="btn btn-danger btn-sm btn-icon" title="Hapus"
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