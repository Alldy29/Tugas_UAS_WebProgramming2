<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Buku</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
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
                <h3 class="card-title">Buku</h3>
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
                <div class="d-flex mb-3 justify-content-between">
                    <a href="dashboard.php?page=addbuku" class="btn btn-primary">Tambah Buku</a>
                    <a href="pages/buku/print.php" class="btn btn-success" target="_blank">Cetak</a>
                </div>

                <?php
                if (isset($_SESSION['message'])) {
                ?>
                    <div class="alert <?php echo $_SESSION['alert_type']; ?> alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5>
                            <?php if ($_SESSION['type'] == 'Success') { ?>
                                <i class="icon fas fa-check"></i>
                            <?php } else { ?>
                                <i class="icon fas fa-ban"></i>
                            <?php } ?>
                            <?php echo $_SESSION['type'] ?>
                        </h5>
                        <?php echo $_SESSION['message']; ?>
                    </div>
                <?php
                    unset($_SESSION['message']);
                    unset($_SESSION['alert_type']);
                    unset($_SESSION['type']);
                }
                ?>

                <form method="GET" action="">
                    <input type="hidden" name="page" value="buku">
                    <div class="row">
                        <div class="col-10">
                            <input class="form-control mb-2" type="text" name="judul"
                                   placeholder="Judul Buku"
                                   value="<?php if (isset($_GET['judul'])) echo $_GET['judul']; ?>">
                        </div>
                        <div class="col-2">
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </div>
                    </div>
                </form>

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
                        // Query buku join kategori
                        $sql = "SELECT * FROM buku 
                                INNER JOIN kategori ON buku.id_kategori = kategori.id_kategori";

                        if (isset($_GET['judul'])) {
                            $judul = $_GET['judul'];
                            $sql .= " WHERE judul LIKE '%$judul%'";
                        }
                        $query = mysqli_query($koneksi, $sql);
                        while ($buku = mysqli_fetch_array($query)) {
                        ?>

                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= $buku['kode_buku']; ?></td>
                                <td><?= $buku['judul']; ?></td>
                                <td><?= $buku['nama_kategori']; ?></td>
                                <td><?= $buku['pengarang']; ?></td>
                                <td><?= $buku['penerbit']; ?></td>
                                <td><?= $buku['tahun_terbit']; ?></td>
                                <td><?= $buku['stok']; ?></td>
                                <td>
                                    <div class="d-flex">
                                        <a href="dashboard.php?page=editbuku&id=<?= $buku['id']; ?>"
                                           class="btn btn-sm btn-success mr-2">Edit</a>
                                        <a href="pages/buku/action.php?act=delete&id=<?= $buku['id']; ?>"
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Yakin hapus buku ini?')">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                        <?php $no++; } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
