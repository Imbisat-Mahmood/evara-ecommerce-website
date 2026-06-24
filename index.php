<?php
session_start();

// Calculate cart items count
$cart_count = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    $cart_count = count($_SESSION['cart']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evara - Home</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Fix for slider issues -->
    <style>
        /* Remove extra logo below slider */
        
    </style>

</head>
<body>

    <!-- Offer Bar -->
    <h3>FREE SHIPPING on Orders above Rs. 2999/-</h3>

    <!-- Navigation Bar with Search -->
    <div id="navbar">
        <!-- Logo -->
        <a href="index.php">
            <img src="images/logo 1.png" alt="Evara Logo" class="logo">
        </a>

        <!-- Menu Links -->
        <div class="menu">
            <!-- Stationery Dropdown -->
            <nav class="navbar">
                <ul>
                    <li class="dropdown">
                        <a href="#"><span>✏️</span> Stationery</a>
                        <ul class="dropdown-menu">
                            <li><a href="Pen and Pencils.php">Pen and Pencils</a></li>
                            <li><a href="Paints and Colors.php">Paints and Colors</a></li>
                            <li><a href="Markers and Highlighters.php">Markers and Highlighters</a></li>
                            <li><a href="Notebooks and Diaries.php">Notebooks and Diaries</a></li>
                            <li><a href="Cutters and Staplers.php">Cutters and Staplers</a></li>
                            <li><a href="Pouches and Storage.php">Pouches and Storage</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>

            <!-- Bag Bliss Dropdown -->
            <nav class="navbar">
                <ul>
                    <li class="dropdown">
                        <a href="#">👜 Bag Bliss</a>
                        <ul class="dropdown-menu">
                            <li><a href="tote-bags.php">Tote Bags</a></li>
                            <li><a href="shoulder-bags.php">Shoulder Bags</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>

            <!-- Elite Bottle Dropdown -->
            <nav class="navbar">
                <ul>
                    <li class="dropdown">
                        <a href="#"><span>✨</span> Elite Bottles</a>
                        <ul class="dropdown-menu">
                            <li><a href="Water Bottle.php">Water Bottles</a></li>
                            <li><a href="Tumbler.php">Tumblers</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>

            <a href="New Arrival.php"><span>🆕</span> New Arrivals</a>
           
        </div>

        <!-- Icons with Search Bar -->
        <div class="icons">
            <!-- Search Form -->
            <div class="search-container">
        <form method="GET" action="search.php" class="search-form">
            <input type="text" name="q" placeholder="Search products..." class="search-input" autocomplete="off">
            <button type="submit" class="search-btn">🔍</button>
        </form>
    </div>


<!-- Profile Dropdown -->
<div class="dropdown profile-dropdown">
    <a href="#" class="profile-icon">
        <i class="fas fa-user"></i>
    </a>
    <ul class="dropdown-menu profile-menu">
        <?php if (isset($_SESSION['user'])): ?>
            <!-- Logged In - Show Logout -->
            <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
            <!-- Logged Out - Show Login -->
            <li><a href="login.php">Login</a></li>
        <?php endif; ?>
    </ul>
</div>



            <a href="cart.php" title="Cart">🛒 <?php echo $cart_count > 0 ? '(' . $cart_count . ')' : ''; ?></a>
        </div>
    </div>

    <!-- Banner Section - Clean Swiper Slider -->
    <section class="banner">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                
                <!-- Slide 1 -->
                <div class="swiper-slide">
                    <img src="images/cry.jpg" alt="Fresh Arrivals">
                    <div class="slide1-text">
                        <h1>Fresh Arrivals</h1>
                        <p>Discover new collections now!</p>
                    </div>
                    <div class="logo-overlay">
                        <img src="images/logo 1.png" alt="Logo">
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="swiper-slide">
                    <img src="images/diarybg.jpg" alt="Diary">
                    <div class="slide2-text">
                        <h1>Write, Draw, Dream</h1>
                        <p>We've Got You Covered</p>
                    </div>
                    <div class="logo-overlay">
                        <img src="images/logo 1.png" alt="Logo">
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="swiper-slide">
                    <img src="images/colors.jpg" alt="Colors">
                    <div class="slide3-text">
                        <h1>Your Go-To Bag</h1>
                        <p>Just a click away...</p>
                    </div>
                    <div class="logo-overlay">
                        <img src="images/logo 1.png" alt="Logo">
                    </div>
                </div>
                
                <!-- Slide 4 -->
                <div class="swiper-slide">
                    <img src="images/BLUE (2).png" alt="Stationery">
                    <div class="slide4-text">
                        <h1>Where Ideas Meet Quality Stationery</h1>
                        <p>Shop Now</p>
                    </div>
                    <div class="logo-overlay">
                        <img src="images/logo 1.png" alt="Logo">
                    </div>
                </div>

                <!-- Slide 5 -->
                <div class="swiper-slide">
                    <img src="images/pasd.png" alt="Paper">
                    <div class="slide5-text">
                        <h1>For the Love of Paper</h1>
                        <p>Pens, and Possibilities.</p>
                    </div>
                    <div class="logo-overlay">
                        <img src="images/logo 1.png" alt="Logo">
                    </div>
                </div>
            </div>

            <!-- Pagination & Navigation -->
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </section>

    <!-- Featured Picks Section -->
    <section class="picks-section">
        <div class="picks-section">
            <div class="picks-grid">
                <a href="New Arrival.php" class="pick-box pink">
                    <img src="images/Aug .webp" alt="August">
                </a>

                <a href="Notebooks and Diaries.php" class="pick-box">
                    <img src="images/Notebooks.webp" alt="Notebook">
                </a>

                <a href="Pouches and Storage.php" class="pick-box">
                    <img src="images/pouch.webp" alt="Pouch">
                </a>

                <a href="Water Bottle.php" class="pick-box">
                    <img src="images/WB.webp" alt="Water Bottle">
                </a>
            </div>

            <!-- Bottom row -->
            <div class="boxes-container">
                <div class="bottom-row">
                    <a href="Pen and Pencils.php" class="pens-box">
                        <h2>Pens Collection</h2>
                    </a>

                    <a href="Sale.php" class="deal-box">
                        <h2>DEALS</h2>
                        <h4>Upto 40% off</h4>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Deals and Bundles Section -->
    <section class="deals-section">
        <h2 class="section-title">DEALS AND BUNDLES</h2>
        <div class="product-grid">
            <!-- Product 1 -->
            <div class="product-card">
                <img src="images/MARKER d .webp" alt="Premium Paint Marker">
                <h3>Premium Paint Marker - set of 12</h3>
                <div class="rating">
                    <?php for($i=1; $i<=5; $i++): ?>
                        <span class="star">★</span>
                    <?php endfor; ?>
                    <span>(1)</span>
                </div>
                <p class="price">Rs.2,400.00 PKR</p>
            </div>

            <!-- Product 2 -->
            <div class="product-card">
                <img src="images/kawai d.webp" alt="Pencil Case Bundle">
                <h3>Transparent Pencil Case with Pens Bundle</h3>
                <div class="rating">
                    <?php for($i=1; $i<=5; $i++): ?>
                        <span class="star">★</span>
                    <?php endfor; ?>
                    <span>(3)</span>
                </div>
                <p class="price">Rs.2,500.00 PKR</p>
            </div>

            <!-- Product 3 -->
            <div class="product-card">
                <img src="images/panda d.jpg" alt="Panda Pencil Case">
                <h3>Panda Pencil Case with Stationery Bundle</h3>
                <div class="rating">
                    <?php for($i=1; $i<=5; $i++): ?>
                        <span class="star">★</span>
                    <?php endfor; ?>
                    <span>(2)</span>
                </div>
                <p class="price">Rs.2,400.00 PKR</p>
            </div>

            <!-- Product 4 -->
            <div class="product-card">
                <img src="images/diaryyyy d.webp" alt="Unicorn Diary deal">
                <h3>Unicorn Diary Deal</h3>
                <div class="rating">
                    <?php for($i=1; $i<=5; $i++): ?>
                        <span class="star">★</span>
                    <?php endfor; ?>
                    <span>(4)</span>
                </div>
                <p class="old-price">Rs.1,800.00 PKR</p>
                <p class="new-price">Rs.1,300.00 PKR</p>
            </div>
        </div>

        <div class="show-more-container">
            <a href="Sale.php" class="show-more-btn">Show More</a>
        </div>
    </section>

    <!-- Tote & Shoulder Bags Section -->
    <section class="bags-section">
        <h2 class="section-title">TOTE & SHOULDER BAGS</h2>
        <div class="product-grid">
            <!-- Bag 1 -->
            <div class="product-card">
                <img src="images/3 colors B.webp" alt="Classic Tote Bag">
                <h3>Three-Color Stripes Contrast Handmade Shoulder Bag</h3>
                <div class="rating">
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star half">½</span>
                    <span>(12)</span>
                </div>
                <p class="price">Rs.1,800.00 PKR</p>
            </div>

            <!-- Bag 2 -->
            <div class="product-card">
                <div class="tag sale">Sale</div>
                <img src="images/Blossom b.webp" alt="Shoulder Bag">
                <h3>Van Gogh Almond Blossoms European Tote Bag</h3>
                <div class="rating">
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star empty">☆</span>
                    <span>(7)</span>
                </div>
                <p class="price">Rs.2,500.00 PKR</p>
            </div>

            <!-- Bag 3 -->
            <div class="product-card">
                <img src="images/Cities b.webp" alt="Trendy Tote">
                <h3>Cities of the World Jute Boxed Tote Bag</h3>
                <div class="rating">
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star empty">☆</span>
                    <span class="star empty">☆</span>
                    <span>(5)</span>
                </div>
                <p class="price">Rs.2,200.00 PKR</p>
            </div>

            <!-- Bag 4 -->
            <div class="product-card">
                <img src="images/Tote b.webp" alt="Leather Shoulder Bag">
                <h3>High Quality Canvas Boxed Tote and Shoulder Bag</h3>
                <div class="rating">
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star half">½</span>
                    <span class="star empty">☆</span>
                    <span>(3)</span>
                </div>
                <p class="price">Rs.3,200.00 PKR</p>
            </div>
        </div>

        <div class="show-more-container">
            <a href="tote-bags.php" class="show-more-btn">Show More</a>
        </div>
    </section>

    <!-- Mini Fans Section -->
    <section class="fans-section">
        <h2 class="section-title">MINI FANS</h2>
        <div class="product-grid">
            <!-- Fan 1 -->
            <div class="product-card">
                <img src="images/Dora F.webp" alt="USB Desk Fan">
                <h3>Doraemon & Lotso Handheld - Portable Fan</h3>
                <div class="rating">
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star half">½</span>
                    <span class="star empty">☆</span>
                    <span>(18)</span>
                </div>
                <p class="price">Rs.1,200.00 PKR</p>
            </div>

            <!-- Fan 2 -->
            <div class="product-card">
                <div class="tag sale">Sale</div>
                <img src="images/Sanrio.webp" alt="Handheld Fan">
                <h3>Rechargeable Handheld Mini Fan</h3>
                <div class="rating">
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star empty">☆</span>
                    <span class="star empty">☆</span>
                    <span>(10)</span>
                </div>
                <p class="price">Rs.1,600.00 PKR</p>
            </div>

            <!-- Fan 3 -->
            <div class="product-card">
                <img src="images/Avenger F.webp" alt="Cute Mini Fan">
                <h3>Avengers Super Heroes Handheld - Portable Fan</h3>
                <div class="rating">
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star half">½</span>
                    <span class="star empty">☆</span>
                    <span class="star empty">☆</span>
                    <span>(6)</span>
                </div>
                <p class="price">Rs.950.00 PKR</p>
            </div>

            <!-- Fan 4 -->
            <div class="product-card">
                <img src="images/Pur F.webp" alt="Clip-on Fan">
                <h3>Rechargeable Clip-on Fan</h3>
                <div class="rating">
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star empty">☆</span>
                    <span>(22)</span>
                </div>
                <p class="price">Rs.1,500.00 PKR</p>
            </div>
        </div>

        <div class="show-more-container">
            <a href="fans.php" class="show-more-btn">✨ Show More</a>
        </div>
    </section>

    <!-- Stationery Section -->
    <section class="stationery-section">
        <h2 class="section-title">STATIONERY</h2>
        <div class="product-grid">
            <!-- Product 1 -->
            <div class="product-card">
                <img src="images/High .webp" alt="Highlighter">
                <h3>Color Art Glitter Dual - Highlighter</h3>
                <div class="rating">
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star empty">☆</span>
                    <span>(8)</span>
                </div>
                <p class="price">Rs.450.00 PKR</p>
            </div>

            <!-- Product 2 -->
            <div class="product-card">
                <div class="tag sale">Sale</div>
                <img src="images/Glitter S.webp" alt="Gel Pen">
                <h3>Metallic Colors - Gel Pen Set Of 6 / 12</h3>
                <div class="rating">
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star empty">☆</span>
                    <span class="star empty">☆</span>
                    <span>(5)</span>
                </div>
                <p class="price">Rs.300.00 PKR</p>
            </div>

            <!-- Product 3 -->
            <div class="product-card">
                <img src="images/Scissors S.webp" alt="Scissor">
                <h3>DL Kawai Girl - Scissor</h3>
                <div class="rating">
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star empty">☆</span>
                    <span class="star empty">☆</span>
                    <span>(3)</span>
                </div>
                <p class="price">Rs.650.00 PKR</p>
            </div>

            <!-- Product 4 -->
            <div class="product-card">
                <img src="images/erasers S.webp" alt="Eraser Set">
                <h3>Sanrio Characters Popsicle - Magic Eraser and Sharpener Set</h3>
                <div class="rating">
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star half">½</span>
                    <span class="star empty">☆</span>
                    <span class="star empty">☆</span>
                    <span>(12)</span>
                </div>
                <p class="price">Rs.350.00 PKR</p>
            </div>
        </div>

        <div class="show-more-container">
            <a href="Pen and Pencils.php" class="show-more-btn">Show More</a>
        </div>
    </section>

    <!-- Our Collection Section -->
    <section class="collection-section">
        <h2 class="section-title">OUR COLLECTION</h2>
        <div class="product-grid">
            <!-- Collection 1 -->
            <div class="product-card">
                <a href="Pen and Pencils.php">
                    <img src="images/pen and p OC.jpg" alt="Stationery Collection">
                    <h3>Pen and Pencils</h3>
                </a>
            </div>

            <!-- Collection 2 -->
            <div class="product-card">
                <a href="Markers and Highlighters.php">
                    <img src="images/markers.webp" alt="Markers Collection">
                    <h3>Markers</h3>
                </a>
            </div>

            <!-- Collection 3 -->
            <div class="product-card">
                <a href="Notebooks and Diaries.php">
                    <img src="images/Notebooks and Diaries.webp" alt="Notebooks Collection">
                    <h3>Notebook and Diaries</h3>
                </a>
            </div>

            <!-- Collection 4 -->
            <div class="product-card">
                <a href="tote-bags.php">
                    <img src="images/Bag a P OC.webp" alt="Bags Collection">
                    <h3>Bags and Pouches</h3>
                </a>
            </div>

            <!-- Collection 5 -->
            <div class="product-card">
                <a href="Water Bottle.php">
                    <img src="images/Water B OC.webp" alt="Bottles Collection">
                    <h3>Bottles</h3>
                </a>
            </div>

            <!-- Collection 6 -->
            <div class="product-card">
                <a href="fans.php">
                    <img src="images/Fans OC.webp" alt="Fans Collection">
                    <h3>Portable Mini Fans</h3>
                </a>
            </div>

            <!-- Collection 7 -->
            <div class="product-card">
                <a href="Cutters and Staplers.php">
                    <img src="images/cutters OC.webp" alt="Cutters Collection">
                    <h3>Cutters and Staplers</h3>
                </a>
            </div>

            <!-- Collection 8 -->
            <div class="product-card">
                <a href="Paints and Colors.php">
                    <img src="Stationary/PAINT S3.avif" alt="Gift Collection">
                    <h3>Paint Items</h3>
                </a>
            </div>
        </div>
    </section>
 

    <div class="footer">
        <div class="footer-section">
            <h3>About Evara</h3>
            <p>Evara is where ideas take shape. From planners to notebooks, we create 
            stationery that inspires creativity and keeps you organized every day.</p>
        </div>

        <div class="footer-section">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#">Shop</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h3>Customer Care</h3>
            <ul>
                <li><a href="#">FAQs</a></li>
                <li><a href="#">Shipping & Returns</a></li>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Terms & Conditions</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h3>Connect With Us</h3>
            <ul>
                <li>📧 hello@evara.com</li>
                <li>📞 +92 300 1234567</li>
            </ul>
        </div>
    </div>
    
    <p class="copyright">© 2025 Evara. All rights reserved.</p>

    <!-- Swiper JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const swiper = new Swiper('.mySwiper', {
                // Core settings
                loop: true,
                speed: 800,
                slidesPerView: 1,
                spaceBetween: 0,
                
                // Auto-play (4 seconds)
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
                
                // Pagination dots
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                    dynamicBullets: true,
                },
                
                // Navigation arrows
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                
                // Fade effect
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                
                // Keyboard control
                keyboard: {
                    enabled: true,
                }
            });
            
            // Pause on hover
            const slider = document.querySelector('.mySwiper');
            slider.addEventListener('mouseenter', function() {
                swiper.autoplay.stop();
            });
            
            slider.addEventListener('mouseleave', function() {
                swiper.autoplay.start();
            });
        });
    </script>
       

</body>
</html>