<?php
// Ambil id_anggota dari URL
$id_anggota = $_GET['id_anggota'];

// Ambil data anggota saat ini dari database untuk ditampilkan di form
$sql = "SELECT * FROM anggota WHERE id_anggota = '$id_anggota'";
$query = mysqli_query($koneksi, $sql);
$data = mysqli_fetch_array($query);
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Anggota</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <!-- Breadcrumb -->
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Edit Anggota</li>
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
                <h3 class="card-title">Edit Anggota</h3>
            </div>
            <div class="card-body">
                <!-- Form Update -->
                <form action="pages/anggota/action.php?act=update&id_anggota=<?php echo $id_anggota; ?>" method="POST">
                    
                    <!-- Menampilkan Kode Anggota tapi Read-Only (Tidak bisa diedit) karena unik -->
                    <div class="form-group">
                        <label>Kode Anggota</label>
                        <input type="text" class="form-control" value="<?php echo $data['kode_anggota']; ?>" readonly>
                    </div>
                    
                    <!-- Input Nama -->
                    <div class="form-group">
                        <label>Nama Anggota</label>
                        <input type="text" class="form-control" name="nama" value="<?php echo $data['nama']; ?>" required>
                    </div>

                    <!-- Input Jenis Kelamin (Dropdown L / P) -->
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control" required>
                            <option value="L" <?php if($data['jenis_kelamin']=='L') echo 'selected'; ?>>Laki-laki</option>
                            <option value="P" <?php if($data['jenis_kelamin']=='P') echo 'selected'; ?>>Perempuan</option>
                        </select>
                    </div>
                    
                    <!-- Input Alamat -->
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea class="form-control" name="alamat" required><?php echo $data['alamat']; ?></textarea>
                    </div>
                    
                    <!-- Input Nomor Telepon -->
                    <div class="form-group">
                        <label>No HP</label>
                        <input type="text" class="form-control" name="no_hp" value="<?php echo $data['no_hp']; ?>" required>
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
