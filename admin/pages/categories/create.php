<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Category</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <!-- Data Routing (Breadcrumb) berfungsi untuk navigasi -->
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Tambah Category</li>
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
                <h3 class="card-title">Tambah Category</h3>
            </div>
            <div class="card-body">
                <!-- Form untuk mengirim data ke action.php dengan method POST -->
                <!-- action: tujuan pengiriman data, page/categories/action.php dengan parameter act=insert -->
                <form action="pages/categories/action.php?act=insert" method="POST">
                    
                    <!-- Input untuk Nama Kategori -->
                    <!-- class form-group untuk grouping elemen input -->
                    <div class="form-group">
                        <label>Category Name</label>
                        <!-- name="category_name" adalah kunci yang akan diterima di $_POST['category_name'] -->
                        <!-- required artinya input ini tidak boleh kosong -->
                        <input type="text" class="form-control" name="category_name" required>
                    </div>

                    <!-- Tombol Simpan -->
                    <!-- type="submit" berarti tombol ini akan mensubmit form -->
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
