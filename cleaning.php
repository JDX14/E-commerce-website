<?php
// Include database configuration file
include_once 'Server/connection.php';

// Define the number of products per page
$productsPerPage = 12;

// Determine the current page
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the starting product index for the current page
$start = ($current_page - 1) * $productsPerPage;

// Fetch products for the current page
$query = "SELECT * FROM products WHERE product_category = 'cleaning' LIMIT $start, $productsPerPage";
$result = mysqli_query($conn, $query);

// Calculate total number of products
$totalProductsQuery = "SELECT COUNT(*) as total FROM products WHERE product_category = 'cleaning'";
$totalProductsResult = mysqli_query($conn, $totalProductsQuery);
$totalProducts = mysqli_fetch_assoc($totalProductsResult)['total'];

// Calculate total number of pages
$totalPages = ceil($totalProducts / $productsPerPage);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cleaning Products 1</title>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="CSS/product.css">
</head>

<>

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


    <!-- ALL PRODUCTS -->
  <!-- Featured Products -->
  <section class="featured">
    <h2 class="title">Cleaning Products</h2>
    <div class="medium-container">
        <div class="row">
        <?php
                // Display products
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="col-4">';
                    echo '<img src="' . $row['product_image'] . '" alt="' . $row['product_name'] . '">';
                    echo '<h4>' . $row['product_name'] . '</h4>';
                    echo '<p>R' . $row['product_price'] . '</p>';
                    echo '<button class="buy-btn" data-id="' . $row['product_id'] . '">Add To Cart</button>'; // Add data-id attribute
                    echo '</div>';
                }
                ?>
                 </div>
        </div>
    </section>


       <!-- Pagination links -->
<div class="pagination">
    <?php
    // Previous page link
    if ($current_page > 1) {
        echo "<a href='cleaning.php?page=" . ($current_page - 1) . "'>&laquo; Previous</a>";
    }

    // Numbered page links
    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == $current_page) {
            echo "<span class='current'>$i</span>";
        } else {
            echo "<a href='cleaning.php?page=$i'>$i</a>";
        }
    }

    // Next page link
    if ($current_page < $totalPages) {
        echo "<a href='cleaning.php?page=" . ($current_page + 1) . "'>Next &raquo;</a>";
    }
    ?>
</div>

    <!-- FOOTER SECTION -->
    <?php include('Layout/footer.php'); ?>