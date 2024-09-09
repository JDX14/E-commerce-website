<?php
session_start();
$total = 0;
$deliveryFee = 50; // Fixed delivery fee

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $id => $product) {
        $subtotal = $product['price'] * $product['quantity'];
        $total += $subtotal;
    }
    $total += $deliveryFee;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="CSS/checkout.css">
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

    <!-- Checkout -->
    <section class="featured">
        <h2 class="title">Checkout</h2>
        <div class="medium-container">
            <div class="container">
                <form id="checkout-form" method="POST">
                    <div class="form-section">
                        <h3 class="form-heading">Delivery Details</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="checkout-name">Name</label>
                                <input type="text" class="form-control" id="checkout-name" name="name" placeholder="Name" required>
                            </div>
                            <div class="form-group">
                                <label for="checkout-email">Email</label>
                                <input type="text" class="form-control" id="checkout-email" name="email" placeholder="Email" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="checkout-phone">Phone</label>
                                <input type="tel" class="form-control" id="checkout-phone" name="phone" placeholder="Phone" required>
                            </div>
                            <div class="form-group">
                                <label for="checkout-city">City</label>
                                <input type="text" class="form-control" id="checkout-city" name="city" placeholder="City" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="checkout-address">Address</label>
                                <input type="text" class="form-control" id="checkout-address" name="address" placeholder="Address" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-section payment-details">
                        <h3 class="form-heading">Payment Details</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <input type="checkbox" id="cash-on-delivery" name="cash_on_delivery" class="cash-on-delivery-checkbox">
                                <label for="cash-on-delivery">Cash on Delivery:</label>
                            </div>
                        </div>
                        <div id="card-details">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="card-number">Card Number</label>
                                    <input type="text" class="form-control" id="card-number" name="card_number" placeholder="Card Number" required>
                                </div>
                                <div class="form-group">
                                    <label for="card-holder">Card Holder</label>
                                    <input type="text" class="form-control" id="card-holder" name="card_holder" placeholder="Card Holder" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="expiry-date">Expiration Date</label>
                                    <input type="text" class="form-control" id="expiry-date" name="expiry_date" placeholder="MM/YY" pattern="^(0[1-9]|1[0-2])\/\d{2}$" maxlength="5" required>
                                </div>
                                <div class="form-group">
                                    <label for="cvv">CVV</label>
                                    <input type="text" class="form-control" id="cvv" name="cvv" placeholder="CVV" pattern="\d{3}" maxlength="3" required>
                                </div>
                            </div>
                        </div>
                        <div class="total-amount">
                            <p>Total: R<?php echo number_format($total, 2); ?></p>
                        </div>
                        <div class="form-group checkout-btn-container">
                            <input type="submit" class="btn" id="Checkout-btn" name="place_order" value="Place Order">
                        </div>
                    </div>
                </form>
                <div id="order-message"></div>
            </div>
        </div>
    </section>

    <script>
document.getElementById('checkout-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);
    formData.append('place_order', 'true'); // Add the place_order field

    fetch('Server/place_order.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showModal(data.message, true);
        } else {
            showModal(data.message, false);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

function showModal(message, isSuccess) {
    const modalContainer = document.createElement('div');
    modalContainer.className = 'modal-container';

    const modalContent = document.createElement('div');
    modalContent.className = 'modal-content';

    const messageP = document.createElement('p');
    messageP.textContent = message;
    messageP.className = isSuccess ? 'success-message' : 'error-message';
    messageP.style.fontSize = '24px'; /* Increase font size */

    const okButton = document.createElement('button');
    okButton.textContent = 'OK';
    okButton.className = 'modal-btn';
    okButton.addEventListener('click', () => {
        document.body.removeChild(modalContainer);
        if (isSuccess) {
            window.location.href = 'index.php'; // Redirect to index.php
        }
    });

    modalContent.appendChild(messageP);
    modalContent.appendChild(okButton);
    modalContainer.appendChild(modalContent);
    document.body.appendChild(modalContainer);
}
</script>

    <!-- FOOTER SECTION -->
    <?php include('Layout/footer.php'); ?>
</body>
</html>