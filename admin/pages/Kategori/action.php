<?php
// Menginclude file koneksi database
include "../../../config/koneksi.php";
// Memulai session untuk bisa menggunakan $_SESSION (untuk notifikasi)
session_start();

// Mengecek apakah ada parameter 'act' di URL (insert, update, atau delete)
if (isset($_GET['act'])) {
    $act = $_GET['act']; // Menyimpan jenis aksi ke variabel $act

    // === LOGIKA INSERT (TAMBAH DATA) ===
    if ($act == "insert") {
        // Mengambil data dari form (POST)
        $nama_kategori = $_POST['nama_kategori'];

        // Query SQL untuk menyimpan data baru ke tabel categories
        // ID tidak perlu dimasukkan karena AUTO_INCREMENT
        $query = "INSERT INTO kategori (nama_kategori) VALUES ('$nama_kategori')";
        $execute = mysqli_query($koneksi, $query); // Eksekusi query

        // Pengecekan apakah query berhasil
        if ($execute) {
            // Jika berhasil, set pesan notifikasi Sukses
            $_SESSION['message'] = 'Data Berhasil Disimpan';
            $_SESSION['alert_type'] = 'alert-success';
            $_SESSION['type'] = 'Success';
            mysqli_close($koneksi); // Menutup koneksi database
            // Redirect kembali ke halaman list kategori
            header('location:../../dashboard.php?page=kategori');
            exit;
        } else {
            // Jika gagal, set pesan notifikasi Gagal
            $_SESSION['message'] = 'Data Gagal Disimpan';
            $_SESSION['alert_type'] = 'alert-danger';
            $_SESSION['type'] = 'Failed';
            mysqli_close($koneksi);
            header('location:../../dashboard.php?page=kategori');
            exit;
        }

    // === LOGIKA UPDATE (EDIT DATA) ===
    } elseif ($act == "update") {
        // Mengambil category_id dari URL (GET) karena dikirim lewat action form URL
        $id_kategori = $_GET['id_kategori'];
        // Mengambil data nama kategori yang baru dari form (POST)
        $nama_kategori = $_POST['nama_kategori'];

        // Query SQL untuk mengupdate data berdasarkan category_id
        $sql = "UPDATE kategori SET nama_kategori='$nama_kategori' WHERE id_kategori='$id_kategori'";
        $execute = mysqli_query($koneksi, $sql);

        if ($execute) {
            $_SESSION['message'] = 'Data Berhasil Di Update';
            $_SESSION['alert_type'] = 'alert-success';
            $_SESSION['type'] = 'Success';
            mysqli_close($koneksi);
            header('location:../../dashboard.php?page=kategori');
            exit;
        } else {
            $_SESSION['message'] = 'Data Gagal Di Update';
            $_SESSION['alert_type'] = 'alert-danger';
            $_SESSION['type'] = 'Failed';
            mysqli_close($koneksi);
            header('location:../../dashboard.php?page=kategori');
            exit;
        }

    // === LOGIKA DELETE (HAPUS DATA) ===
    } elseif ($act == "delete") {
        // Mengambil category_id yang akan dihapus dari parameter URL
        $id_kategori = $_GET['id_kategori'];
        
        // Query SQL untuk menghapus data
        $sql = "DELETE FROM kategori WHERE id_kategori='$id_kategori'";
        $execute = mysqli_query($koneksi, $sql);

        if ($execute) {
            $_SESSION['message'] = 'Data Berhasil Di Hapus';
            $_SESSION['alert_type'] = 'alert-success';
            $_SESSION['type'] = 'Success';
            mysqli_close($koneksi);
            header('location:../../dashboard.php?page=kategori');
            exit;
        } else {
            $_SESSION['message'] = 'Data Gagal Di Hapus';
            $_SESSION['alert_type'] = 'alert-danger';
            $_SESSION['type'] = 'Failed';
            mysqli_close($koneksi);
            header('location:../../dashboard.php?page=kategori');
            exit;
        }
    }
}
