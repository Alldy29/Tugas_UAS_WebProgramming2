<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- Judul Halaman -->
                <h1 class="m-0">Tambah Customer</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <!-- Navigasi Breadcrumb -->
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Tambah Customer</li>
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
                <h3 class="card-title">Tambah Customer</h3>
            </div>
            <div class="card-body">
                <!-- Form Insert -->
                <!-- Kode Customer (Customer Code) tidak perlu diinput karena dibuat otomatis oleh sistem di action.php -->
                
                <form action="pages/customers/action.php?act=insert" method="POST">
                    <!-- Input Nama Customer -->
                    <div class="form-group">
                        <label>Customer Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    
                    <!-- Input Alamat (Textarea untuk teks panjang) -->
                    <div class="form-group">
                        <label>Address</label>
                        <textarea class="form-control" name="address" required></textarea>
                    </div>
                    
                    <!-- Input Nomor Telepon -->
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" class="form-control" name="phone" required>
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
