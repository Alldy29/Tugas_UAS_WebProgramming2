<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Sales (Penjualan)</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Sales</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Riwayat Penjualan</h3>
            </div>
            <div class="card-body">
                <div class="d-flex mb-3 justify-content-between" >
                    <a href="dashboard.php?page=addsale" class="btn btn-primary ">Tambah Transaksi Baru</a>
                </div>
                
                <?php
                if (isset($_SESSION['message'])) {
                ?>
                    <div class="alert <?php echo $_SESSION['alert_type']; ?> alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><?php echo $_SESSION['type']; ?></h5>
                        <?php echo $_SESSION['message']; ?>
                    </div>
                <?php
                    unset($_SESSION['message']);
                    unset($_SESSION['alert_type']);
                    unset($_SESSION['type']);
                }
                ?>
                
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Invoice Number</th>
                            <th>Tanggal</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        // Join ke tabel customers untuk nama customer
                        $sql = "SELECT sales.*, customers.name as customer_name FROM sales 
                                LEFT JOIN customers ON sales.customer_id = customers.customer_id 
                                ORDER BY sale_date DESC";
                        $query = mysqli_query($koneksi, $sql);
                        
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $data['invoice_number']; ?></td>
                                <td><?php echo $data['sale_date']; ?></td>
                                <td><?php echo $data['customer_name'] ? $data['customer_name'] : 'Umum/Guest'; ?></td>
                                <td><?php echo number_format($data['total'], 0, ',', '.'); ?></td>
                                <td>
                                    <a href="dashboard.php?page=detailsale&id=<?php echo $data['sale_id']; ?>" 
                                       class="btn btn-sm btn-info">Detail</a>
                                </td>
                            </tr>
                        <?php $no++;
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
