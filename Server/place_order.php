<?php
session_start();
include("connection.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['place_order'])) {
        // Get user info
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $city = $_POST['city'];
        $address = $_POST['address'];
        $order_status = "Pending"; // Changed from "on_hold" to "pending"
        $user_id = $_SESSION['user_id']; // Ensure to fetch this from session
        $order_date = date("Y-m-d H:i:s");

        // Define the fixed delivery fee
        $delivery_fee = 50.00;

        // Initialize order cost
        $order_cost = $delivery_fee; // Start with the delivery fee

        // Check if the cart is not empty
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            // Check if Cash on Delivery is selected
            $is_cod = isset($_POST['cash_on_delivery']) ? true : false;

            // Insert order into orders table
            $stmt = $conn->prepare("INSERT INTO orders (order_cost, order_status, payment_status, user_id, user_phone, user_city, user_address, order_date) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?);");
            if ($stmt === false) {
                die('Prepare failed: ' . htmlspecialchars($conn->error));
            }

            // Bind and execute the order statement
            $payment_status = $is_cod ? "Unpaid" : "Paid"; // Set payment status based on COD selection
            $stmt->bind_param('dssissss', $order_cost, $order_status, $payment_status, $user_id, $phone, $city, $address, $order_date);
            if ($stmt->execute()) {
                $order_id = $stmt->insert_id;

                // Insert each product in the cart into order_items table
                foreach ($_SESSION['cart'] as $product_id => $product) {
                    // Fetch product price and stock from the database
                    $stmt_product = $conn->prepare("SELECT product_price, product_stock FROM products WHERE product_id = ?");
                    $stmt_product->bind_param('i', $product_id);
                    $stmt_product->execute();
                    $result = $stmt_product->get_result();
                    $row = $result->fetch_assoc();
                    $product_price = $row['product_price'];
                    $product_stock = $row['product_stock']; // Retrieve product stock
                    $stmt_product->close();

                    // Check if there's enough stock
                    $quantity = $product['quantity']; // Get the quantity of the current product
                    if ($product_stock < $quantity) {
                        die("Not enough stock for product ID $product_id");
                    }

                    // Update stock quantity in the database
                    $new_stock = $product_stock - $quantity;
                    $stmt_update_stock = $conn->prepare("UPDATE products SET product_stock = ? WHERE product_id = ?");
                    $stmt_update_stock->bind_param('ii', $new_stock, $product_id);
                    $stmt_update_stock->execute();
                    $stmt_update_stock->close();

                    // Calculate item cost and add it to the total order cost
                    $item_cost = $product_price * $quantity;
                    $order_cost += $item_cost;

                    // Insert order item into order_items table
                    $stmt_item = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, product_image, product_quantity, product_price, user_id, order_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?);");
                    if ($stmt_item === false) {
                        die('Prepare failed: ' . htmlspecialchars($conn->error));
                    }
                    $stmt_item->bind_param('iissidis', $order_id, $product_id, $product['name'], $product['image'], $quantity, $product_price, $user_id, $order_date);
                    $stmt_item->execute();
                    $stmt_item->close();
                }

                // Update the order cost to include the correct total
                $stmt_update = $conn->prepare("UPDATE orders SET order_cost = ? WHERE order_id = ?");
                if ($stmt_update === false) {
                    die('Prepare failed: ' . htmlspecialchars($conn->error));
                }
                $stmt_update->bind_param('di', $order_cost, $order_id);
                $stmt_update->execute();
                $stmt_update->close();

                // Clear cart
                unset($_SESSION['cart']);
                unset($_SESSION['total']);

                // Return a JSON response
                echo json_encode([
                    'success' => true,
                    'message' => 'Order placed successfully!'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to place order.'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Cart is empty.'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Missing place_order field.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);
}
?>