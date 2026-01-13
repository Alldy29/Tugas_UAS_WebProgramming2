<?php
include "../config/koneksi.php";

// fungsi format tanggal Indonesia
function tglIndo($tgl)
{
    if (!$tgl || $tgl == '0000-00-00') return '-';
    return date('d-m-Y', strtotime($tgl));
}
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">📚 Peminjaman Buku</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                    <li class="breadcrumb-item active">Peminjaman</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Riwayat Peminjaman Buku</h3>
                <a href="dashboard.php?page=addpeminjaman" class="btn btn-primary btn-sm">
                    ➕ Tambah Peminjaman
                </a>
            </div>

            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead class="thead-dark">
                            <tr class="text-center">
                                <th width="40">No</th>
                                <th width="160">No Pinjam</th>
                                <th width="160">Nama Anggota</th>
                                <th>Buku</th>
                                <th width="120">Tanggal Pinjam</th>
                                <th width="120">Tanggal Kembali</th>
                                <th width="120">Status</th>
                                <th width="90">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $no = 1;

                            $sql = "SELECT 
                                        p.id_peminjaman,
                                        p.no_pinjam,
                                        p.tanggal_pinjam,
                                        p.tanggal_kembali,
                                        p.status,
                                        a.nama_anggota,
                                        GROUP_CONCAT(b.judul SEPARATOR ', ') AS daftar_buku
                                    FROM peminjaman p
                                    LEFT JOIN anggota a ON p.id_anggota = a.id_anggota
                                    LEFT JOIN detail_peminjaman d ON p.id_peminjaman = d.id_peminjaman
                                    LEFT JOIN buku b ON d.id_buku = b.id_buku
                                    GROUP BY p.id_peminjaman
                                    ORDER BY p.id_peminjaman DESC";

                            $query = mysqli_query($koneksi, $sql);

                            if (!$query) {
                                die("Query Error: " . mysqli_error($koneksi));
                            }

                            while ($data = mysqli_fetch_assoc($query)) {
                            ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td><strong><?= $data['no_pinjam']; ?></strong></td>
                                    <td><?= $data['nama_anggota']; ?></td>
                                    <td style="max-width:300px;">
                                        <span title="<?= $data['daftar_buku']; ?>">
                                            <?= strlen($data['daftar_buku']) > 80 ? substr($data['daftar_buku'], 0, 80) . '...' : $data['daftar_buku']; ?>
                                        </span>
                                    </td>
                                    <td class="text-center"><?= tglIndo($data['tanggal_pinjam']); ?></td>
                                    <td class="text-center"><?= tglIndo($data['tanggal_kembali']); ?></td>
                                    <td class="text-center">
                                        <?php if ($data['status'] == 'Dipinjam') { ?>
                                            <span class="badge badge-warning">📦 Dipinjam</span>
                                        <?php } else { ?>
                                            <span class="badge badge-success">✅ Dikembalikan</span>
                                        <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="dashboard.php?page=detailpeminjaman&id=<?= $data['id_peminjaman']; ?>"
                                            class="btn btn-info btn-sm" title="Lihat Detail">
                                            🔍
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
