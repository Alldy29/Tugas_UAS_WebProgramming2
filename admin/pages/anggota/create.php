<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- Judul Halaman -->
                <h1 class="m-0">Tambah Anggota</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <!-- Navigasi Breadcrumb -->
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Tambah Anggota</li>
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
                <h3 class="card-title">Tambah Anggota</h3>
            </div>
            <div class="card-body">
                <!-- Form Insert -->
                <!-- Kode Customer (Customer Code) tidak perlu diinput karena dibuat otomatis oleh sistem di action.php -->

                <form action="pages/anggota/action.php?act=insert" method="POST">
                    <!-- Input Nama Customer -->
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="nama" required>
                    </div>

                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" value="L" required>
                                <label class="form-check-label">L</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" value="P" required>
                                <label class="form-check-label">P</label>
                            </div>
                        </div>
                    </div>


                    <!-- Input Alamat (Textarea untuk teks panjang) -->
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea class="form-control" name="alamat" required></textarea>
                    </div>

                    <!-- Input Nomor Telepon -->
                    <div class="form-group">
                        <label>No Hp</label>
                        <input type="text" class="form-control" name="no_hp" required>
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