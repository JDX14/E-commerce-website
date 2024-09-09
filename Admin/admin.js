document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM fully loaded and parsed');

    const loginForm = document.getElementById('admin-login-form');

    if (loginForm) {
        loginForm.addEventListener('submit', (event) => {
            event.preventDefault(); // Prevent the default form submission

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            // Perform client-side validation if needed
            if (validateEmail(email) && validatePassword(password)) {
                // Optionally, you can add more client-side logic here
                // For example, showing a loading spinner or message

                // Then, submit the form programmatically
                loginForm.submit();
            } else {
                console.error('Validation failed');
                // Show an appropriate error message to the user
            }
        });
    } else {
        console.error('Login form not found in the DOM.');
    }
});



// Example validation functions
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function validatePassword(password) {
    // Add your password validation logic here
    return password.length >= 6;
}
   
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById("editProductModal");
    const editButtons = document.querySelectorAll('.edit-btn');
    const span = document.getElementsByClassName("close")[0];

    if (modal && editButtons.length > 0 && span) {
        editButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const productId = this.getAttribute('data-id');
                const productName = this.getAttribute('data-name');
                const productPrice = this.getAttribute('data-price');
                const productCategory = this.getAttribute('data-category');
                const productStock = this.getAttribute('data-stock');
                const productImage = this.getAttribute('data-image');

                document.getElementById('edit-product-id').value = productId;
                document.getElementById('edit-product-name').value = productName;
                document.getElementById('edit-product-price').value = productPrice;
                document.getElementById('edit-product-category').value = productCategory;
                document.getElementById('edit-product-stock').value = productStock;
                document.getElementById('edit-product-image').value = productImage;

                modal.style.display = "block";
                console.log("Modal opened with product ID:", productId);
            });
        });

        span.onclick = function () {
            modal.style.display = "none";
            console.log("Modal closed");
        }

        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
                console.log("Modal closed by clicking outside");
            }
        }
    }

    const editProductForm = document.getElementById('editProductForm');
    if (editProductForm) {
        editProductForm.addEventListener('submit', function (event) {
            event.preventDefault();
            console.log("Form submission started");

            const formData = new FormData(this);

            fetch('update_product.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.headers.get('content-type').includes('application/json')) {
                    console.log("JSON response received");
                    return response.json();
                } else {
                    console.error('Expected JSON response');
                    throw new Error('Expected JSON response');
                }
            })
            .then(data => {
                if (data.status === 'success') {
                    console.log("Product updated successfully:", data.message);
                    alert(data.message);
                    modal.style.display = "none";
                    location.reload();
                } else {
                    console.error('Failed to update product:', data.message);
                    alert('Failed to update product: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error.message);
                fetch('update_product.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(text => console.log('Full response:', text));
            });
        });
    }
});
    // Delete product function
    window.deleteProduct = function(productId) {
        if (confirm('Are you sure you want to delete this product?')) {
            fetch('delete_product.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'product_id=' + productId,
            })
            .then(response => {
                if (response.headers.get('content-type').includes('application/json')) {
                    return response.json();
                } else {
                    throw new Error('Expected JSON response');
                }
            })
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                fetch('delete_product.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'product_id=' + productId,
                })
                .then(response => response.text())
                .then(text => console.log('Full response:', text));
            });
        }
    }


    /* Edit Order */
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById("editOrderModal");
        const span = document.getElementsByClassName("close")[0];
    
        function editOrder(orderId, orderCost, orderStatus, paymentStatus) {
            document.getElementById('edit-order-id').value = orderId;
            document.getElementById('edit-order-cost').value = orderCost;
            document.getElementById('edit-order-status').value = orderStatus;
            document.getElementById('edit-payment-status').value = paymentStatus;
    
            modal.style.display = "block";
            console.log("Modal opened with order ID:", orderId);
        }
    
        window.editOrder = editOrder; // Make the function globally accessible
    
        if (span) {
            span.onclick = function () {
                modal.style.display = "none";
                console.log("Modal closed");
            }
    
            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                    console.log("Modal closed by clicking outside");
                }
            }
        }
    
        const editOrderForm = document.getElementById('editOrderForm');
        if (editOrderForm) {
            editOrderForm.addEventListener('submit', function (event) {
                event.preventDefault();
                console.log("Form submission started");
    
                const formData = new FormData(this);
    
                fetch('update_order.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (response.headers.get('content-type').includes('application/json')) {
                        console.log("JSON response received");
                        return response.json();
                    } else {
                        console.error('Expected JSON response');
                        throw new Error('Expected JSON response');
                    }
                })
                .then(data => {
                    if (data.status === 'success') {
                        console.log("Order updated successfully:", data.message);
                        alert(data.message);
                        modal.style.display = "none";
                        location.reload();
                    } else {
                        console.error('Failed to update order:', data.message);
                        alert('Failed to update order: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error.message);
                    fetch('update_order.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(text => console.log('Full response:', text));
                });
            });
        }
    });

    
// Function to delete an order
function deleteOrder(orderId) {
    // Confirm deletion with user
    if (confirm('Are you sure you want to delete this order?')) {
        // AJAX request to delete order
        fetch('delete_order.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ order_id: orderId }), // Send order_id as JSON
        })
        .then(response => {
            if (response.ok) {
                // Order deleted successfully
                document.getElementById('order-row-' + orderId).remove(); // Remove row from UI
                alert('Order deleted successfully'); // Notify user
            } else {
                // Handle HTTP errors
                throw new Error('Failed to delete order');
            }
        })
        .catch(error => {
            console.error('Error deleting order:', error);
            alert('An error occurred while deleting order'); // Notify user about the error
        });
    }
}


/* Add Product */
document.addEventListener('DOMContentLoaded', function() {
    const newProductForm = document.getElementById('newProductForm');

    if (newProductForm) {
        newProductForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);

            fetch('add_product.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const successMessage = document.getElementById('success-message');
                const errorMessage = document.getElementById('error-message');

                if (data.status === 'success') {
                    successMessage.style.display = 'block';
                    errorMessage.style.display = 'none';
                    successMessage.textContent = data.message;

                    // Clear the form
                    newProductForm.reset();
                } else {
                    successMessage.style.display = 'none';
                    errorMessage.style.display = 'block';
                    errorMessage.textContent = 'Failed to add product: ' + data.message;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                const errorMessage = document.getElementById('error-message');
                errorMessage.style.display = 'block';
                errorMessage.textContent = 'Error: ' + error.message;
            });
        });
    }

    const successMessage = document.getElementById('success-message');
    const errorMessage = document.getElementById('error-message');

    if (successMessage) {
        successMessage.addEventListener('click', function() {
            successMessage.style.display = 'none';
        });
    }

    if (errorMessage) {
        errorMessage.addEventListener('click', function() {
            errorMessage.style.display = 'none';
        });
    }
});