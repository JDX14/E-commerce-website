<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@500;600&display=swap" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <link rel="stylesheet" href="CSS/style.css">
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

       <!-- HERO SECTION -->
<section class="hero">
    <div class="hero-content">
        <h1>Welcome to My Supply Guy</h1>
        <p>Delivered at your disposal</p>
        <div class="buttons">
            <a href="cleaning.php" class="btn">Cleaning</a>
            <a href="disposable.php" class="btn">Disposables</a>
        </div>
    </div>
</section>

    <!-- Featured Products -->
<section class="featured">
    <h2 class="title">Featured Products</h2>
    <div class="medium-container">
        <div class="row">
    <?php
                // Database configuration file
                include_once 'Server/connection.php';

                //  Specific product IDs
                $product_ids = "8, 17, 20, 30"; 

                // Fetch products within the specified ID range
                $query = "SELECT * FROM products WHERE product_id IN ($product_ids)";
                $result = mysqli_query($conn, $query);

                // Display products
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="col-4 product-item">';
                    echo '<div class="product-image">';
                    echo '<img src="' . $row['product_image'] . '" alt="' . $row['product_name'] . '">';
                    echo '</div>';
                    echo '<div class="product-details">';                  
                    echo '<h4>' . $row['product_name'] . '</h4>';
                    echo '<p>R' . $row['product_price'] . '</p>';
                    echo '<button class="buy-btn" data-id="' . $row['product_id'] . '">Add To Cart</button>'; 
                    echo '</div>';
                    echo '</div>';
                }
                ?>
        </div>
    </div>
</section>

<!-- Latest Products -->
<section class="latest-products">
    <h2 class="title">Latest Products</h2>
    <div class="medium-container">
        <div class="row">
        <?php
        // Include database configuration file
        include_once 'server/connection.php';

        // Fetch the four most recent products
        $query = "SELECT * FROM products ORDER BY product_id DESC LIMIT 4";
        $result = mysqli_query($conn, $query);

        // Display products
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="col-4 product-item">';
            echo '<div class="product-image"><img src="' . $row['product_image'] . '" alt="' . $row['product_name'] . '"></div>';
            echo '<div class="product-details">';
            echo '<h4 class="p-name">' . $row['product_name'] . '</h4>';
            echo '<h4 class="p-price">R' . $row['product_price'] . '</h4>';
            echo '<button class="buy-btn" data-id="' . $row['product_id'] . '">Add To Cart</button>'; // Add data-id attribute
            echo '</div>';
            echo '</div>';
        }
        ?>

        </div>
    </div>
</section>

    <!-- FOOTER SECTION -->
    <?php include('Layout/footer.php'); ?>