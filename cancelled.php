<?php
session_start();
require "koneksi.php";

// cek apakah user udah login
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
}

if (isset($_GET['id'])) {
    $id = $_GET['id']; //id tiket yang mau dibatalin
    $user_id = $_SESSION['id']; //id user yang ngebatalin

    //pastikan tiket milik user yang sedang login
    $cek = mysqli_query($konek, "SELECT * FROM orders WHERE id = '$id' AND user_id = '$user_id'");

    if (mysqli_num_rows($cek) > 0) {
        mysqli_query($konek, "UPDATE orders SET status = 'cancelled' WHERE id = '$id'");
    }
}

header("Location: tiketKu.php");
exit;
?>