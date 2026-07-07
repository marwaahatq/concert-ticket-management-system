<?php
session_start();
require "koneksi.php";

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}
if (isset($_SESSION['id'])) {
    $username = $_SESSION['username'];
}
$currentPage = "home";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
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

        .container-home {
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

        .home-section {
            position: relative;
            width: 100%;
        }

        .home-section img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .home-content {
            position: absolute;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);

            text-align: center;

            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);

            padding: 30px;
            border-radius: 25px;

            width: 90%;
            max-width: 700px;
        }

        .home-content h3 {
            color: #BE185D;
            font-size: 48px;
            font-weight: 900;
        }

        .home-content p {
            color: darkgray;
            font-weight: bold;
            margin-top: 10px;
        }

        .btn-group {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .btn-home {
            text-decoration: none;
            background-color: white;
            color: #3B1F3A;
            padding: 10px 25px;
            border-radius: 15px;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-home:hover {
            background-color: #F472B6;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container-home">

        <div class="overlay">

            <div class="navbar-custom">
                <div class="logo">
                    Tiket<span class="logo-2">Ian</span>
                </div>

                <div class="menu">
                    <a href="home.php" class="<?= ($currentPage == 'home') ? 'active-menu' : ''; ?>">Beranda</a>
                    <a href="konser.php" class="<?= ($currentPage == 'Konser') ? 'active-menu' : ''; ?>">Konser</a>
                    <a href="tiket.php" class="<?= ($currentPage == 'Tiket') ? 'active-menu' : ''; ?>">Tiket</a>
                    <a href="riwayat.php" class="<?= ($currentPage == 'Riwayat') ? 'active-menu' : ''; ?>">Riwayat</a>
                    <a href="logout.php" class="<?= ($currentPage == 'Riwayat') ? 'active-menu' : ''; ?>">Logout</a>
                </div>

            </div>

            <div class="home-section">
                <img src="img/cr1.png" alt="banner">
            </div>

            <div class="home-content">
                <h3>
                    Halo, <?= ($username) ?>!
                </h3>
                <p>Temukan konser favoritmu dan pesan tiket dengan mudah.
                    <br>Jangan sampai kehabisan!
                </p>

                <div class="btn-group">
                    <a href="tiket.php" class="btn-home">TiketKu</a>
                    <a href="konser.php" class="btn-home">Konser</a>
                    <a href="riwayat.php" class="btn-home">Riwayat</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>