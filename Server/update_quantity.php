<?php
session_start();

if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Check if the product exists in the cart
    if (isset($_SESSION['cart'][$product_id])) {
        // Update the quantity
        $_SESSION['cart'][$product_id]['quantity'] = $quantity;

        // Calculate and return the new subtotal
        $price = $_SESSION['cart'][$product_id]['price'];
        $subtotal = $price * $quantity;

        // Send the updated subtotal as response
        echo json_encode(['status' => 'success', 'subtotal' => $subtotal]);
    } else {
        // Product not found in the cart
        echo json_encode(['status' => 'error', 'message' => 'Product not found in cart']);
    }
} else {
    // Invalid request
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>