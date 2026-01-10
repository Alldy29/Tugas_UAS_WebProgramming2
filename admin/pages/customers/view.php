<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Customers</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <!-- Breadcrumb Navigasi -->
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Customers</li>
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
                <h3 class="card-title">Data Customer</h3>
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
                    <a href="dashboard.php?page=addcustomer" class="btn btn-primary ">Tambah Data</a>
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
                            <th style="width: 10px">#</th>
                            <th>Code</th> <!-- Kolom Kode Customer -->
                            <th>Customer Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $sql = "SELECT * FROM customers"; // Query ambil semua data
                        $query = mysqli_query($koneksi, $sql);
                        
                        // Loop data dari database
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $data['customer_code']; ?></td> <!-- Tampilkan Kode -->
                                <td><?php echo $data['name']; ?></td>
                                <td><?php echo $data['address']; ?></td>
                                <td><?php echo $data['phone']; ?></td>
                                <td>
                                    <div class="d-flex">
                                        <!-- Tombol Edit -->
                                        <a href="dashboard.php?page=editcustomer&customer_id=<?php echo $data['customer_id'] ?>"
                                            class="btn btn-sm btn-success mr-2">Edit</a>
                                        
                                        <!-- Tombol Hapus -->
                                        <a href="pages/customers/action.php?act=delete&customer_id=<?php echo $data['customer_id']; ?>"
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