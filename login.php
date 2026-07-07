<?php
session_start();
require "koneksi.php";

$currentPage = "login";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($konek, "SELECT * FROM users WHERE username = '$username'");
    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);

        if (password_verify($password, $data['password'])) {
            $_SESSION['id'] = $data['id'];
            $_SESSION['username'] = $data['username'];
            header("Location: home.php");
            exit;
        } else {
            $_SESSION['error'] = "Password salah!";
            header("Location: login.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "Username tidak ditemukan!";
        header("Location: login.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

        .container-login {
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
            padding-top: 10px;
            padding-bottom: 10px;
            position: sticky;
            top: 0;

            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #FFFFFF;
        }

        .logo {
            padding-left: 100px;
            font-weight: 900;
            font-size: x-large;
            color: var(--pink-d);
        }

        .logo-2 {
            color: #A78BFA;
        }

        .menu {
            padding-right: 100px;
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

        .form-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;

            background-color: #FFFFFF;
            padding: 30px;
            border-radius: 25px;
            border: 2px solid #FBCFE8;

            width: 100%;
            max-width: 450px;
            margin-bottom: 20px;

            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .img-logo {
            width: 20%;
            max-width: 120px;

            display: block;
            margin: 0 auto;
        }

        .login-title h1 {
            padding-top: 10px;
            text-align: center;
            color: #BE185D;
            font-size: 32px;
            font-weight: 900;
        }

        .login-title p {
            color: darkgray;
            font-weight: bold;
        }

        .dots {
            display: flex;
            justify-content: flex-start;
            gap: 10px;
            margin-bottom: 20px;
        }

        .dot {
            width: 10px;
            height: 10px;
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

        .form-container h3 {
            color: #BE185D;
            font-weight: bold;
        }

        .form-container p {
            color: darkgray;
            font-weight: bold;
        }

        .label {
            color: #BE185D;
            font-weight: bold;
        }

        .form-control {
            background-color: #FDF2F8;
            border-radius: 12px;
            border: 2px solid #FBCFE8;
            margin-bottom: 15px;
        }

        .btn {
            background-color: #F472B6;
            border-radius: 18px;
            border: 2px solid #BE185D;
            transition: 0.3s;
        }

        .btn:hover {
            background-color: #BE185D;
            border-radius: 18px;
            border: 2px solid #BE185D;
            transition: 0.3s;
        }

        .register {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10px;
        }

        .register a {
            color: #BE185D;
            text-decoration: none;
            font-weight: bold;
        }
    </style>

</head>

<body>
    <div class="container-login">

        <div class="overlay">

            <div class="navbar-custom">
                <div class="logo">
                    Tiket<span class="logo-2">Ian</span>
                </div>

                <div class="menu">
                    <a href="registrasi.php"
                        class="<?= ($currentPage == 'registrasi') ? 'active-menu' : ''; ?>">Daftar</a>
                    <a href="login.php" class="<?= ($currentPage == 'login') ? 'active-menu' : ''; ?>">Masuk</a>
                </div>

            </div>

            <div class="login-title">
                <?php if (isset($_SESSION['error'])) {
                    echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
                    unset($_SESSION['error']);
                } ?>

                <?php if (isset($_SESSION['success'])) {
                    echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
                    unset($_SESSION['success']);
                } ?>

                <img class="img-logo" src="img/logo.png" alt="">
                <h1>MASUK</h1>
                <p>Beli Tiket Konser Favoritmu Dengan Mudah!</p>
            </div>

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

                <h3>LOGIN</h3>
                <p>Today is a fresh start. Ready to vibe?</p>

                <form action="" method="POST">
                    <label class="label" for="floating-username"><b>Username</b></label>
                    <input type="text" name="username" class="form-control" id="floating-username"
                        placeholder="Masukan Username" required>

                    <label class="label" for="floating-password"><b>Password</b></label>
                    <input type="password" name="password" class="form-control" id="floating-password"
                        placeholder="Masukan password" required>

                    <button type="submit" name="login" class="btn btn-primary w-100"><b>Masuk</b></button>
                </form>

                <div class="register">
                    <p>Belum punya akun? <a href="registrasi.php">Daftar disini</a></p>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>
</body>

</html>