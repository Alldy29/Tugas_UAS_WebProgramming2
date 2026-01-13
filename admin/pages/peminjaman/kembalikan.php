<?php
include "../../../config/koneksi.php";

$id = $_GET['id'];

// Ambil detail buku
$q = mysqli_query($koneksi, "SELECT * FROM detail_peminjaman WHERE id_peminjaman='$id'");

while ($d = mysqli_fetch_assoc($q)) {
    $id_buku = $d['id_buku'];
    $jumlah = $d['jumlah'];

    // Kembalikan stok
    mysqli_query($koneksi, "UPDATE buku SET stok = stok + $jumlah WHERE id_buku = '$id_buku'");
}

// Update status
mysqli_query($koneksi, "
    UPDATE peminjaman 
    SET status='Dikembalikan'
    WHERE id_peminjaman='$id'
");

echo "<script>alert('Buku berhasil dikembalikan!');window.location='../../dashboard.php?page=peminjaman';</script>";
