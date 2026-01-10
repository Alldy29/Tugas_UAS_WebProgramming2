<?php
include "../../../config/koneksi.php";

$act = $_GET['act'];

if($act == 'insert'){
    $kode_buku = $_POST['kode_buku'];
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $kategori_id = $_POST['kategori_id'];
    $stok = $_POST['stok'];

    $sql = "INSERT INTO buku (kode_buku, judul, pengarang, penerbit, tahun_terbit, kategori_id, stok)
            VALUES ('$kode_buku','$judul','$pengarang','$penerbit','$tahun_terbit','$kategori_id','$stok')";
    mysqli_query($koneksi, $sql);
    header("location:../../dashboard.php?page=buku");

} elseif($act == 'update'){
    $id = $_GET['id'];
    $kode_buku = $_POST['kode_buku'];
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $kategori_id = $_POST['kategori_id'];
    $stok = $_POST['stok'];

    $sql = "UPDATE buku SET 
            kode_buku='$kode_buku',
            judul='$judul',
            pengarang='$pengarang',
            penerbit='$penerbit',
            tahun_terbit='$tahun_terbit',
            kategori_id='$kategori_id',
            stok='$stok'
            WHERE id='$id'";
    mysqli_query($koneksi, $sql);
    header("location:../../dashboard.php?page=buku");

} elseif($act == 'delete'){
    $id = $_GET['id'];
    mysqli_query($koneksi, "DELETE FROM buku WHERE id='$id'");
    header("location:../../dashboard.php?page=buku");
}
