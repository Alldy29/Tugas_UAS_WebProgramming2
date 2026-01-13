<?php
include "../config/koneksi.php";

// ===============================
// FUNGSI FORMAT TANGGAL
// ===============================
function tglIndo($tgl)
{
    if (!$tgl || $tgl == '0000-00-00') return '-';
    return date('d-m-Y', strtotime($tgl));
}

if (!isset($_GET['id'])) {
    echo "<script>alert('ID Peminjaman tidak ditemukan!');window.location='dashboard.php?page=peminjaman';</script>";
    exit;
}

$id_peminjaman = $_GET['id'];

// ===============================
// AMBIL HEADER PEMINJAMAN (PAKAI ALIAS + COALESCE)
// ===============================
$sql_header = "SELECT 
                    p.id_peminjaman,
                    p.no_pinjam,
                    p.status,
                    COALESCE(p.tanggal_pinjam,'') AS tgl_pinjam,
                    COALESCE(p.tanggal_kembali,'') AS tgl_kembali,
                    a.nama_anggota
               FROM peminjaman p
               LEFT JOIN anggota a ON p.id_anggota = a.id_anggota
               WHERE p.id_peminjaman = '$id_peminjaman'";

$q_header = mysqli_query($koneksi, $sql_header);
$header = mysqli_fetch_assoc($q_header);

if (!$header) {
    echo "<script>alert('Data tidak ditemukan');window.location='dashboard.php?page=peminjaman';</script>";
    exit;
}

// ===============================
// AMBIL DETAIL BUKU
// ===============================
$sql_detail = "SELECT d.*, b.judul 
               FROM detail_peminjaman d
               LEFT JOIN buku b ON d.id_buku = b.id_buku
               WHERE d.id_peminjaman = '$id_peminjaman'";

$q_detail = mysqli_query($koneksi, $sql_detail);

// ===============================
// CEK TERLAMBAT
// ===============================
$today = date('Y-m-d');
$terlambat = false;

if (
    $header['status'] == 'Dipinjam' &&
    !empty($header['tgl_kembali']) &&
    $header['tgl_kembali'] != '0000-00-00' &&
    $today > $header['tgl_kembali']
) {
    $terlambat = true;
}
?>

<div class="content-header">
    <h1>📄 Detail Peminjaman Buku</h1>
</div>

<div class="content">
    <div class="card">

        <div class="card-header">
            <h3 class="card-title">No Peminjaman: <?= $header['no_pinjam']; ?></h3>
            <div class="card-tools">
                <button onclick="window.print()" class="btn btn-primary btn-sm">🖨 Print</button>
                <a href="dashboard.php?page=peminjaman" class="btn btn-secondary btn-sm">⬅ Kembali</a>
            </div>
        </div>

        <div class="card-body">

            <!-- ================= HEADER INFO ================= -->
            <table class="table table-bordered">
                <tr>
                    <th width="200">Nama Anggota</th>
                    <td><?= $header['nama_anggota']; ?></td>
                </tr>
                <tr>
                    <th>Tanggal Pinjam</th>
                    <td><?= tglIndo($header['tgl_pinjam']); ?></td>
                </tr>
                <tr>
                    <th>Tanggal Kembali</th>
                    <td><?= tglIndo($header['tgl_kembali']); ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <?php if ($header['status'] == 'Dikembalikan') { ?>

                            <span class="badge badge-success">Dikembalikan</span>

                        <?php } else { ?>

                            <?php if ($terlambat) { ?>
                                <span class="badge badge-danger">Terlambat</span>
                            <?php } else { ?>
                                <span class="badge badge-warning">Dipinjam</span>
                            <?php } ?>

                            <a href="pages/peminjaman/kembalikan.php?id=<?= $id_peminjaman ?>"
                               onclick="return confirm('Yakin ingin mengembalikan buku ini?')"
                               class="btn btn-sm btn-success ml-2">
                               ✅ Konfirmasi Pengembalian
                            </a>

                        <?php } ?>
                    </td>
                </tr>
            </table>

            <!-- ================= DETAIL BUKU ================= -->
            <h5 class="mt-4">📚 Daftar Buku Dipinjam</h5>

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Judul Buku</th>
                        <th width="120">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($d = mysqli_fetch_assoc($q_detail)) {
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $d['judul']; ?></td>
                            <td><?= $d['jumlah']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>
    </div>
</div>
