document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM fully loaded and parsed');

    // MENU TOGGLE
    const myMenu = document.querySelector('.menu-toggle');
    const myList = document.querySelector('.nav-list');

    if (myMenu && myList) {
        myMenu.addEventListener('click', () => {
            myMenu.classList.toggle('show');
            myList.classList.toggle('show');
        });

        let navLinks = document.querySelectorAll('.nav-list a');
        navLinks.forEach(navLink => {
            navLink.addEventListener('click', () => {
                myList.classList.remove('show');
            });
        });
    }

    /* Cart */
    // Add to cart functionality
    const addToCartButtons = document.querySelectorAll('.buy-btn');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Check if user is logged in
            fetch('Server/check_login.php')
            .then(response => response.json())
            .then(data => {
                if (data.isLoggedIn) {
                    // User is logged in, proceed to add to cart
                    const productId = button.getAttribute('data-id');
                    addToCart(productId);
                } else {
                    // User is not logged in, redirect to login page
                    window.location.href = 'login.php?redirect=' + encodeURIComponent(window.location.pathname);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });

    function addToCart(productId) {
        fetch('Server/add_to_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'product_id=' + productId,
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert(data.message);
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    // Remove from cart functionality
    const removeFromCartButtons = document.querySelectorAll('.remove-btn');
    removeFromCartButtons.forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.getAttribute('data-id');
            removeFromCart(productId);
        });
    });

    function removeFromCart(productId) {
        fetch('Server/remove_from_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `product_id=${productId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                
                location.reload(); // Reload the page after successful removal
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    // Update quantity functionality
    const quantityInputs = document.querySelectorAll('.quantity-input');
    quantityInputs.forEach(input => {
        input.addEventListener('change', function () {
            const productId = this.getAttribute('data-id');
            const newQuantity = parseInt(this.value);
            updateQuantity(productId, newQuantity);
        });
    });

    function updateQuantity(productId, newQuantity) {
        fetch('Server/update_quantity.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `product_id=${productId}&quantity=${newQuantity}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Update subtotal
                const subtotalCell = document.querySelector(`.subtotal[data-id='${productId}']`);
                const subtotal = data.subtotal;

                if (subtotalCell) {
                    subtotalCell.textContent = 'R' + parseFloat(subtotal).toFixed(2);
                }

                // Recalculate total
                updateCartTotal();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function updateCartTotal() {
        let total = 0;
        document.querySelectorAll('.subtotal').forEach(cell => {
            total += parseFloat(cell.textContent.replace('R', ''));
        });

        const deliveryFee = 50; // Delivery fee
        total += deliveryFee;

        // Update total in the cart
        const totalCell = document.querySelector('.total-fee');
        if (totalCell) {
            totalCell.textContent = 'R' + total.toFixed(2);
        }

        // Update delivery fee
        const deliveryCell = document.querySelector('.delivery-fee');
        if (deliveryCell) {
            deliveryCell.textContent = 'R' + deliveryFee.toFixed(2);
        }
    }

    // Initial total calculation on page load
    updateCartTotal();
});

    /* Payment details */
    // Prevent non-numeric input in Card Number field
    document.getElementById('card-number').addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/[^\d]/g, ''); // Replace non-numeric characters with empty string
    });


    // Prevent non-numeric input in Expiry Date field
    document.getElementById('expiry-date').addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/[^\d/]/g, ''); // Replace non-numeric characters with empty string
    });

    // Prevent non-numeric input in CVV field
    document.getElementById('cvv').addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/[^\d]/g, ''); // Replace non-numeric characters with empty string
    });

    // Add event listener for input in the expiration date field
    document.getElementById('expiry-date').addEventListener('input', function(e) {
        let input = e.target.value;
        // If user enters 2 digits, automatically add a slash
        if (input.length === 2 && input.indexOf('/') === -1) {
            input += '/';
        }
        // Update the input value
        e.target.value = input;
    });


    //Hide payment form if COD selected
    document.getElementById('cash-on-delivery').addEventListener('change', function() {
        const cardDetails = document.getElementById('card-details');
        if (this.checked) {
            cardDetails.style.display = 'none';
            document.getElementById('card-number').removeAttribute('required');
            document.getElementById('card-holder').removeAttribute('required');
            document.getElementById('expiry-date').removeAttribute('required');
            document.getElementById('cvv').removeAttribute('required');
        } else {
            cardDetails.style.display = 'block';
            document.getElementById('card-number').setAttribute('required', 'required');
            document.getElementById('card-holder').setAttribute('required', 'required');
            document.getElementById('expiry-date').setAttribute('required', 'required');
            document.getElementById('cvv').setAttribute('required', 'required');
        }
    });



 
















