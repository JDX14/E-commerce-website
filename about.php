<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@500;600&display=swap" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <link rel="stylesheet" href="CSS/style.css">
</head>

<body>
    

    <!-- HEADER -->
    <header>
        <div class="container">
            <div class="navbar">
                <a class="logo" href="index.php">
                    <img src="Logo/MSG Pic.jpeg" alt="My Supply Guy logo">My Supply Guy
                </a>
                <button class="menu-toggle">☰</button>
                <ul class="nav-list">
                    <li><a href="index.php">Home</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Products <i class="arrow down"></i>
                        </a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="cleaning.php">Cleaning</a></li>
                          <li><a class="dropdown-item" href="disposable.php">Disposables</a></li>
                        </ul>                       
                      </li>
                <button class="menu-toggle">Toggle Menu</button>
                <ul class="nav-list"></ul>
                    <li><a href="about.php">About</a></li>
                    <li><a href="login.php"> <i class="fas fa-user"></i></a></li>
                    <li><a href="cart.php"> <i class="fa fa-shopping-cart" aria-hidden="true"></i></a></li>
                </ul>
                <div>
    </header>

    <main>
        <section id="about-us">
            <h2>About Us</h2>
            <p>Welcome to My Supply Guy! We are your go-to source for high-quality disposable and cleaning products. Our mission is to provide businesses and individuals with reliable and affordable supplies to meet their daily needs. With a focus on customer satisfaction, we strive to offer a seamless shopping experience and exceptional service.</p>
        </section>

        <section id="our-products">
            <h2>Our Products</h2>
            <ul>
                <li><strong>Disposable Products:</strong> From paper to plastic, we have all your disposable needs covered.</li>
                <li><strong>Cleaning Products:</strong> Keep your space spotless with our selection of cleaning supplies, including detergents and cleaning tools.</li>
            </ul>
        </section>

        <section id="why-choose-us">
            <h2>Why Choose Us?</h2>
            <ul>
                <li><strong>Quality Assurance:</strong> We ensure all our products meet the highest quality standards.</li>
                <li><strong>Competitive Pricing:</strong> Enjoy great prices on all your supply needs.</li>
            </ul>
        </section>

        <section id="terms-and-conditions">
            <h2>Terms and Conditions</h2>
            <h3>1. Introduction</h3>
            <p>These Terms and Conditions ("Terms") govern your use of the My Supply Guy website and services. By accessing or using our website, you agree to be bound by these Terms.</p>
            
            <h3>2. Account Registration</h3>
            <p><strong>Account Information:</strong> You are responsible for providing accurate and up-to-date information during registration. You must keep your login credentials confidential.</p>
            
            <h3>3. Orders and Payments</h3>
            <p><strong>Placing Orders:</strong> All orders must be placed through our website.</p>
            <p><strong>Payment:</strong> Payment must be made via the payment details form in checkout. All payments must be made at the time of order.</p>
            
            <h3>4. Delivery</h3>
            <p><strong>Delivery Fee:</strong> A set delivery fee of R50 applies to every order, regardless of order size or value.</p>
            <p><strong>Delivery Time:</strong> We strive to deliver your order within 2 business days. Delivery times may vary based on your location and product availability.</p>
            
            <h3>5. Returns and Refunds</h3>
            <p><strong>Return Policy:</strong> If you are not satisfied with your purchase, you may return it within 7 days of receipt for a refund or exchange, provided the product is in its original condition.</p>
            <p><strong>Refunds:</strong> Refunds will be processed within 7 business days after we receive the returned product.</p>
            
            <h3>6. Use of Website</h3>
            <p><strong>Prohibited Activities:</strong> You agree not to engage in any activity that could harm the website, its users, or its content, including but not limited to hacking, data mining, or spreading malware.</p>
            <p><strong>Intellectual Property:</strong> All content on the website, including text, graphics, logos, and images, is the property of My Supply Guy or its licensors and is protected by copyright laws.</p>
            
            <h3>7. Limitation of Liability</h3>
            <p>My Supply Guy is not liable for any indirect, incidental, or consequential damages arising from your use of the website or our services.</p>
            
            <h3>8. Changes to Terms</h3>
            <p>We may update these Terms from time to time. Any changes will be posted on this page, and your continued use of the website constitutes acceptance of the updated Terms.</p>
            
            <h3>9. Contact Us</h3>
            <p>If you have any questions or concerns about these Terms, please contact us at: info@mysupplyguy.co.za</p>
            <p>By using our website, you agree to these Terms and Conditions. Thank you for shopping with My Supply Guy!</p>
        </section>
    </main>



    <!-- FOOTER SECTION -->
    <?php include('Layout/footer.php'); ?>