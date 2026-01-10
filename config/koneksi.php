<?php 
$koneksi = mysqli_connect("localhost","root","","uas");
if(!$koneksi){
    mysqli_connect_errno();
    die;
}