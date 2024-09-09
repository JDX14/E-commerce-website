<?php
session_start();
include("../Server/connection.php");

// Fetch orders from the database
$query = "SELECT * FROM orders";
$result = $conn->query($query);

?>

<?php include('header.php');?>


    <!-- Sidebar -->
    <?php include('sidemenu.php'); ?>

      <!-- Main Content -->
      <div class="main-content">
        
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Order Cost</th>
                    <th>Order Status</th>
                    <th>User ID</th>
                    <th>Order Date</th>
                    <th>Payment Status</th>
                    <th>User Phone</th>
                    <th>User Address</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo  "<tr id='order-row-{$row['order_id']}'>
                                <td>{$row['order_id']}</td>
                                <td>{$row['order_cost']}</td>
                                <td>{$row['order_status']}</td>
                                <td>{$row['user_id']}</td>
                                <td>{$row['order_date']}</td>
                                <td>{$row['payment_status']}</td>
                                <td>{$row['user_phone']}</td>
                                <td>{$row['user_address']}</td>
                                <td><button onclick=\"editOrder({$row['order_id']}, '{$row['order_cost']}', '{$row['order_status']}', '{$row['payment_status']}')\">Edit</button></td>
                                <td><button onclick=\"deleteOrder({$row['order_id']})\">Delete</button></td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No orders found</td></tr>";
                }
                ?>
            </tbody>
        </table>

    <!-- Edit Product Modal -->
    <div id="editOrderModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit Order</h2>
            <form id="editOrderForm">
                <input type="hidden" id="edit-order-id" name="order_id">
                <div class="form-group">
                    <label for="edit-order-cost">Order Cost</label>
                    <input type="text" id="edit-order-cost" name="order_cost" required>
                </div>
                <div class="form-group">
                <label for="edit-order-status">Order Status</label>
                <select id="edit-order-status" name="order_status" required>
                    <option value="pending">Pending</option>
                    <option value="shipped">Shipped</option>
                    <option value="delivered">Delivered</option>
                </select>
            </div>
            <div class="form-group">
                <label for="edit-payment-status">Payment Status</label>
                <select id="edit-payment-status" name="payment_status" required>
                    <option value="paid">Paid</option>
                    <option value="unpaid">Unpaid</option>
                </select>
            </div>
            <button type="submit">Save Changes</button>
        </form>
        </div>
    </div>
         
<script src="admin.js"></script>
</body>

</html>

<?php
// Close database connection
$conn->close();
?>