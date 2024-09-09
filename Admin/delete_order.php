<?php
session_start();
include("../Server/connection.php");

// Check if JSON data is received
$data = json_decode(file_get_contents("php://input"));

if (isset($data->order_id) && is_numeric($data->order_id)) {
    $orderId = $data->order_id;

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Prepare statement to delete order items from database
        $stmt = $conn->prepare("DELETE FROM order_items WHERE order_id = ?");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();

        // Prepare statement to delete order from database
        $stmt = $conn->prepare("DELETE FROM orders WHERE order_id = ?");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();

        // Commit transaction
        $conn->commit();

        // Deletion successful
        echo json_encode(array('status' => 'success', 'message' => 'Order and associated items deleted successfully'));
        exit;
    } catch (Exception $e) {
        // Rollback transaction
        $conn->rollback();

        // Deletion failed
        echo json_encode(array('status' => 'error', 'message' => 'Failed to delete order: ' . $e->getMessage()));
        exit;
    }
} else {
    // Invalid request
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request'));
    exit;
}
?>