<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="CSS/Cart.css">
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
                    <li><a href="about.php">About</a></li>
                    <li><a href="login.php"> <i class="fas fa-user"></i></a></li>
                    <li><a href="cart.php"> <i class="fa fa-shopping-cart" aria-hidden="true"></i></a></li>
                </ul>
            </div>
        </div>
    </header>
    
    <!--Cart-->
    <section class="cart container my-5 py-5">
        <div class="container mt-5">
            <h2 class="font-weight-bold">Your Cart</h2>
        </div>

        <table class="mt-5 pt-5">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
            <?php
    $total = 0;
    $deliveryFee = 50; // Fixed delivery fee

    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $id => $product) {
            $subtotal = $product['price'] * $product['quantity'];
            $total += $subtotal;
            $image = isset($product['image']) ? $product['image'] : 'default.png'; // Fallback image
            echo "<tr>
                <td>
                    <div class='product-info'>
                        <img src='{$image}' alt='{$product['name']}' width='50' height='50'>
                        <span class='product-name'>{$product['name']}</span>
                    </div>
                </td>
                <td>
                    <input type='number' value='{$product['quantity']}' min='1' class='quantity-input' data-id='{$id}'>
                    <button class='remove-btn' data-id='{$id}'>Remove</button>
                </td>
                <td class='subtotal' data-id='{$id}'>R" . number_format($subtotal, 2) . "</td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='3'>Your cart is empty.</td></tr>";
    }

    // Calculate total including delivery fee
    $total += $deliveryFee;
    ?>
            </tbody>
        </table>

        <div class="cart-total">
            <table>
                <tr>
                    <td>Delivery</td>
                    <td class="delivery-fee">R50.00</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td class="total-fee">R<?php echo number_format($total, 2); ?></td>
                </tr>
            </table>
        </div>

        <div class="checkout-row">
            <button class="checkout-button" id="checkout-btn">Checkout</button>
        </div>
    </section>

    <script>
        document.getElementById('checkout-btn').addEventListener('click', function() {
            const cartIsEmpty = <?php echo empty($_SESSION['cart']) ? 'true' : 'false'; ?>;
            if (cartIsEmpty) {
                window.location.href = 'index.php';
            } else {
                window.location.href = 'checkout.php';
            }
        });
    </script>

    <!-- FOOTER SECTION -->
    <?php include('Layout/footer.php'); ?>