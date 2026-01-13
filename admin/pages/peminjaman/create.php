<?php
include "../config/koneksi.php";

// =======================
// GENERATE NO PEMINJAMAN
// =======================
$today = date("Ymd");
$q = mysqli_query($koneksi, "SELECT no_pinjam FROM peminjaman WHERE no_pinjam LIKE 'PINJ/$today%' ORDER BY id_peminjaman DESC LIMIT 1");
$d = mysqli_fetch_array($q);

if ($d) {
    $last = $d['no_pinjam'];
    $number = (int) substr($last, -3) + 1;
} else {
    $number = 1;
}

$new_pinjam = "PINJ/" . $today . "/" . sprintf("%03s", $number);

// =======================
// LOAD DATA MASTER
// =======================
$q_anggota = mysqli_query($koneksi, "SELECT * FROM anggota");
$q_buku = mysqli_query($koneksi, "SELECT * FROM buku");

// default tanggal kembali = 7 hari dari sekarang
$default_kembali = date('Y-m-d', strtotime('+7 days'));
?>

<div class="content-header">
    <h1>📘 Peminjaman Buku Baru</h1>
</div>

<form action="pages/peminjaman/action.php?act=insert" method="POST">
    <div class="row">
        <!-- KIRI -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white"><strong>📝 Data Peminjaman</strong></div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Nomor Peminjaman</label>
                        <input type="text" class="form-control" name="no_pinjam" value="<?= $new_pinjam ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Pinjam</label>
                        <input type="text" class="form-control" value="<?= date('d-m-Y') ?>" readonly>
                        <input type="hidden" name="tanggal_pinjam" value="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Kembali</label>
                        <input type="date" class="form-control" name="tanggal_kembali" value="<?= $default_kembali ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Anggota</label>
                        <select class="form-control" name="id_anggota" required>
                            <option value="">-- Pilih Anggota --</option>
                            <?php while ($a = mysqli_fetch_assoc($q_anggota)) { ?>
                                <option value="<?= $a['id_anggota'] ?>"><?= $a['nama_anggota'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- KANAN -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white"><strong>📚 Daftar Buku Dipinjam</strong></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="itemTable">
                            <thead class="thead-light">
                                <tr class="text-center">
                                    <th>Buku</th>
                                    <th width="120">Jumlah</th>
                                    <th width="50">Hapus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="item-row">
                                    <td>
                                        <select class="form-control buku-select" name="id_buku[]" required>
                                            <option value="">-- Pilih Buku --</option>
                                            <?php
                                            mysqli_data_seek($q_buku, 0);
                                            while ($b = mysqli_fetch_assoc($q_buku)) { ?>
                                                <option value="<?= $b['id_buku'] ?>" data-stok="<?= $b['stok'] ?>">
                                                    <?= $b['judul'] ?> (Stok: <?= $b['stok'] ?>)
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control qty-input text-center" name="qty[]" value="1" min="1" required>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-danger btn-sm remove-row">🗑</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button type="button" class="btn btn-success btn-sm" onclick="addRow()">➕ Tambah Baris</button>
                    <hr>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">💾 Simpan Peminjaman</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    // ADD ROW
    function addRow() {
        var table = document.getElementById("itemTable").getElementsByTagName("tbody")[0];
        var first = table.rows[0];
        var clone = first.cloneNode(true);
        clone.querySelector(".qty-input").value = 1;
        clone.querySelector(".qty-input").removeAttribute("max");
        clone.querySelector(".buku-select").selectedIndex = 0;
        clone.querySelector(".remove-row").onclick = function() {
            if (table.rows.length > 1) this.closest("tr").remove();
        };
        table.appendChild(clone);
    }

    // REMOVE ROW
    document.addEventListener("click", function(e) {
        if (e.target.classList.contains("remove-row")) {
            var table = document.getElementById("itemTable").getElementsByTagName("tbody")[0];
            if (table.rows.length > 1) e.target.closest("tr").remove();
        }
    });

    // CEK STOK
    document.addEventListener("change", function(e) {
        if (e.target.classList.contains("buku-select")) {
            let row = e.target.closest("tr");
            let stok = e.target.options[e.target.selectedIndex].dataset.stok;
            let qty = row.querySelector(".qty-input");
            if (stok) {
                qty.max = stok;
                if (parseInt(qty.value) > parseInt(stok)) {
                    qty.value = stok;
                    alert("⚠ Stok tidak mencukupi! Maksimal: " + stok);
                }
            }
        }
    });

    // VALIDASI QTY
    document.addEventListener("input", function(e) {
        if (e.target.classList.contains("qty-input")) {
            let row = e.target.closest("tr");
            let select = row.querySelector(".buku-select");
            let stok = select.options[select.selectedIndex]?.dataset.stok;
            if (!stok) return;
            if (parseInt(e.target.value) > parseInt(stok)) e.target.value = stok;
            if (parseInt(e.target.value) < 1) e.target.value = 1;
        }
    });
</script>
