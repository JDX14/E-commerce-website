<?php
session_start();
include('Server/connection.php');

if (!isset($_SESSION['logged_in'])) {
    header('location: login.php');
    exit;
}

if (isset($_GET['logout'])) {
    if (isset($_SESSION['logged_in'])) {
        unset($_SESSION['logged_in']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        header('location: login.php');
        exit;
    }
}

if (isset($_POST['change_password'])) {
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $user_email = $_SESSION['user_email'];

    if ($password !== $confirmPassword) {
        header('location: account.php?error=Passwords do not match');
        exit();
    }

    if (strlen($password) < 6) {
        header('location: account.php?error=Password must be at least 6 characters');
    } else {
        $stmt = $conn->prepare("UPDATE users SET user_password=? WHERE user_email=?");
        $stmt->bind_param('ss', md5($password), $user_email);

        if ($stmt->execute()) {
            header('location: account.php?message=Password has been updated');
        } else {
            header('location: account.php?error=Could not update password');
        }
    }
}

$user_id = $_SESSION['user_id']; // Ensure user_id is set in session
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ?");
if ($stmt === false) {
    die('prepare() failed: ' . htmlspecialchars($conn->error));
}
$stmt->bind_param('i', $user_id);
$stmt->execute();
$orders = $stmt->get_result();

if ($orders === false) {
    die('get_result() failed: ' . htmlspecialchars($stmt->error));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="CSS/accountpage.css">
</head>
<body>
    <!-- HEADER -->
    <header>
        <div class="container">
            <div class="navbar">
                <a class="logo" href="index.php">
                    <img src="Logo/MSG Pic.jpeg" alt="My Supply Guy logo">My Supply Guy
                </a>
                <button class="menu-toggle">☰</button>
                <ul class="nav-list">
                    <li><a href="index.php">Home</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Products <i class="arrow down"></i>
                        </a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="cleaning.php">Cleaning</a></li>
                          <li><a class="dropdown-item" href="disposable.php">Disposables</a></li>
                        </ul>
                    </li>
                    <button class="menu-toggle">Toggle Menu</button>
                    <ul class="nav-list"></ul>
                    <li><a href="about.php">About</a></li>
                    <li><a href="login.php"> <i class="fas fa-user"></i></a></li>
                    <li><a href="cart.php"> <i class="fa fa-shopping-cart" aria-hidden="true"></i></a></li>
                </ul>
                <div>
    </header>

    <!-- Account Section -->
    <section class="my-5 py-5">
        <div class="row container mx-auto">
            <div class="left-half text-center mt-3 pt-5 col-lg-6 col-md-12 col-sn-12">
                <div class="account-info">
                    <p class="text-center" style="color:green; font-size:18px;"><?php if (isset($_GET['register_success'])) { echo $_GET['register_success']; } ?></p>
                    <p class="text-center" style="color:green; font-size:18px;"><?php if (isset($_GET['login_success'])) { echo $_GET['login_success']; } ?></p>
                    <h3 class="font-weight-bold">Account Info</h3>
                    <hr class="mx-auto">
                    <div class="account-details">
                        <p>Name: <span><?php if (isset($_SESSION['user_name'])) { echo $_SESSION['user_name']; } ?></span></p>
                        <p>Email: <span><?php if (isset($_SESSION['user_email'])) { echo $_SESSION['user_email']; } ?></span></p>
                        <p><a href="account.php?logout=1" id="logout-btn">Logout</a></p>
                    </div>
                </div>
            </div>
            <div class="right-half col-lg-6 col-md-12 col-sm-12">
                <form id="account-form" method="POST" action="account.php">
                    <p class="text-center" style="color:red; font-size:18px;"><?php if (isset($_GET['error'])) { echo $_GET['error']; } ?></p>
                    <p class="text-center" style="color:green; font-size:18px;"><?php if (isset($_GET['message'])) { echo $_GET['message']; } ?></p>
                    <h3>Change Password</h3>
                    <hr class="mx-auto">
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" class="form-control" id="account-password" name="password" placeholder="Password" required />
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control" id="account-password-confirm" name="confirmPassword" placeholder="Password" required />
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Change Password" name="change_password" class="btn" id="change-pass-btn">
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Orders Section -->
    <section id="orders" class="orders container my-5 py-5">
        <div class="container mt-2">
            <h2 class="font-weight-bold text-center">Your Orders</h2>
            <hr class="mx-auto">
        </div>
        <table class="mt-5 pt-5">
            <tr>
                <th>Order ID</th>
                <th>Order Cost</th>
                <th>Order Status</th>
                <th>Order Date</th>
                <th>Order Details</th>
            </tr>
            <?php
            if ($orders && $orders->num_rows > 0) {
                while ($row = $orders->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $row['order_id']; ?></td>
                        <td><?php echo $row['order_cost']; ?></td>
                        <td><?php echo $row['order_status']; ?></td>
                        <td><?php echo $row['order_date']; ?></td>
                        <td>
                            <form method="POST" action="order_details.php">
                                <input type="hidden" value="<?php echo $row['order_id']; ?>" name="order_id"/>
                                <input class="btn order-details-btn" name="order_details_btn" type="submit" value="Details">
                            </form>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="5">No orders found</td>
                </tr>
                <?php
            }
            ?>
        </table>
    </section>

    <!-- FOOTER SECTION -->
    <?php include('Layout/footer.php'); ?>