<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Anggota</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <!-- Breadcrumb Navigasi -->
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Anggota</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Anggota</h3>
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
                <div class="d-flex mb-3 justify-content-between" >
                    <!-- Tombol Tambah Data -->
                    <a href="dashboard.php?page=addanggota" class="btn btn-primary ">Tambah Data</a>
                </div>
                
                <?php
                // Logika Menampilkan Alert Notifikasi
                if (isset($_SESSION['message'])) {
                ?>
                    <div class="alert <?php echo $_SESSION['alert_type']; ?> alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5>
                            <?php
                            if ($_SESSION['type'] == 'Success') {
                            ?>
                                <i class="icon fas fa-check"></i>
                            <?php
                            } else {
                            ?>
                                <i class="icon fas fa-ban"></i>
                            <?php } ?>
                            <?php echo $_SESSION['type'] ?>
                        </h5>
                        <!-- Pesan dari Session -->
                        <?php echo $_SESSION['message']; ?>
                    </div>
                <?php
                    // Hapus session setelah ditampilkan
                    unset($_SESSION['message']);
                    unset($_SESSION['alert_type']);
                    unset($_SESSION['type']);
                }
                ?>
                
                <!-- Tabel Data Customer -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 10px">No</th>
                            <th>Kode_anggota</th> <!-- Kolom Kode Customer -->
                            <th>Nama Anggota</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th>No HP</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $sql = "SELECT * FROM anggota"; // Query ambil semua data
                        $query = mysqli_query($koneksi, $sql);
                        
                        // Loop data dari database
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $data['kode_anggota']; ?></td> <!-- Tampilkan Kode -->
                                <td><?php echo $data['nama']; ?></td>
                                <td><?php echo $data['jenis_kelamin']; ?></td>
                                <td><?php echo $data['alamat']; ?></td>
                                <td><?php echo $data['no_hp']; ?></td>
                                <td>
                                    <div class="d-flex">
                                        <!-- Tombol Edit -->
                                        <a href="dashboard.php?page=editanggota&id_anggota=<?php echo $data['id_anggota'] ?>"
                                            class="btn btn-sm btn-success mr-2">Edit</a>
                                        
                                        <!-- Tombol Hapus -->
                                        <a href="pages/anggota/action.php?act=delete&id_anggota=<?php echo $data['id_anggota']; ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are You Sure, Delete this Data')">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                        <?php $no++;
                        } ?>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->

        </div>
    </div><!-- /.container-fluid -->
</div>