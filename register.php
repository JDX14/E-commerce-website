<?php

session_start();

// Check if the user is already logged in
if(isset($_SESSION['logged_in'])) {
    header('location: account.php'); // Redirect to the account page
    exit; // Stop further execution
}


include('Server/connection.php');

if(isset($_POST['register'])) {

    
    $name =  $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    //if passwords don't match
    if($password !== $confirmPassword) {
        header('location: register.php?error=Passwords do not match');
        exit();
    }

    //if password less than 6 characters
    if(strlen($password) < 6) {
        header('location: register.php?error=Password must be atleast 6 characters');
        exit();
    }

    //Check whether there is a user with this email or not
    $stmt1 = $conn->prepare("SELECT COUNT(*) FROM users WHERE user_email=?");
    $stmt1->bind_param('s', $email);
    $stmt1->execute();
    $stmt1->bind_result($num_rows);
    $stmt1->store_result();
    $stmt1->fetch();

    //if there is a user already registered with this email
    if($num_rows != 0) {
        header('location: register.php?error=User with this email already exists');
        exit();
    }

    //Create new user
    $stmt = $conn->prepare("INSERT INTO users (user_name, user_email, user_password) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $name, $email, md5($password));

    //if account created successfully
    if($stmt->execute()) {
        $user_id = $stmt->insert_id;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = $name;
        $_SESSION['logged_in'] = true;
        header('location: account.php?register_success=You registered successfully');
        exit();
    } else {
        header('location: register.php?error=Could not create an account at the moment');
        exit();
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="CSS/register.css">
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

    <!--Register-->

    <section class="my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Register</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container">
            <form id="register-form" method="POST" action="register.php">
                <p class="error-message" style="color: red;"><?php if(isset($_GET ['error'])){ echo $_GET['error']; }?></p>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" id="register-name" name="name" placeholder="Name" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" id="register-email" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" id="register-password" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" id="register-confirm-password" name="confirmPassword" placeholder="Confirm Password" required>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn" id="register-btn" name="register" value="Register">
                </div>
                <div class="form-group">
                    <a id="login-url" class="btn" href="login.php">Already have an account? Login</a>
                </div>
            </form>
        </div>
    </section>

    <!-- FOOTER SECTION -->
    <?php include('Layout/footer.php'); ?>