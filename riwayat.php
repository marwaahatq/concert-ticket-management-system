<?php
session_start();
require "koneksi.php";

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$currentPage = "Riwayat";

$user_id = $_SESSION['id'];

$query = mysqli_query($konek, "SELECT orders.*, concerts.name
FROM orders JOIN concerts 
ON orders.concert_id = concerts.id
WHERE orders.user_id = '$user_id'
ORDER BY orders.id DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order</title>
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

        .container-riwayat {
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
            align-items: center;
            justify-content: center;
            margin-top: 30px;
            font-weight: bolder;
            color: #BE185D;
        }

        .title p {
            color: darkgray;
            font-weight: bolder;
        }

        .riwayat-section {
            width: 90%;
        }

        .table-box {
            width: 90%;
            margin-top: 30px;
            background: #FFFFFF;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, .08);
        }

        .table thead th {
            background: #FBCFE8;
            color: #BE185D;
            font-size: 13px;
            font-weight: 800;
            padding: 18px;
        }

        .table tbody td {
            padding: 18px;
            border-top: 1px solid #eee;
            color: #555;
        }

        .table tbody tr:hover {
            background: #FFF8FC;
        }

        .btn-edit {
            background: #FFF4C9;
            color: #C58A00;
            padding: 8px 20px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
            margin-right: 5px;
        }

        .btn-delete {
            background: #FFE2E2;
            color: #D62828;
            padding: 8px 20px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
        }

        .btn-edit:hover {
            background: #FFE9A8;
        }

        .btn-delete:hover {
            background: #FFBDBD;
        }
    </style>
</head>

<body>
    <div class="container-riwayat">
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
                    <a href="logout.php" class="<?= ($currentPage == 'Logout') ? 'active-menu' : ''; ?>">Logout</a>
                </div>

            </div>

            <div class="title">
                <h3>Riwayat Aktivitas</h3>
                <p>Pantau semua riwayat transaksi dan penggunaan tiketmu di sini.</p>
            </div>

            <div class="table-box">
                <table class="table table-borderless align-middle mb-0">
                    <thead>
                        <tr>
                            <th>KODE</th>
                            <th>KONSER</th>
                            <th>QTY</th>
                            <th>TOTAL BAYAR</th>
                            <th>STATUS</th>
                            <th>WAKTU AKTIVITAS</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while ($data = mysqli_fetch_assoc($query)) { ?>
                            <tr>
                                <td><?= $data['order_code'] ?></td>
                                <td><?= $data['name'] ?></td>
                                <td><?= $data['quantity'] ?></td>
                                <td><?= number_format($data['total_price'], 0, ",", ".") ?></td>
                                <td>
                                    <?php
                                    if ($data['status'] == 'active') {
                                        echo "Dibeli";
                                    } elseif ($data['status'] == 'used') {
                                        echo "Digunakan";
                                    } else {
                                        echo "Dibatalkan";
                                    }
                                    ?>
                                </td>
                                <td><?= date("d M Y, H:i", strtotime($data['created_at'])) ?></td>
                                <td>
                                    <a href="edit.php" class="btn-edit">Edit</a>
                                    <a href="delete.php" class="btn-delete">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>