<?php
// Ambil customer_id dari URL
$customer_id = $_GET['customer_id'];

// Ambil data customer saat ini dari database untuk ditampilkan di form
$sql = "SELECT * FROM customers WHERE customer_id = '$customer_id'";
$query = mysqli_query($koneksi, $sql);
$data = mysqli_fetch_array($query);
?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Customer</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <!-- Breadcrumb -->
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Edit Customer</li>
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
                <h3 class="card-title">Edit Customer</h3>
            </div>
            <div class="card-body">
                <!-- Form Update -->
                <form action="pages/customers/action.php?act=update&customer_id=<?php echo $customer_id; ?>" method="POST">
                    
                    <!-- Menampilkan Customer Code tapi Read-Only (Tidak bisa diedit) karena unik -->
                    <div class="form-group">
                        <label>Customer Code</label>
                        <input type="text" class="form-control" value="<?php echo $data['customer_code']; ?>" readonly>
                    </div>
                    
                    <!-- Input Nama -->
                    <div class="form-group">
                        <label>Customer Name</label>
                        <input type="text" class="form-control" name="name" value="<?php echo $data['name']; ?>" required>
                    </div>
                    
                    <!-- Input Alamat -->
                    <div class="form-group">
                        <label>Address</label>
                        <textarea class="form-control" name="address" required><?php echo $data['address']; ?></textarea>
                    </div>
                    
                    <!-- Input Telepon -->
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" class="form-control" name="phone" value="<?php echo $data['phone']; ?>" required>
                    </div>
                    
                    <!-- Tombol Simpan -->
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
