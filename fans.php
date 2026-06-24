<?php
session_start();

// Define product data array (10 products)
$products = [
    'fan1' => [
        'id' => 'fan1',
        'name' => 'Doraemon & Lotso Handheld - Portable Fan',
        'price' => 1200.00,
        'image' => 'images/Dora F.webp',
        'rating' => 4.5,
        'reviews' => 18,
        'description' => 'Doraemon and Lotso themed handheld portable fan. Perfect for summer heat.'
    ],
    'fan2' => [
        'id' => 'fan2',
        'name' => 'Rechargeable Handheld Mini Fan',
        'price' => 1600.00,
        'image' => 'images/Sanrio.webp',
        'rating' => 3.0,
        'reviews' => 10,
        'description' => 'Sanrio character rechargeable handheld mini fan. USB charging available.',
        'sale' => true
    ],
    'fan3' => [
        'id' => 'fan3',
        'name' => 'Avengers Super Heroes Handheld - Portable Fan',
        'price' => 950.00,
        'image' => 'images/Avenger F.webp',
        'rating' => 2.5,
        'reviews' => 6,
        'description' => 'Avengers superheroes themed handheld portable fan. Cool design for Marvel fans.'
    ],
    'fan4' => [
        'id' => 'fan4',
        'name' => 'Rechargeable Clip-on Fan',
        'price' => 1500.00,
        'image' => 'images/Pur F.webp',
        'rating' => 4.0,
        'reviews' => 22,
        'description' => 'Rechargeable clip-on fan. Can be attached to desks, beds, or strollers.'
    ],
    'fan5' => [
        'id' => 'fan5',
        'name' => 'Sanrio Character Handheld - Portable Fan',
        'price' => 1100.00,
        'image' => 'Stationary/fan 5.webp',
        'rating' => 4.5,
        'reviews' => 18,
        'description' => 'Sanrio characters themed handheld portable fan. Cute and functional.'
    ],
    'fan6' => [
        'id' => 'fan6',
        'name' => 'Sanrio Characters - Portable Neck Fan',
        'price' => 2200.00,
        'image' => 'Stationary/Fan6.webp',
        'rating' => 4.5,
        'reviews' => 18,
        'description' => 'Sanrio characters portable neck fan. Wearable design for hands-free cooling.'
    ],
    'fan7' => [
        'id' => 'fan7',
        'name' => 'Colorful Rainbow Fruit-Portable Fan',
        'price' => 1200.00,
        'image' => 'Stationary/fan7.webp',
        'rating' => 4.5,
        'reviews' => 18,
        'description' => 'Colorful rainbow fruit themed portable fan. Vibrant and refreshing design.'
    ],
    'fan8' => [
        'id' => 'fan8',
        'name' => 'Cute Cat & Paw Handheld Fan',
        'price' => 1600.00,
        'image' => 'Stationary/fan8.webp',
        'rating' => 4.5,
        'reviews' => 18,
        'description' => 'Cute cat and paw print design handheld fan. Adorable and effective.'
    ],
    'fan9' => [
        'id' => 'fan9',
        'name' => 'Portable Handheld Fan',
        'price' => 1500.00,
        'image' => 'Stationary/fan11.webp',
        'rating' => 4.5,
        'reviews' => 18,
        'description' => 'Standard portable handheld fan with multiple speed settings.'
    ],
    'fan10' => [
        'id' => 'fan10',
        'name' => 'Lotso Handheld - Portable Fan',
        'price' => 2000.00,
        'image' => 'Stationary/FAN 10.webp',
        'rating' => 4.5,
        'reviews' => 18,
        'description' => 'Lotso bear themed handheld portable fan. Soft and huggable design.'
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
        $redirect_url = 'fans.php';
        if (isset($_GET['product'])) {
            $redirect_url .= '?product=' . $_GET['product'];
        }
        header('Location: ' . $redirect_url);
        exit();
    }
}

// Get current product for detail view
$current_product = null;
if (isset($_GET['product']) && isset($products[$_GET['product']])) {
    $current_product = $products[$_GET['product']];
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
            echo 'Portable Mini Fans - Evara';
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
                        <li><a href="pens-and-pencils.php">Pen and Pencils</a></li>
                        <li><a href="paints-and-colors.php">Paints and Colors</a></li>
                        <li><a href="markers-and-highlighters.php">Markers and Highlighters</a></li>
                        <li><a href="notebooks-and-diaries.php">Notebooks and Diaries</a></li>
                        <li><a href="cutters-and-staplers.php">Cutters and Staplers</a></li>
                        <li><a href="pouches-and-storage.php">Pouches and Storage</a></li>
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
                        <li><a href="water-bottle.php">Water Bottles</a></li>
                        <li><a href="tumbler.php">Tumblers</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    
        <a href="new-arrival.php"><span>🆕</span> New Arrivals</a>
        <a href="sale.php"><span>💖</span> Sale</a>
    </div>
    
    <!-- Icons (Search, Profile, Wishlist, Cart) -->
    <div class="icons">
        <a href="#">🔍</a>
        <a href="#">👤</a>
        <a href="#">❤️</a>
        <a href="cart.php">🛒 <?php echo $cart_count > 0 ? '(' . $cart_count . ')' : ''; ?></a>
    </div>
</div>

<?php if ($current_product): ?>
<!-- PRODUCT DETAIL VIEW -->
<section class="product-detail">
    <div class="detail-container">
        <div class="detail-image">
            <?php if (isset($current_product['sale']) && $current_product['sale']): ?>
                <div class="tag sale">Sale</div>
            <?php endif; ?>
            <img src="<?php echo htmlspecialchars($current_product['image']); ?>" alt="<?php echo htmlspecialchars($current_product['name']); ?>">
        </div>
        <div class="detail-info">
            <h1><?php echo htmlspecialchars($current_product['name']); ?></h1>
            <div class="rating">
                <?php 
                // Show full stars
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
            <p class="description"><?php echo htmlspecialchars($current_product['description']); ?></p>
            
            <form method="POST" action="" class="add-to-cart-form">
                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($current_product['id']); ?>">
                <div class="quantity-selector">
                    <label for="quantity">Quantity:</label>
                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="10">
                </div>
                <button type="submit" name="add_to_cart" class="add-to-cart-btn">
                    Add to Cart
                </button>
                <a href="fans.php" class="back-btn">← Back to Products</a>
            </form>
        </div>
    </div>
</section>

<?php else: ?>
<!-- PRODUCT LISTING VIEW -->
<section class="cutters">
    <h1>Portable Mini Fans</h1>
    <p>Cool comfort in your hands 🍃</p>
    
    <div id="fans-products" class="product-grid">
        <?php foreach ($products as $id => $product): ?>
        <div class="product-card">
            <?php if (isset($product['sale']) && $product['sale']): ?>
                <div class="tag sale">Sale</div>
            <?php endif; ?>
            
            <a href="?product=<?php echo $id; ?>">
                <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            </a>
            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
            <div class="rating">
                <?php 
                // Show full stars
                $full_stars = floor($product['rating']);
                $has_half = ($product['rating'] - $full_stars) >= 0.5;
                
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
                <span class="review-count">(<?php echo $product['reviews']; ?>)</span>
            </div>
            <p class="price">Rs.<?php echo number_format($product['price'], 2); ?> PKR</p>
            
            <div class="product-actions">
                <a href="?product=<?php echo $id; ?>" class="view-details-btn">View Details</a>
                <form method="POST" action="" class="quick-add-form">
                    <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                    <button type="submit" name="add_to_cart" class="quick-add-btn" title="Add to Cart">
                        Add to Cart
                    </button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

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