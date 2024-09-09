<?php
header('Content-Type: application/json');

// Include database connection
include("../Server/connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_category = $_POST['product_category'];
    $product_stock = $_POST['product_stock'];
    $product_image = $_POST['product_image'];

    $query = "UPDATE products SET 
                product_name='$product_name', 
                product_price='$product_price', 
                product_category='$product_category', 
                product_stock='$product_stock', 
                product_image='$product_image' 
              WHERE product_id='$product_id'";

    if ($conn->query($query) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Product updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error updating product: ' . $conn->error]);
    }

    // Close the connection
    $conn->close();
}
?>