<?php
// Include koneksi database
include "../../../config/koneksi.php";

// Ambil aksi dari URL
$act = $_GET['act'];

if($act == 'insert'){
    // Ambil data dari form
    $kode_buku = $_POST['kode_buku'];
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit']; // Pastikan format YYYY
    $id_kategori = $_POST['id_kategori'];   // Ganti nama sesuai kolom database
    $stok = $_POST['stok'];

    // Query Insert
    $sql = "INSERT INTO buku 
            (kode_buku, judul, pengarang, penerbit, tahun_terbit, id_kategori, stok)
            VALUES 
            ('$kode_buku','$judul','$pengarang','$penerbit','$tahun_terbit','$id_kategori','$stok')";
    mysqli_query($koneksi, $sql);

    // Redirect ke halaman buku
    header("location:../../dashboard.php?page=buku");

} elseif($act == 'update'){
    $id = $_GET['id_buku'];

    // Ambil data dari form
    $kode_buku = $_POST['kode_buku'];
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit']; // Pastikan format YYYY
    $id_kategori = $_POST['id_kategori'];   // Ganti nama sesuai kolom database
    $stok = $_POST['stok'];

    // Query Update
    $sql = "UPDATE buku SET 
            kode_buku='$kode_buku',
            judul='$judul',
            pengarang='$pengarang',
            penerbit='$penerbit',
            tahun_terbit='$tahun_terbit',
            id_kategori='$id_kategori',
            stok='$stok'
            WHERE id_buku='$id_buku'";
    mysqli_query($koneksi, $sql);

    // Redirect ke halaman buku
    header("location:../../dashboard.php?page=buku");

} elseif($act == 'delete'){
    // Ambil id buku dari URL
    $id_buku = $_GET['id'];

    // Query Delete
    mysqli_query($koneksi, "DELETE FROM buku WHERE id_buku='$id_buku'");

    // Redirect ke halaman buku
    header("location:../../dashboard.php?page=buku");
}
?>
