<?php
session_start();

include_once 'connection.php';

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    $query = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += 1; // Increment quantity if product already in cart
        } else {
            $_SESSION['cart'][$product_id] = [
                'name' => $product['product_name'],
                'price' => $product['product_price'],
                'image' => '' . $product['product_image'],
                'quantity' => 1
            ];
        }

        // Recalculate total cost
        $total = 0;
        $deliveryFee = 50; // Fixed delivery fee
        foreach ($_SESSION['cart'] as $id => $product) {
            $total += $product['price'] * $product['quantity'];
        }
        $_SESSION['total'] = $total + $deliveryFee;

        echo json_encode(['status' => 'success', 'message' => 'Product added to cart']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Product not found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid product ID']);
}
?>