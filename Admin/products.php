<?php
// Include database connection
include("../Server/connection.php");


// Define number of products per page
$productsPerPage = 24;

// Calculate total number of products
$query = "SELECT COUNT(*) as total FROM products";
$result = $conn->query($query);
$totalProducts = $result->fetch_assoc()['total'];

// Calculate total number of pages
$totalPages = ceil($totalProducts / $productsPerPage);

// Determine current page
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the starting product index for the current page
$start = ($current_page - 1) * $productsPerPage;

// Retrieve products for the current page
$query = "SELECT * FROM products LIMIT $start, $productsPerPage";
$result = $conn->query($query);

?>

<?php include('header.php');?>

    <!-- Sidebar -->
    <?php include('sidemenu.php'); ?>

    <!-- Main Content -->
    <div class="main-content">
       
        <table class="products-table">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Product Category</th>
                    <th>Product Stock</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    $product_image = "../Images/" . htmlspecialchars($row['product_image']);
                    $product_id = htmlspecialchars($row['product_id']);
                    $product_name = htmlspecialchars($row['product_name']);
                    $product_price = htmlspecialchars($row['product_price']);
                    $product_category = htmlspecialchars($row['product_category']);
                    $product_stock = htmlspecialchars($row['product_stock']);

                    echo "<tr>
                            <td>{$product_id}</td>
                            <td><img src='{$product_image}' alt='Product Image' style='width: 50px; height: 50px;'></td>
                            <td>{$product_name}</td>
                            <td>{$product_price}</td>
                            <td>{$product_category}</td>
                            <td>{$product_stock}</td>
                            <td><button class='edit-btn' data-id='{$product_id}' data-name='{$product_name}' data-price='{$product_price}' data-category='{$product_category}' data-stock='{$product_stock}' data-image='{$product_image}'>Edit</button></td>
                            <td><button onclick='deleteProduct({$product_id})'>Delete</button></td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Pagination links -->
        <div class="pagination">
            <?php
            // Previous page link
            if ($current_page > 1) {
                echo "<a href='products.php?page=" . ($current_page - 1) . "'>&laquo; Previous</a>";
            }

            // Numbered page links
            for ($i = 1; $i <= $totalPages; $i++) {
                if ($i == $current_page) {
                    echo "<span class='current'>$i</span>";
                } else {
                    echo "<a href='products.php?page=$i'>$i</a>";
                }
            }

            // Next page link
            if ($current_page < $totalPages) {
                echo "<a href='products.php?page=" . ($current_page + 1) . "'>Next &raquo;</a>";
            }
            ?>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div id="editProductModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit Product</h2>
            <form id="editProductForm">
                <input type="hidden" id="edit-product-id" name="product_id">
                <div class="form-group">
                    <label for="edit-product-name">Product Name</label>
                    <input type="text" id="edit-product-name" name="product_name" required>
                </div>
                <div class="form-group">
                    <label for="edit-product-price">Product Price</label>
                    <input type="text" id="edit-product-price" name="product_price" required>
                </div>
                <div class="form-group">
                    <label for="edit-product-category">Product Category</label>
                    <input type="text" id="edit-product-category" name="product_category" required>
                </div>
                <div class="form-group">
                    <label for="edit-product-stock">Product Stock</label>
                    <input type="text" id="edit-product-stock" name="product_stock" required>
                </div>
                <div class="form-group">
                    <label for="edit-product-image">Product Image</label>
                    <input type="text" id="edit-product-image" name="product_image" required>
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