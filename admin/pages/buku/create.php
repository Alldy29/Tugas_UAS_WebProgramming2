<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Buku</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                    <li class="breadcrumb-item active">Tambah Buku</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="content">
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tambah Buku</h3>
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
                <form method="POST" action="pages/buku/action.php?act=insert">
                    <!-- Kode Buku -->
                    <input class="form-control mb-2" type="text" name="kode_buku"
                           placeholder="Kode Buku" required>

                    <!-- Judul Buku -->
                    <input class="form-control mb-2" type="text" name="judul"
                           placeholder="Judul Buku" required>

                    <!-- Pengarang -->
                    <input class="form-control mb-2" type="text" name="pengarang"
                           placeholder="Pengarang" required>

                    <!-- Penerbit -->
                    <input class="form-control mb-2" type="text" name="penerbit"
                           placeholder="Penerbit" required>

                    <!-- Tahun Terbit (YEAR) -->
                    <select
                    name="tahun_terbit"
                    class="form-control mb-2"
                    required>

                    <option value="">-- Pilih Tahun --</option>

                    <?php
                    $tahun_mulai = 2000;
                    $tahun_sekarang = date('Y');

                    for ($tahun = $tahun_mulai; $tahun <= $tahun_sekarang; $tahun++) {
                        echo "<option value='$tahun'>$tahun</option>";
                    }
                    ?>
                </select>

                    <!-- Kategori -->
                    <select class="form-control mb-2" name="kategori_id" required>
                        <option value="">Pilih Kategori</option>
                        <?php
                        $sql = "SELECT * FROM kategori ORDER BY nama_kategori ASC";
                        $query = mysqli_query($koneksi, $sql);
                        while ($kategori = mysqli_fetch_assoc($query)) {
                        ?>
                            <option value="<?= $kategori['id_kategori']; ?>">
                                <?= $kategori['nama_kategori']; ?>
                            </option>
                        <?php
                        }
                        ?>
                    </select>

                    <!-- Stok -->
                    <input class="form-control mb-2" type="number" name="stok"
                           placeholder="Stok" min="0" required>

                    <!-- Tombol Simpan & Reset -->
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="reset" class="btn btn-danger">Reset</button>
                </form>
            </div>

        </div>
    </div>
</div>
