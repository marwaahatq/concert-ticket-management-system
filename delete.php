<?php 
session_start();
require "koneksi.php";

if(!isset($_GET['id'])) {
    header("location: riwayat.php");
    exit;
}

$id = $_GET['id'];

$cek = mysqli_query($konek, "SELECT * FROM orders WHERE id = '$id'");

$data = mysqli_fetch_assoc($cek);

if(!$data) {
    header("Location: riwayat.php");
    exit;
}

if($data['status'] == 'used') {
    header("Location: riwayat.php");
    exit;
}

mysqli_query($konek, "DELETE FROM orders WHERE id = '$id'");

//kembali ke halaman riwayat
header("Location: riwayat.php");
exit;
?>