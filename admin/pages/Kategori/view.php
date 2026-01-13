<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Kategori</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="../../dashboard.php">Home</a></li>
                    <li class="breadcrumb-item active">Kategori</li>
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
                <h3 class="card-title">Kategori</h3>
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
                    <!-- Tombol untuk menuju halaman tambah kategori -->
                    <!-- Link mengarah ke dashboard.php dengan parameter page=addcategory -->
                    <a href="dashboard.php?page=addkategori" class="btn btn-primary ">Tambah Data</a>
                </div>
                <?php
                // Mengecek apakah ada pesan notifikasi dari session
                if (isset($_SESSION['message'])) {
                ?>
                    <!-- Menampilkan alert notifikasi -->
                    <div class="alert <?php echo $_SESSION['alert_type']; ?> alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5>
                            <?php
                            // Menampilkan icon berdasarkan tipe pesan (Success/Failed)
                            if ($_SESSION['type'] == 'Success') {
                            ?>
                                <i class="icon fas fa-check"></i>
                            <?php
                            } else {
                            ?>
                                <i class="icon fas fa-ban"></i>
                            <?php } ?>
                            <!-- Menampilkan judul tipe pesan -->
                            <?php echo $_SESSION['type'] ?>
                        </h5>
                        <!-- Menampilkan isi pesan -->
                        <?php echo $_SESSION['message']; ?>
                    </div>
                <?php
                    // Menghapus session notifikasi agar tidak muncul lagi saat refresh
                    unset($_SESSION['message']);
                    unset($_SESSION['alert_type']);
                    unset($_SESSION['type']);
                }
                ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 10px">No</th>
                            <th>Nama Kategori</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1; // Inisialisasi nomor urut
                        $sql = "SELECT * FROM kategori"; // Query untuk mengambil semua data kategori
                        $query = mysqli_query($koneksi, $sql); // Eksekusi query
                        
                        // Looping data hasil query
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td> <!-- Menampilkan nomor urut -->
                                <td><?php echo $data['nama_kategori']; ?></td> <!-- Menampilkan nama kategori -->
                                <td>
                                    <div class="d-flex">
                                        <!-- Tombol Edit: mengirim parameter page=editcategory dan category_id -->
                                        <a href="dashboard.php?page=editkategori&id_kategori=<?php echo $data['id_kategori'] ?>"
                                            class="btn btn-sm btn-success mr-2">Edit</a>
                                        
                                        <!-- Tombol Hapus: mengirim parameter ke action.php dengan act=delete dan category_id -->
                                        <!-- onclick confirm untuk konfirmasi sebelum menghapus -->
                                        <a href="pages/kategori/action.php?act=delete&id_kategori=<?php echo $data['id_kategori']; ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are You Sure, Delete this Data')">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                        <?php $no++; // Increment nomor urut
                        } ?>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->

        </div>
    </div><!-- /.container-fluid -->
</div>
