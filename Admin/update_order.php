<?php
header('Content-Type: application/json');

// Include database connection
include("../Server/connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $order_cost = $_POST['order_cost'];
    $order_status = $_POST['order_status'];
    $payment_status = $_POST['payment_status'];

    $query = "UPDATE orders SET  
                order_cost ='$order_cost', 
                order_status ='$order_status', 
                payment_status ='$payment_status'
              WHERE order_id='$order_id'";

    if ($conn->query($query) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Order updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error updating order: ' . $conn->error]);
    }

    // Close the connection
    $conn->close();
}
?>