<?php
// Mengambil category_id dari parameter URL
// Contoh: dashboard.php?page=editcategory&category_id=1
$category_id = $_GET['category_id'];

// Query untuk mengambil data category berdasarkan ID untuk ditampilkan di form
$sql = "SELECT * FROM categories WHERE category_id = '$category_id'";
$query = mysqli_query($koneksi, $sql);
$data = mysqli_fetch_array($query); // Mengambil data sebagai array
?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Category</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <!-- Breadcrumb -->
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Edit Category</li>
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
                <h3 class="card-title">Edit Category</h3>
            </div>
            <div class="card-body">
                <!-- Form untuk update data -->
                <!-- action mengirim ke action.php dengan act=update dan membawa category_id yang sedang diedit -->
                <form action="pages/categories/action.php?act=update&category_id=<?php echo $category_id; ?>" method="POST">
                    
                    <div class="form-group">
                        <label>Category Name</label>
                        <!-- Menampilkan value lama dari database ke dalam input -->
                        <input type="text" class="form-control" name="category_name" value="<?php echo $data['category_name']; ?>" required>
                    </div>
                    
                    <!-- Tombol Simpan Perubahan -->
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
