<?php
// delete_product.php
include("../Server/connection.php");

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Prepare and execute the delete query
    $stmt = $conn->prepare("DELETE FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Product deleted successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete product.']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Product ID not provided.']);
}

$conn->close();
?>