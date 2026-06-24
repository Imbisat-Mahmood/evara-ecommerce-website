<?php
session_start();

// Normally you would load products from a database
// For now, we'll create a sample product array
$products = [
    1 => [
        'id' => 1,
        'name' => 'Sample Product 1',
        'price' => 1500.00,
        'image' => 'images/product1.jpg',
        'description' => 'This is a sample product description. High quality materials used.',
        'rating' => 4.5,
        'reviews' => 12,
        'category' => 'Stationery'
    ],
    2 => [
        'id' => 2,
        'name' => 'Sample Product 2',
        'price' => 2500.00,
        'image' => 'images/product2.jpg',
        'description' => 'Another sample product with detailed description.',
        'rating' => 4.0,
        'reviews' => 8,
        'category' => 'Bags'
    ]
];

// Handle Add to Cart
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    
    if (isset($products[$product_id])) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = [
                'name' => $products[$product_id]['name'],
                'price' => $products[$product_id]['price'],
                'image' => $products[$product_id]['image'],
                'quantity' => $quantity
            ];
        }
        
        // Redirect to prevent form resubmission
        header('Location: product.php?id=' . $product_id);
        exit();
    }
}

// Get product ID from URL
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get current product
$current_product = null;
if ($product_id > 0 && isset($products[$product_id])) {
    $current_product = $products[$product_id];
}

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
    <title><?php 
        if ($current_product) {
            echo htmlspecialchars($current_product['name']) . ' - Evara';
        } else {
            echo 'Product Details - Evara';
        }
    ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Offer Bar -->
<h3>FREE SHIPPING on Orders above Rs. 2999/-</h3>

<!-- Navigation Bar -->
<div id="navbar">
    <!-- Logo (clickable to go home) -->
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
                    <input type="text" name="q" placeholder="Search products..." 
                           class="search-input" autocomplete="off">
                    <button type="submit" class="search-btn">🔍</button>
                </form>
            </div>
            
            <a href="sigin.php" title="Account"><i class="fas fa-user"></i></a>
            <a href="cart.php" title="Cart">🛒 <?php echo $cart_count > 0 ? '(' . $cart_count . ')' : ''; ?></a>
        </div>
    </div>

<div id="product-details">
    <?php if ($current_product): ?>
    <div class="product-detail-card">
        <div class="detail-container">
            <div class="detail-image">
                <img src="<?php echo htmlspecialchars($current_product['image']); ?>" alt="<?php echo htmlspecialchars($current_product['name']); ?>">
            </div>
            <div class="detail-info">
                <h1><?php echo htmlspecialchars($current_product['name']); ?></h1>
                
                <div class="rating">
                    <?php 
                    // Show stars based on rating
                    $full_stars = floor($current_product['rating']);
                    $has_half = ($current_product['rating'] - $full_stars) >= 0.5;
                    
                    for($i = 1; $i <= 5; $i++) {
                        if ($i <= $full_stars) {
                            echo '<span class="star">★</span>';
                        } elseif ($i == $full_stars + 1 && $has_half) {
                            echo '<span class="star half">½</span>';
                        } else {
                            echo '<span class="star empty">☆</span>';
                        }
                    }
                    ?>
                    <span class="review-count">(<?php echo $current_product['reviews']; ?> reviews)</span>
                </div>
                
                <p class="price">Rs.<?php echo number_format($current_product['price'], 2); ?> PKR</p>
                
                <?php if (isset($current_product['category'])): ?>
                    <p class="category"><strong>Category:</strong> <?php echo htmlspecialchars($current_product['category']); ?></p>
                <?php endif; ?>
                
                <p class="description"><?php echo nl2br(htmlspecialchars($current_product['description'])); ?></p>
                
                <form method="POST" action="" class="add-to-cart-form">
                    <input type="hidden" name="product_id" value="<?php echo $current_product['id']; ?>">
                    <div class="quantity-selector">
                        <label for="quantity">Quantity:</label>
                        <input type="number" name="quantity" id="quantity" value="1" min="1" max="10">
                    </div>
                    <button type="submit" name="add_to_cart" class="buy-btn">
                        Add to Cart
                    </button>
                </form>
                
                <div class="product-meta">
                    <p><strong>Free Shipping:</strong> On orders above Rs. 2999/-</p>
                    <p><strong>Delivery:</strong> 3-5 business days</p>
                    <p><strong>Return Policy:</strong> 7 days return accepted</p>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="product-not-found">
        <h2>Product Not Found</h2>
        <p>The product you are looking for does not exist or has been removed.</p>
        <a href="index.php" class="back-to-home">← Back to Home</a>
    </div>
    <?php endif; ?>
</div>

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

</body>
</html>