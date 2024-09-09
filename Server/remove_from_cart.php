<?php
session_start();

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Check if the product exists in the cart session array
    if (isset($_SESSION['cart'][$product_id])) {
        // Remove the product from the cart session array
        unset($_SESSION['cart'][$product_id]);
        echo json_encode(['status' => 'success', 'message' => 'Product removed from cart']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Product not found in cart']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid product ID']);
}
?>
