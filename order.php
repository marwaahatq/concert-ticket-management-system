<?php
session_start();
require "koneksi.php";

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['id'];

if (!isset($_GET['id'])) {
    header("Location: order.php");
    exit;
}

$id = $_GET['id'];

$queryKonser = mysqli_query($konek, "SELECT id, name, artist, venue, event_date FROM concerts WHERE id = '$id'");

$queryHarga = mysqli_query($konek, "SELECT price_festival, stock_festival, price_tribune, stock_tribune, price_vip, stock_vip FROM concerts WHERE id = '$id'");

$query = mysqli_query($konek, "SELECT * FROM concerts WHERE id = '$id'");
$data = mysqli_fetch_assoc($query);

if (isset($_POST['submit'])) {
    $ticket_category = $_POST['ticket_category'];
    $quantity = $_POST['quantity'];

    if ($ticket_category == 'festival') {
        $harga = $data['price_festival'];
    } elseif ($ticket_category == 'tribune') {
        $harga = $data['price_tribune'];
    } else {
        $harga = $data['price_vip'];
    }

    $total = $harga * $quantity;
    

    $order_code = "ORD" . date("YmdHis");
    $insert = mysqli_query(
        $konek,
        "INSERT INTO orders (order_code, user_id, concert_id, ticket_category, quantity, unit_price, total_price)
        VALUES ('$order_code', '$user_id', '$id', '$ticket_category', '$quantity', '$harga', '$total')");

    if ($insert) {
        $_SESSION['success'] = "Tiker berhasil dibeli";
        header("Location: home.php");
        exit;
    } else {
        $_SESSION['error'] = "Gagal membeli tiket!";
        header("Location: order.php");
        exit;
    }
}
?>
<!DOCTYPE html> 
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=\, initial-scale=1.0">
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

        .container-order {
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

        .info-order {
            display: flex;
            margin: 30px;
            gap: 20px;
        }

        .info {
            border-radius: 20px;
            margin-bottom: 15px;
            width: 100%;
        }

        .card-event {
            border-radius: 20px;
            margin-bottom: 15px;
            border: 2px solid #DDD6FE;
            background-color: #FFFFFF;
            padding: 20px;
        }

        .card-titleEvent {
            font-weight: bolder;
            text-align: center;
        }

        .card-textArtist {
            text-align: center;
            margin-bottom: 30px;
        }

        .card-textVanue,
        .card-textDate {
            font-weight: bold;
            margin: 0;
        }

        .card-textDate {
            margin-bottom: 30px;
        }

        .card-price {
            border-radius: 20px;
            margin-bottom: 15px;
            border: 2px solid #FBCFE8;
            background-color: #FFFFFF;
            padding: 20px;
        }

        .card-titlePrice {
            margin-bottom: 15px;
        }

        .card-bodyPrice {
            display: flex;
            justify-content: space-between;
            padding: 10px;

        }

        .ticket-category p {
            font-weight: bolder;
            margin-bottom: 30px;
        }

        .price {
            font-weight: bolder;
            margin: 0;
            text-align: right;
        }

        .stok {
            color: darkgray;
            font-size: small;
            font-weight: bold;
            text-align: right;
            margin-bottom: 10px;
        }


        .dots {
            display: flex;
            justify-content: flex-start;
            gap: 10px;
            margin-bottom: 20px;
        }

        .dot {
            width: 14px;
            height: 14px;
            border-radius: 50%;
        }

        .purple {
            background-color: #A78BFA;
        }

        .pink {
            background-color: #F472B6;
        }

        .green {
            background-color: #6EE7B7;
        }

        .yellow {
            background-color: #FCD34D;
        }

        .blue {
            background-color: #93C5FD;
        }

        .form-container {
            background-color: #FFFFFF;
            border: 2px solid #FBCFE8;
            border-radius: 15px;
            width: 100%;
            max-width: 450px;
            padding: 30px;
        }

        .form-container h5 {
            font-weight: bolder;
            color: #BE185D;
            margin-bottom: 20px;
        }

        .form-label {
            color: #BE185D;
        }

        .form-control {
            background-color: #FDF2F8;
            border: 2px solid #FBCFE8;
            border-radius: 10px;

            width: 100%;
        }

        .info-beli {
            background: #C2185B;
            color: white;

            padding: 20px;
            border-radius: 15px;

            margin-top: 20px;
            margin-bottom: 20px;
        }

        .info-beli p {
            display: flex;
            justify-content: space-between;

            margin-bottom: 10px;
            font-weight: bold;
        }

        #showTotal {
            color: #FCD34D;
            font-size: 24px;
        }

        .button-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .btn-submit {
            background: #F472B6;
            border: 2px solid #BE185D;
            color: white;

            border-radius: 30px;
            padding: 10px;
            font-weight: bold;
        }

        .btn-cancel {
            text-decoration: none;
            text-align: center;

            border: 2px solid #F472B6;
            color: #BE185D;

            border-radius: 30px;
            padding: 10px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container-order">

        <div class="overlay">

            <div class="navbar-custom">
                <div class="logo">
                    Tiket<span class="logo-2">Ian</span>
                </div>

                <div class="menu">
                    <a href="home.php" class="<?= ($currentPage == 'Beranda') ? 'active-menu' : ''; ?>">Beranda</a>
                    <a href="konser.php" class="<?= ($currentPage == 'Konser') ? 'active-menu' : ''; ?>">Konser</a>
                    <a href="tiketKu.php" class="<?= ($currentPage == 'Tiket') ? 'active-menu' : ''; ?>">Tiket</a>
                    <a href="riwayat.php" class="<?= ($currentPage == 'Riwayat') ? 'active-menu' : ''; ?>">Riwayat</a>
                    <a href="logout.php" class="<?= ($currentPage == 'Riwayat') ? 'active-menu' : ''; ?>">Logout</a>
                </div>

            </div>

            <div class="info-order">
                <div class="info">
                    <?php while ($konser = mysqli_fetch_assoc($queryKonser)) { ?>
                        <?php $formatDate = date("d M Y • H:i", strtotime($konser['event_date'])); ?>
                        <div class="card-event">
                            <div class="card-bodyEvent">
                                <h5 class="card-titleEvent"><?= $konser['name'] ?></h5>
                                <p class="card-textArtist"><?= $konser['artist'] ?></p>
                                <p class="card-textVanue">Vanue: <?= $konser['venue'] ?></p>
                                <p class="card-textDate">Tanggal: <?= $formatDate ?></p>

                            </div>
                        </div>
                    <?php } ?>

                    <?php while ($harga = mysqli_fetch_assoc($queryHarga)) { ?>
                        <div class="card-price">
                            <p class="card-titlePrice"><b>Harga Tiket</b></p>
                            <div class="card-bodyPrice">

                                <div class="ticket-category">
                                    <p class="card-textFest">Festival</p>
                                    <p class="card-textTri">Tribune </p>
                                    <p class="card-textVip">VIP</p>
                                </div>

                                <div class="ticket-price">
                                    <p class="price">Rp <?= number_format($harga['price_festival'], 0, ',', '.') ?></p>
                                    <p class="stok">Stok: <?= $harga['stock_festival'] ?></p>

                                    <p class="price">Rp <?= number_format($harga['price_tribune'], 0, ',', '.') ?></p>
                                    <p class="stok">Stok: <?= $harga['stock_tribune'] ?></p>

                                    <p class="price">Rp <?= number_format($harga['price_vip'], 0, ',', '.') ?></p>
                                    <p class="stok">Stok: <?= $harga['stock_vip'] ?></p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <script>
                    const hargaFestival = <?= $data['price_festival'] ?>;
                    const hargaTribune = <?= $data['price_tribune'] ?>;
                    const hargaVip = <?= $data['price_vip'] ?>;
                </script>

                <div class="form-container">
                    <div class="dots">
                        <span class="dot purple"></span>
                        <span class="dot pink"></span>
                        <span class="dot green"></span>
                        <span class="dot yellow"></span>
                        <span class="dot blue"></span>
                        <span class="dot purple"></span>
                        <span class="dot pink"></span>
                    </div>
                    <h5>Pesan Tiket</h5>

                    <form action="" method="POST">
                        <div class="mb-4">
                            <label for="" class="form-label">Kategori Tiket</label>
                            <select name="ticket_category" id="ticket_category" class="form-control">
                                <option value="festival">Festival</option>
                                <option value="tribune">Tribune</option>
                                <option value="vip">VIP</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="" class="form-label">Jumlah Tiket</label>
                            <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
                        </div>

                        <div class="info-beli">
                            <p>Kategori : <span id="showKategori">Festival</span></p>
                            <p>Harga Satuan : <span id="showHarga">Rp 1.200.000</span></p>
                            <p>Jumlah : <span id="showJumlah">1 tiket</span></p>
                            <p>Total Bayar : <span id="showTotal">Rp 1.200.000</span></p>
                        </div>

                        <div class="button-group">
                            <button type="submit" name="submit" class="btn-submit">BELI TIKET</button>
                            <a href="konser.php" class="btn-cancel">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        const kategori = document.getElementById("ticket_category");
        const jumlah = document.getElementById("quantity");

        function updateHarga() {

            let harga = 0;

            if (kategori.value === "festival") {
                harga = hargaFestival;
            } else if (kategori.value === "tribune") {
                harga = hargaTribune;
            } else {
                harga = hargaVip;
            }

            let qty = jumlah.value || 0;
            let total = harga * qty;

            document.getElementById("showKategori").innerText =
                kategori.options[kategori.selectedIndex].text;

            document.getElementById("showHarga").innerText =
                "Rp " + harga.toLocaleString("id-ID");

            document.getElementById("showJumlah").innerText =
                qty + " tiket";

            document.getElementById("showTotal").innerText =
                "Rp " + total.toLocaleString("id-ID");
        }

        kategori.addEventListener("change", updateHarga);
        jumlah.addEventListener("input", updateHarga);

        updateHarga();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>