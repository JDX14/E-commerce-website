<?php

include('Server/connection.php');

if(isset($_POST['order_details_btn']) && isset($_POST['order_id'])) {

    $order_id = $_POST['order_id'];

    $stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");

    $stmt->bind_param('i', $order_id);

    $stmt->execute();

    $order_details = $stmt->get_result();

} else {

    header('location: account.php');
    exit;



}




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Supply Guy</title>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="CSS/order_details.css">
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
                    <li><a href="about.html">About</a></li>
                    <li><a href="login.php"> <i class="fas fa-user"></i></a></li>
                    <li><a href="cart.php"> <i class="fa fa-shopping-cart" aria-hidden="true"></i></a></li>
                </ul>
                <div>
    </header>



    <!--Orders Details-->
    <section id="orders" class="orders container my-5 py-5">
        <div class="container mt-5">
        echo '<h2 class="font-weight-bold text-center">Order Details</h2>';
            <hr class="mx-auto">
        </div>

        <table class="mt-5 pt-5">
            <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            
        </tr>




        <?php while($row = $order_details->fetch_assoc() ) { ?>

        
            <tr>
                <td>
                    <div class="product-info">
                        <img src="<?php echo $row['product_image']; ?>"/>
                        <div>
                            <p class="mt-3"><?php echo $row['product_name']; ?></p>
                        </div>
                    </div>

                </td>

                <td>
                    <span><?php echo $row['product_price']; ?></span>
                </td>

                <td>
                    <span><?php echo $row['product_quantity']; ?></span>
                </td>
                
                
                
            </tr>


        <?php } ?>
            

        </table>

    </section>



    <!-- FOOTER SECTION -->
    <?php include('Layout/footer.php'); ?>
