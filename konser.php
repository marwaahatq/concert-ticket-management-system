<?php
session_start();
require "koneksi.php";

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$currentPage = "Konser";

$cari = "";

if (isset($_GET['cari'])) {
    $cari = $_GET['cari'];
}

$querySQL = mysqli_query($konek, "SELECT * FROM concerts 
WHERE name LIKE '$cari' ||
 artist LIKE '$cari' ||
  venue LIKE '$cari'");

$queryCari = mysqli_fetch_assoc($querySQL);

if ($cari != '') {
    $queryCari .= "AND id = '$cari'";
}

$data = mysqli_fetch_assoc($querySQL);

$queryKonser = mysqli_query($konek, "SELECT id, name, venue, event_date, price_festival FROM concerts");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konser</title>
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

        .title h3 {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 30px;

            font-weight: bolder;
            color: #BE185D;
        }

        .title {
            color: darkgray;
            font-weight: bolder;
        }

        .search-section {
            position: relative;
            width: 60%;
            display: flex;

            margin-top: 30px;
            margin-bottom: 28px;

        }

        .search-input {
            flex: 1;
            border-radius: 20px;
            height: 40px;

            padding: 12px 100px 12px 20px;
            font-weight: bold;
            color: darkgray;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .search-button {
            position: absolute;

            top: 3px;
            right: 3px;
            bottom: 3px;
            padding: 6px 20px;

            background-color: #F472B6;
            border: none;
            border-radius: 20px;

            color: #FFFFFF;
            font-weight: bold;
        }

        .concer-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 18px;
            width: 90%;
            padding: 10px;
            text-decoration: none;
        }

        .concer-section a {
            text-decoration: none;
        }

        .card {
            padding: 10px;
            border-radius: 20px;
            height: 100%;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .card-title {
            font-weight: bold;
            text-decoration: none;
            margin-bottom: 30px;
        }

        .card-textplace {
            font-weight: bold;
            color: darkgray;
            font-size: 14px;
            margin-bottom: 0;
        }

        .card-textdate {
            font-weight: bold;
            margin-bottom: 24px;
        }

        .card-textprice {
            color: #BE185D;
            font-weight: bold;
            margin-bottom: 0;
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
                    <a href="home.php" class="<?= ($currentPage == 'Beranda') ? 'active-menu' : ''; ?>">Beranda</a>
                    <a href="konser.php" class="<?= ($currentPage == 'Konser') ? 'active-menu' : ''; ?>">Konser</a>
                    <a href="tiketKu.php" class="<?= ($currentPage == 'Tiket') ? 'active-menu' : ''; ?>">TiketKu</a>
                    <a href="riwayat.php" class="<?= ($currentPage == 'Riwayat') ? 'active-menu' : ''; ?>">Riwayat</a>
                    <a href="logout.php" class="<?= ($currentPage == 'Riwayat') ? 'active-menu' : ''; ?>">Logout</a>
                </div>

            </div>

            <div class="title">
                <h3>Semua Konser</h3>
                <p>Temukan konser favoritmu, pilih kategori, dan pesan tiket dengan mudah</p>
            </div>

            <form action="" method="GET" class="search-section">
                <input type="text" name="cari" class="search-input" placeholder="Cari nama konser, artis, vanue..."
                    value="<?= $cari ?>">
                <button type="submit" class="search-button">Cari</button>
            </form>

            <div class="concer-section">
                <?php while ($konser = mysqli_fetch_assoc($queryKonser)) { ?>
                    <?php $formatDate = date("d M Y • H:i", strtotime($konser['event_date'])); ?>
                    <a href="order.php?id=<?= $konser['id'] ?>">

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?= $konser['name'] ?></h5>
                                <p class="card-textplace"><?= $konser['venue'] ?></p>
                                <p class="card-textdate"><?= $formatDate ?></p>
                                <p class="card-textprice">Mulai Rp
                                    <?= number_format($konser['price_festival'], 0, ',', '.') ?></p>

                            </div>
                        </div>
                    <?php } ?>
                </a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>