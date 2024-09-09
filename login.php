<?php

session_start();

include('Server/connection.php');

if(isset($_SESSION['logged_in'])) {
    header('location: account.php');
    exit;
}

if(isset($_POST['login_btn'])) {

    $email =  $_POST['email'];
    $password = md5($_POST['password']);

    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT user_id,user_name,user_email, user_password FROM users WHERE user_email = ? AND user_password = ? LIMIT 1");
    
    // Check if preparation succeeded
    if ($stmt) {
        // Bind parameters
        $stmt->bind_param('ss', $email, $password);
        
        // Execute the statement
        $stmt->execute();

        // Check if execution succeeded
        if($stmt) {
            // Bind results
            $stmt->bind_result($user_id, $user_name, $user_email, $user_password);
            
            // Store result
            $stmt->store_result();
            
            // Check if a row was found
            if($stmt->num_rows == 1) {
                // Fetch the result
                $stmt->fetch();

                // Set session variables
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_name'] = $user_name;
                $_SESSION['user_email'] = $user_email;
                $_SESSION['logged_in'] = true;

                // Redirect back to the previous page if 'redirect' parameter is set
                if (isset($_GET['redirect'])) {
                    header('Location: ' . $_GET['redirect']);
                    exit();
                } else {
                    // If 'redirect' parameter is not set, redirect to a default page
                    header('Location: index.php'); // Change 'index.php' to the default page you want to redirect to
                    exit();
                }
            } else {
                // Redirect with error message
                header('location: login.php?error=Could not verify your account');
                exit();
            }
        }
    }

    // Redirect with error message
    header('location: login.php?error=Something went wrong');
    exit();
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
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="CSS/login.css">
    

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
    
    <!--Login-->

    <section class="my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Login</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container">
            <form id="login-form" method="POST" action="login.php?redirect=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>">
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
                <div class="form-group">
                    <a id="register-url" class="btn" href="register.php">Don't have account? Register</a>
                </div>
            </form>
        </div>
    </section>

    <!-- FOOTER SECTION -->
    <?php include('Layout/footer.php'); ?>