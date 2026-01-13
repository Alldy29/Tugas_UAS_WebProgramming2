<?php
include "../../../config/koneksi.php";
session_start();

if (isset($_GET['act'])) {
    $act = $_GET['act'];

    // ===============================
    // INSERT PEMINJAMAN
    // ===============================
    if ($act == "insert") {

        // AMBIL DATA HEADER
        $no_pinjam        = $_POST['no_pinjam'];
        $tanggal_pinjam   = $_POST['tanggal_pinjam']; 
        $tanggal_kembali  = $_POST['tanggal_kembali']; 
        $id_anggota       = $_POST['id_anggota'];
        $id_users         = $_SESSION['id_users'] ?? 1;

        // AMBIL BUKU PERTAMA UNTUK DI HEADER
        $id_buku_header = $_POST['id_buku'][0] ?? 0;

        // SIMPAN HEADER PEMINJAMAN
        $sql = "INSERT INTO peminjaman 
                (no_pinjam, tanggal_pinjam, tanggal_kembali, id_anggota, id_users, status, id_buku)
                VALUES 
                ('$no_pinjam','$tanggal_pinjam','$tanggal_kembali','$id_anggota','$id_users','Dipinjam','$id_buku_header')";

        if (!mysqli_query($koneksi, $sql)) {
            die("❌ Gagal simpan peminjaman: " . mysqli_error($koneksi));
        }

        $id_peminjaman = mysqli_insert_id($koneksi);

        // LOOP DETAIL BUKU
        foreach ($_POST['id_buku'] as $i => $id_buku) {

            if (empty($id_buku)) continue;

            $jumlah = $_POST['qty'][$i];
            if ($jumlah < 1) continue;

            // CEK STOK
            $q = mysqli_query($koneksi, "SELECT stok FROM buku WHERE id_buku='$id_buku'");
            $d = mysqli_fetch_assoc($q);

            if ($d['stok'] < $jumlah) {
                echo "<script>
                    alert('❌ Stok buku tidak mencukupi!');
                    window.history.back();
                </script>";
                exit;
            }

            // SIMPAN DETAIL PEMINJAMAN
            mysqli_query($koneksi, "INSERT INTO detail_peminjaman (id_peminjaman, id_buku, jumlah)
                                    VALUES ('$id_peminjaman','$id_buku','$jumlah')");

            // KURANGI STOK
            mysqli_query($koneksi, "UPDATE buku SET stok = stok - $jumlah WHERE id_buku='$id_buku'");
        }

        echo "<script>
            alert('✅ Peminjaman berhasil disimpan!');
            window.location='../../dashboard.php?page=peminjaman';
        </script>";
        exit;
    }

    // ===============================
    // PENGEMBALIAN BUKU
    // ===============================
    if ($act == "kembali") {

        $id_peminjaman = $_GET['id'];

        // ambil semua buku dari detail
        $q = mysqli_query($koneksi, "SELECT id_buku, jumlah FROM detail_peminjaman WHERE id_peminjaman='$id_peminjaman'");

        while ($d = mysqli_fetch_assoc($q)) {
            mysqli_query(
                $koneksi,
                "UPDATE buku SET stok = stok + {$d['jumlah']} WHERE id_buku = '{$d['id_buku']}'"
            );
        }

        // update status peminjaman + tanggal kembali
        mysqli_query(
            $koneksi,
            "UPDATE peminjaman 
             SET status = 'Dikembalikan', tanggal_kembali = CURDATE()
             WHERE id_peminjaman = '$id_peminjaman'"
        );

        header('Location: ../../dashboard.php?page=peminjaman');
        exit;
    }
}
