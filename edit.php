<?php
session_start();
require "koneksi.php";

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

//cek konser yang dipilih
if (!isset($_GET['id'])) {
    header("Location: riwayat.php");
    exit;
}

$id = $_GET['id'];
$user_id = $_SESSION['id'];

// proses update
if (isset($_POST['submit'])) {

    $id = $_POST['id'];
    $quantity = $_POST['quantity'];
    $status = $_POST['status'];

    // ambil harga satuan
    $q = mysqli_query($konek, "SELECT unit_price FROM orders WHERE id='$id' AND user_id='$user_id'");

    $order = mysqli_fetch_assoc($q);
    $total = $quantity * $order['unit_price'];

    mysqli_query($konek, "UPDATE orders SET quantity='$quantity', status='$status', total_price='$total'
                          WHERE id='$id' AND user_id='$user_id'");

    header("Location: riwayat.php");
    exit;
}

// ambil data konser yang dipilih
$query = mysqli_query($konek, "SELECT orders.*, concerts.name, concerts.venue
FROM orders JOIN concerts
ON orders.concert_id = concerts.id
WHERE orders.id = '$id'
AND orders.user_id = '$user_id'");

$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --pink: #F472B6;
            --pink-l: #FDF2F8;
            --pink-m: #FBCFE8;
            --pink-d: #BE185D;
            --purple: #A78BFA;
            --purple-l: #F5F3FF;
            --purple-m: #DDD6FE;
            --purple-d: #6D28D9;
            --yellow: #FCD34D;
            --green: #6EE7B7;
            --blue: #93C5FD;
            --white: #FFFFFF;
            --dark: #3B1F3A;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--white);
            font-family: 'Nunito', sans-serif;
        }

        .container-edit {
            background-image: url(img/bg_concert.jpg);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .overlay {
            background-color: rgba(255, 235, 252, 0.8);

            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .navbar-custom {
            width: 100%;
            padding: 10px 30px;
            position: sticky;
            top: 0;
            z-index: 9999;

            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            background-color: #FFFFFF;
        }

        .logo {
            padding-left: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            font-weight: 900;
            font-size: x-large;
            color: var(--pink-d);
        }

        .logo-2 {
            color: #A78BFA;
        }

        .menu {
            padding-right: 10px;
            font-weight: bold;
        }

        .menu a {
            text-decoration: none;
            color: #3B1F3A;
            padding: 8px 16px;
            transition: 0.3s;
        }

        .menu a.active-menu {
            color: #FFFFFF;
            background-color: #F472B6;
            padding: 8px 16px;
            border-radius: 30px;
            text-decoration: none;
            border: 2px solid #BE185D;
        }

        .menu a:hover {
            color: #BE185D;
            transition: 0.3s;
        }

        .title h3 {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 30px;
            color: #BE185D;
            font-weight: bolder;
        }

        .title p {
            color: darkgray;
            font-weight: bolder;
        }

        .card {
            border-radius: 20px;
            border: 2px solid #FBCFE8;
            width: 480px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, .08);
            margin-bottom: 30px;
            overflow: hidden
        }

        .card-header {
            background: #f9e3ef;
            border-bottom: 2px dashed #FBCFE8;
            text-align: center;
            padding: 20px;
            border-radius: 20px;
        }

        .satu {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
            font-size: 11px;
            font-weight: 700;
            color: darkgray;
        }

        .kode-order {
            display: inline-block;
            background-color: white;
            border: 2px solid #FBCFE8;
            border-radius: 8px;
            color: #BE185D;
            font-family: Courier;
            font-weight: bold;
            padding: 6px 14px;
        }

        .dua {
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-top: 10px;
            font-size: 15px;
        }

        .badge {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: white;
        }

        .card-body {
            text-align: center;
            padding: 25px;
        }

        .edit-jumlah {
            font-weight: bold;
            padding-bottom: 8px;
        }

        .edit-control {
            width: 100%;
            height: 45px;
            border: none;
            border-radius: 10px;
            padding: 10px;
            outline: none;
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .edit-control:focus {
            border-color: #BE185D;
        }

        .jumlah-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            height: 50px;
            border: none;
            background-color: #e0e0e0;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .jumlah-box button {
            width: 40px;
            height: 80%;
            border: none;
            border-radius: 80px;
            background: white;
            box-shadow: 0 8px 20px rgba(0, 0, 0, .08);
            color: #BE185D;
            font-size: 26px;
            font-weight: bold;
            cursor: pointer;
            transition: .3s;
        }

        .jumlah-box button:hover {
            background: #BE185D;
            color: white;
            transition: 0.3s;
        }

        .jumlah-box input {
            flex: 1;
            border: none;
            outline: none;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            background: #e0e0e0;
        }

        .edit-status {
            font-weight: bold;
            padding-bottom: 8px;
            padding-top: 8px;
        }

        .button-status {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
        }

        .button-status button {
            flex: 1;
            height: 45px;
            border: none;
            border-radius: 10px;
            background: #F3F4F6;
            color: #6B7280;
            font-weight: bold;
            transition: .3s;
            border-radius: 12px;
            cursor: pointer;
        }

        .active-btn {
            background: #DCFCE7 !important;
            color: #15803D !important;
        }

        .cancel-btn {
            background: #FEE2E2 !important;
            color: #DC2626 !important;
        }

        .estimasi {
            text-align: center;
        }

        .estimasi p {
            font-weight: bold;
            color: darkgray;
            padding-top: 16px;
            margin-bottom: 5px;
            color: #9CA3AF;
            font-size: 14px;
        }

        .estimasi h4 {
            font-weight: bold;
            color: #BE185D;
            ;
            font-size: 28px;
            font-weight: 800;
        }

        .btn-submit {
            display: block;
            margin: 0 auto;
            width: 100%;
            height: 45px;
            color: white;
            background-color: #BE185D;
            border-radius: 10px;
            border: none;
            font-weight: bold;
            font-size: 15px;
        }

        .btn-submit:hover {
            background-color: #F472B6;
            border-radius: 10px;
            border: none;
            transition: 0.3s;
        }

        .btn-cancel {
            display: block;
            width: 100%;
            height: 40px;
            margin-top: 10px;
            padding-top: 7px;
            text-align: center;
            text-decoration: none;
            border: 2px solid white;
            color: darkgray;
            font-weight: bold;
        }

        .btn-cancel:hover {
            background-color: #FBCFE8;
            border-radius: 10px;
            border: 2px solid #FBCFE8;
            transition: 0.3s;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container-edit">

        <div class="overlay">

            <div class="navbar-custom">
                <div class="logo">
                    Tiket<span class="logo-2">Ian</span>
                </div>

                <div class="menu">
                    <a href="home.php" class="<?= ($currentPage == 'home') ? 'active-menu' : ''; ?>">Beranda</a>
                    <a href="konser.php" class="<?= ($currentPage == 'Konser') ? 'active-menu' : ''; ?>">Konser</a>
                    <a href="tiketKu.php" class="<?= ($currentPage == 'Tiket') ? 'active-menu' : ''; ?>">TiketKu</a>
                    <a href="riwayat.php" class="<?= ($currentPage == 'Riwayat') ? 'active-menu' : ''; ?>">Riwayat</a>
                    <a href="logout.php" class="<?= ($currentPage == 'Riwayat') ? 'active-menu' : ''; ?>">Logout</a>
                </div>
            </div>

            <div class="title">
                <h3>Edit Pesanan</h3>
                <p>Konser: <?= $data['name'] ?></p>
            </div>

            <div class="card">
                <div class="card-header">
                    <p class="satu">KODE ORDER</p>
                    <span class="kode-order"><?= $data['order_code'] ?></span></h3>
                    <p class="dua"><?= $data['venue'] ?></p>
                </div>


                <div class="card-body">
                    <form action="" method="POST">
                        <div class="row">
                            <label for="" class="edit-jumlah">Jumlah Tiket</label>
                            <div class="jumlah-box">
                                <button type="button" id="minus">-</button>
                                <input type="text" id="quantity" name="quantity" value="<?= $data['quantity'] ?>"
                                    readonly>
                                <button type="button" id="plus">+</button>
                            </div>

                            <label for="" class="edit-status">Status</label>
                            <div class="button-status">
                                <button type="button" id="btnAktif"
                                    class="<?= $data['status'] == 'active' ? 'active-btn' : '' ?>">Aktif</button>
                                <button type="button" id="btnBatal"
                                    class="<?= $data['status'] == 'cancelled' ? 'cancel-btn' : '' ?>">Batal</button>
                            </div>

                            <input type="hidden" id="status" name="status" value="<?= $data['status'] ?>">
                        </div>

                        <div class="estimasi">
                            <p>ESTIMASI TOTAL</p>
                            <h4 id="totalHarga"></h4>
                        </div>

                        <div class="row">
                            <button type="submit" name="submit" class="btn-submit">SIMPAN</button>
                            <a href="riwayat.php" class="btn-cancel">Batal</a>
                        </div>

                        <input type="hidden" name="id" value="<?= $data['id'] ?>">

                    </form>

                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
        </script>

    <script>
        const harga = <?= $data['unit_price'] ?>;

        const quantity = document.getElementById("quantity");
        const totalHarga = document.getElementById("totalHarga");

        const plus = document.getElementById("plus");
        const minus = document.getElementById("minus");

        function hitungTotal() {

            let jumlah = parseInt(quantity.value);

            let total = jumlah * harga;

            totalHarga.innerHTML =
                "Rp " + total.toLocaleString('id-ID');
        }

        hitungTotal();

        plus.addEventListener("click", function () {

            quantity.value++;

            hitungTotal();

        });

        minus.addEventListener("click", function () {

            if (quantity.value > 1) {

                quantity.value--;

                hitungTotal();

            }

        });

        const btnAktif = document.getElementById("btnAktif");
        const btnBatal = document.getElementById("btnBatal");
        const status = document.getElementById("status");

        btnAktif.addEventListener("click", function () {

            status.value = "active";

            btnAktif.classList.add("active-btn");

            btnBatal.classList.remove("cancel-btn");

        });

        btnBatal.addEventListener("click", function () {

            status.value = "cancelled";

            btnBatal.classList.add("cancel-btn");

            btnAktif.classList.remove("active-btn");

        });
    </script>

</body>