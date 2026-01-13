<?php
// Mulai session jika belum
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include koneksi database
include "../config/koneksi.php"; // pastikan path ini sesuai struktur folder

// Ambil ID buku dari URL
$id = isset($_GET['id_buku']) ? (int)$_GET['id_buku'] : 0;

// Ambil data buku
$sql = "SELECT * FROM buku WHERE id_buku='$id'";
$query = mysqli_query($koneksi, $sql);
$buku = mysqli_fetch_assoc($query);

// Cek apakah buku ditemukan
if (!$buku) {
    echo "<div class='alert alert-danger'>Buku tidak ditemukan!</div>";
    exit;
}
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Buku</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                    <li class="breadcrumb-item active">Edit Buku</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="pages/buku/action.php?act=update&id_buku=<?= $buku['id_buku']; ?>">
                    <!-- Kode Buku -->
                    <div class="form-group">
                        <label>Kode Buku</label>
                        <input class="form-control" type="text" name="kode_buku" value="<?= htmlspecialchars($buku['kode_buku']); ?>" required>
                    </div>

                    <!-- Judul -->
                    <div class="form-group">
                        <label>Judul</label>
                        <input class="form-control" type="text" name="judul" value="<?= htmlspecialchars($buku['judul']); ?>" required>
                    </div>

                    <!-- Pengarang -->
                    <div class="form-group">
                        <label>Pengarang</label>
                        <input class="form-control" type="text" name="pengarang" value="<?= htmlspecialchars($buku['pengarang']); ?>" required>
                    </div>

                    <!-- Penerbit -->
                    <div class="form-group">
                        <label>Penerbit</label>
                        <input class="form-control" type="text" name="penerbit" value="<?= htmlspecialchars($buku['penerbit']); ?>" required>
                    </div>

                    <!-- Tahun Terbit -->
                    <div class="form-group">
                        <label>Tahun Terbit</label>
                        <input class="form-control" type="number" name="tahun_terbit" value="<?= htmlspecialchars($buku['tahun_terbit']); ?>" required>
                    </div>

                    <!-- Kategori -->
                    <div class="form-group">
                        <label>Kategori</label>
                        <select class="form-control" name="kategori_id" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php
                            $sql_kategori = "SELECT * FROM kategori";
                            $query_kategori = mysqli_query($koneksi, $sql_kategori);
                            while ($kategori = mysqli_fetch_assoc($query_kategori)) {
                                $selected = ($buku['id_kategori'] == $kategori['id_kategori']) ? "selected" : "";
                                echo "<option value='{$kategori['id_kategori']}' $selected>{$kategori['nama_kategori']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Stok -->
                    <div class="form-group">
                        <label>Stok</label>
                        <input class="form-control" type="number" name="stok" value="<?= htmlspecialchars($buku['stok']); ?>" required>
                    </div>

                    <!-- Tombol Update -->
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="dashboard.php?page=buku" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>
