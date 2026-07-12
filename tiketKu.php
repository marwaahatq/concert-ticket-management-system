<?php
session_start();
require "koneksi.php";

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$currentPage = "Tiket";

$user_id = $_SESSION['id'];

$query = mysqli_query($konek, "SELECT orders.*, concerts.name, concerts.venue, concerts.event_date 
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
    <title>tiketKu</title>
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

        .container-tiketKu {
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

        .tiketKu-section {
            width: 90%;
        }

        .tiketKu-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 25px;
            margin-bottom: 20px;

            background-color: var(--white);
            box-shadow: 0 5px 15px rgba(0, 0, 0, .08);
            border: 2px solid var(--purple-m);
            border-radius: 18px;
        }

        .tiketKu-card.cancelled {
            opacity: 0.45;
            background-color: #f5f5f5;
            border: 2px solid #bdbdbd;
        }

        .tiketKu-card.cancelled .btn-cancel {
            padding: 8px 20px;
            border-radius: 20px;
            pointer-events: none;
            background: #ccc;
            border-color: #999;
            color: #666;

        }

        .tiketKu-card.cancelled h4,
        .tiketKu-card.cancelled p {
            color: #888;
        }

        .left h4 {
            color: #31204f;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .left p {
            color: darkgray;
            margin: 3px 0;
        }

        .right {
            text-align: right;
        }

        .right h4 {
            color: #BE185D;
            font-weight: bolder;
            margin-bottom: 15px;
        }

        .btn-cancel {
            padding: 8px 20px;
            display: inline-block;
            text-decoration: none;
            border: 2px solid #ff4c4c;
            border-radius: 20px;
            background-color: #ffe1e1;
            font-weight: bold;
            color: darkred;
        }

        .btn-cancel:hover {
            background: #ff4c4c;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container-tiketKu">
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
                <h3>Tiket Saya</h3>
                <p>Tunjukan kode tiketmu di pintu masuk area konser.</p>
            </div>

            <div class="tiketKu-section">
                <?php while ($data = mysqli_fetch_assoc($query)) { ?>
                    <div class="tiketKu-card <?= ($data['status'] == 'cancelled') ? 'cancelled' : '' ?>">
                        <div class="left">
                            <h4><?= $data['name'] ?></h4>
                            <p><?= $data['venue'] ?></p>
                            <p><?= date("d M Y • H:i", strtotime($data['event_date'])) ?></p>
                            <p>
                                <?= $data['quantity'] ?> tiket • Dibeli
                                <?= date("d M Y", strtotime($data['created_at'])) ?>
                            </p>
                            <p><?= $data['order_code'] ?></p>
                        </div>

                        <div class="right">
                            <h4>Rp <?= number_format($data['total_price'], 0, ",", ".") ?></h4>

                            <?php if ($data['status'] == 'active') { ?>
                                <a href="cancelled.php?id=<?= $data['id'] ?>" class="btn-cancel">
                                    Batalkan
                                </a>
                            <?php } elseif ($data['status'] == 'cancelled') { ?>
                                <span class="badge bg-secondary">Dibatalkan</span>
                            <?php } else { ?>
                                <span class="badge bg-success">Used</span>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>