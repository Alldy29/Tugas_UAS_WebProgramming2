<?php
// Includes koneksi ke database dan memulai session
include "../../../config/koneksi.php";
session_start();

// Fungsi kustom untuk membuat Kode Anggota Otomatis
// Logic: Mengambil kode terakhir (misal CS005), mengambil angkanya (5), tambah 1 (6), format ulang (CS006)
function generate_anggota_code($koneksi) {
    // Query mengambil 1 data terakhir berdasarkan id_anggota terbesar
    $query = "SELECT kode_anggota FROM anggota ORDER BY id_anggota DESC LIMIT 1";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_array($result);

    if ($data) {
        $last_code = $data['kode_anggota']; // Misal: CS001
        // Ambil angka dari string 'CS001' mulai index ke-2
        $number = (int) substr($last_code, 2);
        $number++; // Tambah 1
    } else {
        $number = 1; // Jika belum ada data sama sekali
    }

    // Format kode baru: "CS" + angka 3 digit
    $new_code = "AP" . sprintf("%03d", $number);
    return $new_code;
}

// Cek parameter act di URL
if (isset($_GET['act'])) {
    $act = $_GET['act'];
    
    // === INSERT DATA ANGGOTA ===
    if ($act == "insert") {
        // Ambil data dari input form
        $nama = $_POST['nama'];                       // name="nama" di form
        $jenis_kelamin = $_POST['jenis_kelamin'];     // name="jenis_kelamin" di form
        $alamat = $_POST['alamat'];                   // name="alamat"
        $no_hp = $_POST['no_hp'];                     // name="no_hp"
        
        // Panggil fungsi generate kode otomatis
        $kode_anggota = generate_anggota_code($koneksi);

        // Query Insert
        $query = "INSERT INTO anggota (kode_anggota, nama_anggota, jenis_kelamin, alamat, no_hp) 
                  VALUES ('$kode_anggota', '$nama', '$jenis_kelamin', '$alamat', '$no_hp')";
        $execute = mysqli_query($koneksi, $query);

        // Cek keberhasilan insert
        if ($execute) {
            $_SESSION['message'] = 'Data Berhasil Disimpan';
            $_SESSION['alert_type'] = 'alert-success';
            $_SESSION['type'] = 'Success';
            mysqli_close($koneksi);
            header('location:../../dashboard.php?page=anggota');
            exit;
        } else {
            $_SESSION['message'] = 'Data Gagal Disimpan: ' . mysqli_error($koneksi);
            $_SESSION['alert_type'] = 'alert-danger';
            $_SESSION['type'] = 'Failed';
            mysqli_close($koneksi);
            header('location:../../dashboard.php?page=anggota');
            exit;
        }

    // === UPDATE DATA ANGGOTA ===
    } elseif ($act == "update") {
        $id_anggota = $_GET['id_anggota']; // ID yang diedit ambil dari URL
        $nama_anggota = $_POST['nama_anggota'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $alamat = $_POST['alamat'];
        $no_hp = $_POST['no_hp'];

        // Query Update
        $sql = "UPDATE anggota SET 
                    nama_anggota='$nama_anggota', 
                    jenis_kelamin='$jenis_kelamin', 
                    alamat='$alamat', 
                    no_hp='$no_hp' 
                WHERE id_anggota='$id_anggota'";
        $execute = mysqli_query($koneksi, $sql);

        if ($execute) {
            $_SESSION['message'] = 'Data Berhasil Di Update';
            $_SESSION['alert_type'] = 'alert-success';
            $_SESSION['type'] = 'Success';
            mysqli_close($koneksi);
            header('location:../../dashboard.php?page=anggota');
            exit;
        } else {
            $_SESSION['message'] = 'Data Gagal Di Update: ' . mysqli_error($koneksi);
            $_SESSION['alert_type'] = 'alert-danger';
            $_SESSION['type'] = 'Failed';
            mysqli_close($koneksi);
            header('location:../../dashboard.php?page=anggota');
            exit;
        }

    // === DELETE DATA ANGGOTA ===
    } elseif ($act == "delete") {
        $id_anggota = $_GET['id_anggota'];
        
        // Query Delete
        $sql = "DELETE FROM anggota WHERE id_anggota='$id_anggota'";
        $execute = mysqli_query($koneksi, $sql);

        if ($execute) {
            $_SESSION['message'] = 'Data Berhasil Di Hapus';
            $_SESSION['alert_type'] = 'alert-success';
            $_SESSION['type'] = 'Success';
            mysqli_close($koneksi);
            header('location:../../dashboard.php?page=anggota');
            exit;
        } else {
            $_SESSION['message'] = 'Data Gagal Di Hapus: ' . mysqli_error($koneksi);
            $_SESSION['alert_type'] = 'alert-danger';
            $_SESSION['type'] = 'Failed';
            mysqli_close($koneksi);
            header('location:../../dashboard.php?page=anggota');
            exit;
        }
    }
}
?>
