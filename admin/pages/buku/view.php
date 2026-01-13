<?php
// Pastikan session sudah di-start
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Koneksi database
include "../config/koneksi.php";
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Buku</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                    <li class="breadcrumb-item active">Buku</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Buku</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <div class="card-body">

                <!-- Tombol Tambah & Cetak -->
                <div class="d-flex mb-3 justify-content-between">
                    <a href="dashboard.php?page=addbuku" class="btn btn-primary">Tambah Buku</a>
                    
                </div>

                <!-- Pesan Sukses / Error -->
                <?php
                if (isset($_SESSION['message'])) {
                ?>
                    <div class="alert <?= $_SESSION['alert_type']; ?> alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5>
                            <?php if ($_SESSION['type'] == 'Success') { ?>
                                <i class="icon fas fa-check"></i>
                            <?php } else { ?>
                                <i class="icon fas fa-ban"></i>
                            <?php } ?>
                            <?= $_SESSION['type']; ?>
                        </h5>
                        <?= $_SESSION['message']; ?>
                    </div>
                <?php
                    unset($_SESSION['message']);
                    unset($_SESSION['alert_type']);
                    unset($_SESSION['type']);
                }
                ?>

                <!-- Form Pencarian Judul -->
                <form method="GET" action="">
                    <input type="hidden" name="page" value="buku">
                    <div class="row">
                        <div class="col-10">
                            <input class="form-control mb-2" type="text" name="judul"
                                placeholder="Judul Buku"
                                value="<?= isset($_GET['judul']) ? htmlspecialchars($_GET['judul']) : ''; ?>">
                        </div>
                        <div class="col-2">
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </div>
                    </div>
                </form>

                <!-- Tabel Buku -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 10px">No</th>
                            <th>Kode Buku</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Pengarang</th>
                            <th>Penerbit</th>
                            <th>Tahun Terbit</th>
                            <th>Stok</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;

                        // Query buku + kategori (SUDAH BENAR)
                        $sql = "SELECT buku.*, kategori.nama_kategori 
                                FROM buku 
                                LEFT JOIN kategori ON buku.id_kategori = kategori.id_kategori";

                        // Filter pencarian judul
                        if (isset($_GET['judul']) && !empty($_GET['judul'])) {
                            $judul = mysqli_real_escape_string($koneksi, $_GET['judul']);
                            $sql .= " WHERE buku.judul LIKE '%$judul%'";
                        }

                        $query = mysqli_query($koneksi, $sql);

                        // Optional: cek error query (debug)
                        if (!$query) {
                            die("Query Error: " . mysqli_error($koneksi));
                        }

                        while ($buku = mysqli_fetch_assoc($query)) {
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($buku['kode_buku']); ?></td>
                                <td><?= htmlspecialchars($buku['judul']); ?></td>
                                <td><?= $buku['nama_kategori'] ?: '-'; ?></td>
                                <td><?= htmlspecialchars($buku['pengarang']); ?></td>
                                <td><?= htmlspecialchars($buku['penerbit']); ?></td>
                                <td><?= htmlspecialchars($buku['tahun_terbit']); ?></td>
                                <td><?= htmlspecialchars($buku['stok']); ?></td>
                                <td>
                                    <a href="dashboard.php?page=editbuku&id_buku=<?= $buku['id_buku']; ?>"
                                        class="btn btn-sm btn-success">Edit</a>
                                    <a href="pages/buku/action.php?act=delete&id_buku=<?= $buku['id_buku']; ?>"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Yakin hapus buku ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php
                        } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>