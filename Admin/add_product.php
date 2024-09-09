<?php
// Include database connection
include("../Server/connection.php");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_category = $_POST['product_category'];
    $product_stock = $_POST['product_stock'];
    $product_image = $_POST['product_image'];

    // Insert product into database
    $query = "INSERT INTO products (product_name, product_price, product_category, product_stock, product_image) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssis", $product_name, $product_price, $product_category, $product_stock, $product_image);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Product added successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add product: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
    exit;
}


include('header.php'); // This should include the necessary head and body tags
include('sidemenu.php');
?>

<div class="main-content">
    <h1>Add Product</h1>
    <div id="success-message" class="message" style="display:none; color:green;">
        <span>Product added successfully!</span>
        <button id="success-close" class="close-button">X</button>
    </div>
    <div id="error-message" class="message" style="display:none; color:red;">
        <span>Error: </span>
        <button id="error-close" class="close-button">X</button>
    </div>
    <form id="newProductForm" class="form-container">
        <div class="form-group">
            <label for="product-name">Product Name</label>
            <input type="text" id="product-name" name="product_name" required>
        </div>
        <div class="form-group">
            <label for="product-price">Product Price</label>
            <input type="text" id="product-price" name="product_price" required>
        </div>
        <div class="form-group">
            <label for="product-category">Product Category</label>
            <select id="product-category" name="product_category" required style="width: 200px; height: 40px;"> 
                <option value="">Select Category</option>
                <option value="Cleaning">Cleaning</option>
                <option value="Disposable">Disposable</option>
            </select>
        </div>
        <div class="form-group">
            <label for="product-stock">Product Stock</label>
            <input type="text" id="product-stock" name="product_stock" required>
        </div>
        <div class="form-group">
            <label for="product-image">Product Image</label>
            <input type="text" id="product-image" name="product_image" required>
        </div>
        <button type="submit">Add Product</button>
    </form>
</div>
    <script src="admin.js"></script>
</body>
</html>