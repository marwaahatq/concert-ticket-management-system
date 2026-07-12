<?php 
session_start();
require "koneksi.php";

if(!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}
?>