<?php
// jadwal_tampil.php
// menampilkan data jadwal praktik, join ke tabel dokter biar tampil namanya
// diurutkan berdasarkan urutan hari (Senin -> Minggu), lalu jam mulai paling awal di tiap hari
$sql = "SELECT jadwal_praktik.*, dokter.nama_dokter
        FROM jadwal_praktik
        JOIN dokter ON jadwal_praktik.id_dokter = dokter.id_dokter
        ORDER BY FIELD(jadwal_praktik.hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') ASC,
                 jadwal_praktik.jam_mulai ASC";
$hasil = mysqli_query($conn, $sql);

if (!$hasil) {
    echo "Query gagal: " . mysqli_error($conn);
} else {
?>
<table class="table table-bordered table-striped" id="tabel-jadwal">
    <thead>
    <tr>
        <th class="text-center">No</th>
        <th>Nama Dokter</th>
        <th>Hari</th>
        <th>Jam Mulai</th>
        <th>Jam Selesai</th>
        <th class="text-center">Aksi</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $no = 1;
    while ($baris = mysqli_fetch_assoc($hasil)) {
    ?>
        <tr data-hari="<?php echo htmlspecialchars($baris['hari']); ?>">
            <td class="text-center"><?php echo $no++; ?></td>
            <td class="kolom-nama"><?php echo $baris['nama_dokter']; ?></td>
            <td><?php echo $baris['hari']; ?></td>
            <td><?php echo $baris['jam_mulai']; ?></td>
            <td><?php echo $baris['jam_selesai']; ?></td>
            <td class="text-center">
                <div class="aksi-buttons">
                    <a href="jadwal_edit.php?id=<?php echo $baris['id_jadwal']; ?>" class="btn btn-warning btn-sm btn-icon" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <a href="jadwal_hapus.php?id=<?php echo $baris['id_jadwal']; ?>" class="btn btn-danger btn-sm btn-icon" title="Hapus"
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