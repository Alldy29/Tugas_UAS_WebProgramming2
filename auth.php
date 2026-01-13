<?php 
session_start();
include "config/koneksi.php";
$email = $_POST['email'];
$password = $_POST['password'];

//Buat Query Untuk Mencari Data User Berdasarkan Email dan Password
$sql = "SELECT * FROM users WHERE email ='$email' AND password ='$password'";
//Eksesuki Query
$query = mysqli_query($koneksi, $sql);
//Cek Data User 
$cekuser = mysqli_num_rows($query);



if($cekuser==0){
    $_SESSION['message'] = 'Username atau Password Salah';
    mysqli_close($koneksi);
    header('location:index.php');
}else{
    $datauser = mysqli_fetch_array($query);
    $_SESSION['login'] = true;
    $_SESSION['nama'] = $datauser['nama'];
    $_SESSION['email'] = $datauser['email'];
    // $_SESSION['role'] = $datauser['role'];
    mysqli_close($koneksi);

    header('location:admin/dashboard.php');
}

