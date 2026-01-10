<?php
$id = $_GET['id'];
$sql = "SELECT * FROM buku WHERE id=$id";
$query = mysqli_query($koneksi, $sql);
$buku = mysqli_fetch_assoc($query);
?>

<div class="content">
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="pages/buku/action.php?act=update&id=<?= $buku['id']; ?>">
                    <input class="form-control mb-2" type="text" name="kode_buku" value="<?= $buku['kode_buku']; ?>" required>
                    <input class="form-control mb-2" type="text" name="judul" value="<?= $buku['judul']; ?>" required>
                    <input class="form-control mb-2" type="text" name="pengarang" value="<?= $buku['pengarang']; ?>" required>
                    <input class="form-control mb-2" type="text" name="penerbit" value="<?= $buku['penerbit']; ?>" required>
                    <input class="form-control mb-2" type="number" name="tahun_terbit" value="<?= $buku['tahun_terbit']; ?>" required>
                    <select class="form-control mb-2" name="kategori_id" required>
                        <?php
                        $sql_kategori = "SELECT * FROM kategori";
                        $query_kategori = mysqli_query($koneksi, $sql_kategori);
                        while ($kategori = mysqli_fetch_assoc($query_kategori)) { ?>
                            <option value="<?= $kategori['id']; ?>" <?= $buku['kategori_id']==$kategori['id']?'selected':''; ?>>
                                <?= $kategori['nama_kategori']; ?>
                            </option>
                        <?php } ?>
                    </select>
                    <input class="form-control mb-2" type="number" name="stok" value="<?= $buku['stok']; ?>" required>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
