<?php
// Includes koneksi ke database dan memulai session
include "../../../config/koneksi.php";
session_start();

// Fungsi kustom untuk membuat Kode Customer Otomatis
// Logic: Mengambil kode terakhir (misal CS005), mengambil angkanya (5), ditambah 1 (6), format ulang (CS006)
function generate_customer_code($koneksi) {
    // Query mengambil 1 data terakhir berdasarkan customer_id terbesar
    $query = "SELECT customer_code FROM customers ORDER BY customer_id DESC LIMIT 1";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_array($result);

    if ($data) {
        $last_code = $data['customer_code']; // Misal: CS001
        // Ambil angka dari string 'CS001' mulai index ke-2
        // substr("CS001", 2) menghasilkan "001"
        // (int) mengubah string "001" menjadi angka 1
        $number = (int) substr($last_code, 2);
        $number++; // Tambah 1
    } else {
        // Jika belum ada data sama sekali, mulai dari 1
        $number = 1;
    }

    // Format kode baru: "CS" + angka yang dipadding dengan 0 (3 digit)
    // sprintf("%03s", 1) menjadi "001"
    $new_code = "CS" . sprintf("%03s", $number);
    return $new_code; // Mengembalikan kode baru
}

// Cek parameter act di URL
if (isset($_GET['act'])) {
    $act = $_GET['act'];
    
    // === INSERT DATA CUSTOMER ===
    if ($act == "insert") {
        // Ambil data dari input form
        $name = $_POST['name'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        
        // Panggil fungsi generate code otomatis
        $customer_code = generate_customer_code($koneksi);

        // Query Insert
        // Menyimpan: customer_code (otomatis), name, address, phone, created_at (waktu sekarang/NOW())
        $query = "INSERT INTO customers (customer_code, name, address, phone, created_at) 
                  VALUES ('$customer_code', '$name', '$address', '$phone', NOW())";
        $execute = mysqli_query($koneksi, $query);

        // Cek keberhasilan insert
        if ($execute) {
            $_SESSION['message'] = 'Data Berhasil Disimpan';
            $_SESSION['alert_type'] = 'alert-success';
            $_SESSION['type'] = 'Success';
            mysqli_close($koneksi);
            header('location:../../dashboard.php?page=customers');
            exit;
        } else {
            // Tampilkan error database jika gagal
            $_SESSION['message'] = 'Data Gagal Disimpan: ' . mysqli_error($koneksi);
            $_SESSION['alert_type'] = 'alert-danger';
            $_SESSION['type'] = 'Failed';
            mysqli_close($koneksi);
            header('location:../../dashboard.php?page=customers');
            exit;
        }

    // === UPDATE DATA CUSTOMER ===
    } elseif ($act == "update") {
        $customer_id = $_GET['customer_id']; // ID yang diedit ambil dari URL
        $name = $_POST['name'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];

        // Query Update
        $sql = "UPDATE customers SET name='$name', address='$address', phone='$phone' WHERE customer_id='$customer_id'";
        $execute = mysqli_query($koneksi, $sql);

        if ($execute) {
            $_SESSION['message'] = 'Data Berhasil Di Update';
            $_SESSION['alert_type'] = 'alert-success';
            $_SESSION['type'] = 'Success';
            mysqli_close($koneksi);
            header('location:../../dashboard.php?page=customers');
            exit;
        } else {
            $_SESSION['message'] = 'Data Gagal Di Update: ' . mysqli_error($koneksi);
            $_SESSION['alert_type'] = 'alert-danger';
            $_SESSION['type'] = 'Failed';
            mysqli_close($koneksi);
            header('location:../../dashboard.php?page=customers');
            exit;
        }

    // === DELETE DATA CUSTOMER ===
    } elseif ($act == "delete") {
        $customer_id = $_GET['customer_id'];
        
        // Query Delete
        $sql = "DELETE FROM customers WHERE customer_id='$customer_id'";
        $execute = mysqli_query($koneksi, $sql);

        if ($execute) {
            $_SESSION['message'] = 'Data Berhasil Di Hapus';
            $_SESSION['alert_type'] = 'alert-success';
            $_SESSION['type'] = 'Success';
            mysqli_close($koneksi);
            header('location:../../dashboard.php?page=customers');
            exit;
        } else {
            $_SESSION['message'] = 'Data Gagal Di Hapus: ' . mysqli_error($koneksi);
            $_SESSION['alert_type'] = 'alert-danger';
            $_SESSION['type'] = 'Failed';
            mysqli_close($koneksi);
            header('location:../../dashboard.php?page=customers');
            exit;
        }
    }
}
