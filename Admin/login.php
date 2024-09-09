<?php

session_start();

include('../Server/connection.php');

if (isset($_SESSION['admin_logged_in'])) {
    header('Location: dashboard.php');
    exit;
}

if (isset($_POST['login_btn'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $stmt = $conn->prepare("SELECT admin_id, admin_name, admin_email FROM admins WHERE admin_email = ? AND admin_password = ? LIMIT 1");
    
    if ($stmt) {
        $stmt->bind_param('ss', $email, $password);
        $stmt->execute();
        $stmt->bind_result($admin_id, $admin_name, $admin_email);
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->fetch();

            $_SESSION['admin_id'] = $admin_id;
            $_SESSION['admin_name'] = $admin_name;
            $_SESSION['admin_email'] = $admin_email;
            $_SESSION['admin_logged_in'] = true;

            header('Location: dashboard.php');
            exit();
        } else {
            header('Location: login.php?error=Invalid email or password');
            exit();
        }
    } else {
        header('Location: login.php?error=SQL error');
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/login.css">
    <script src="../admin.js" defer></script>
</head>

<body>
    
    <!-- HEADER -->
    <header>
        <div class="container">
            <div class="navbar">
                <a class="logo" href="../index.php">
                    <img src="../Logo/MSG Pic.jpeg" alt="My Supply Guy logo">My Supply Guy
                </a>
                <button class="menu-toggle">☰</button>
                <ul class="nav-list">
                    <li><a href="../index.php">Home</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Products <i class="arrow down"></i>
                        </a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="../cleaning.php">Cleaning</a></li>
                          <li><a class="dropdown-item" href="../disposable.php">Disposables</a></li>
                        </ul>

                        
                      </li>
                <button class="menu-toggle">Toggle Menu</button>
                <ul class="nav-list"></ul>
                    <li><a href="../about.php">About</a></li>
                    <li><a href="../login.php"> <i class="fas fa-user"></i></a></li>
                    <li><a href="../cart.php"> <i class="fa fa-shopping-cart" aria-hidden="true"></i></a></li>
                </ul>
                <div>
    </header>
    
    <!--Login-->

    <section class="my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Admin Login</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container">
            <form id="login-form" method="POST" action="login.php">
                <p style="color:red" class="error-message"><?php if(isset($_GET['error'])){ echo $_GET['error'];} ?></p>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" id="login-email" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" id="login-password" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn" id="login-btn" name="login_btn" value="Login"/>
                </div>
            </form>
        </div>
    </section>

    <!-- FOOTER SECTION -->
    <footer>
        <div class="footer-row">
            <h3>Information</h3>
            <ul>
                <li>Tel: 061 521 1889</li>
                <li>Email: info@mysupplyguy.co.za</li>
            </ul>
        </div>
        <div class="footer-row">
            <h3>Follow Us</h3>
            <ul>
                <!-- Facebook icon with link -->
                <li><a href="https://www.facebook.com/mysupplyguy1" target="_blank"><i class="fab fa-facebook"></i> Facebook</a></li>
                <!-- Instagram icon with link -->
                <li><a href="https://www.instagram.com/mysupplyguy1/" target="_blank"><i class="fab fa-instagram"></i> Instagram</a></li>
            </ul>
        </div>
    </footer>
</body>


</html>