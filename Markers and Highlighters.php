<?php
session_start();

// Define product data array (15 products)
$products = [
    100 => [
        'id' => 100,
        'name' => 'Dual Side Sketch Markers',
        'price' => 1300.00,
        'image' => 'Stationary/markers S1.avif',
        'rating' => 5,
        'reviews' => 1,
        'description' => 'Professional dual side sketch markers for artists and designers.'
    ],
    101 => [
        'id' => 101,
        'name' => 'High-Grade Acrylic Markers Set Of 12',
        'price' => 600.00,
        'image' => 'Stationary/MARKERS S2.avif',
        'rating' => 5,
        'reviews' => 3,
        'description' => 'High-grade acrylic markers set of 12 vibrant colors.'
    ],
    102 => [
        'id' => 102,
        'name' => '6pcs/set Pastel Color Highlighter Kawaii',
        'price' => 700.00,
        'image' => 'Stationary/Markers S3.avif',
        'rating' => 5,
        'reviews' => 2,
        'description' => 'Kawaii style pastel color highlighters set of 6 pieces.'
    ],
    103 => [
        'id' => 103,
        'name' => 'Acrylic Markers Premium Quality Acrylic Markers Set Of 12',
        'price' => 700.00,
        'image' => 'Stationary/MARker s4.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Premium quality acrylic markers set of 12 colors.'
    ],
    104 => [
        'id' => 104,
        'name' => 'WIN MARKER SET OF 12',
        'price' => 1500.00,
        'image' => 'Stationary/marker S6.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'WIN brand markers set of 12 professional colors.'
    ],
    105 => [
        'id' => 105,
        'name' => 'Dual Tip Brush Art Markers, 60 Colors',
        'price' => 1100.00,
        'image' => 'Stationary/MARKER S5.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Dual tip brush art markers with 60 different colors.'
    ],
    106 => [
        'id' => 106,
        'name' => 'Black Board Marker',
        'price' => 200.00,
        'image' => 'Stationary/MARKER S7.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Standard black board markers for whiteboards and glass.'
    ],
    107 => [
        'id' => 107,
        'name' => 'Double Line Outline Pens',
        'price' => 300.00,
        'image' => 'Stationary/Marker s8.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Double line outline pens for creative lettering and art.'
    ],
    108 => [
        'id' => 108,
        'name' => 'Ice Cream Mini Graffiti Marker',
        'price' => 200.00,
        'image' => 'Stationary/marker s9.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Ice cream shaped mini graffiti markers for fun artwork.'
    ],
    109 => [
        'id' => 109,
        'name' => 'Golden and Silver Marker',
        'price' => 300.00,
        'image' => 'Stationary/marker s10avif.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Metallic golden and silver markers for decorative work.'
    ],
    110 => [
        'id' => 110,
        'name' => 'Cute Sanrio Fluorescent Highlighter Set Of 6',
        'price' => 350.00,
        'image' => 'Stationary/marker s11.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Sanrio character fluorescent highlighters set of 6.'
    ],
     111 => [
        'id' => 111,
        'name' => 'Large Capacity Pastel Colors Highlighters And Markers',
        'price' => 800.00,
        'image' => 'Stationary/marker s12.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Large capacity pastel color highlighters and markers set.'
    ],
    112 => [
        'id' => 112,
        'name' => '6pcs Soft Brush Fluorescence Pen Set',
        'price' => 200.00,
        'image' => 'Stationary/marker s13.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Soft brush fluorescence pen set of 6 colors.'
    ],
    113 => [
        'id' => 113,
        'name' => '3pc / 6pc Creative Highlighter Curve Pen Quick',
        'price' => 550.00,
        'image' => 'Stationary/marker s14.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Creative highlighter curve pens available in 3 or 6 pieces.'
    ],
    114 => [
        'id' => 114,
        'name' => 'Giorgione Dual Tip Watercolor Brush Pen And Fineliner Marker For Art, Sketching',
        'price' => 1000.00,
        'image' => 'Stationary/marker s15.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Giorgione dual tip watercolor brush pen and fineliner marker set.'
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
                'id' => $product_id,  
                'name' => $products[$product_id]['name'],
                'price' => $products[$product_id]['price'],
                'image' => $products[$product_id]['image'],
                'quantity' => $quantity
            ];
        }
        
        // Redirect to prevent form resubmission
        $redirect_url = 'Markers and Highlighters.php';
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
<title><?= $current_product ? htmlspecialchars($current_product['name']) . ' - Evara' : 'Markers & Highlighters - Evara' ?></title>
<link rel="stylesheet" href="style.css">
<style>
/* Additional CSS for hover redirect and pink buttons */

</style>
</head>
<body>

<h3>FREE SHIPPING on Orders above Rs. 2999/-</h3>

<!-- Navigation -->
<div id="navbar">
    <a href="index.php"><img src="images/logo 1.png" alt="Evara Logo" class="logo"></a>
    <div class="menu">
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

    <div class="icons">
        <div class="search-container">
            <form method="GET" action="search.php" class="search-form">
                <input type="text" name="q" placeholder="Search products..." class="search-input" autocomplete="off">
                <button type="submit" class="search-btn">🔍</button>
            </form>
        </div>
        <a href="sigin.php" title="Account"><i class="fas fa-user"></i></a>
        <a href="cart.php" title="Cart">🛒 <?= $cart_count > 0 ? '(' . $cart_count . ')' : ''; ?></a>
    </div>
</div>

<?php if ($current_product): ?>
<!-- PRODUCT DETAIL -->
<section class="product-detail">
    <div class="detail-container">
        <div class="detail-image">
            <img src="<?= htmlspecialchars($current_product['image']); ?>" alt="<?= htmlspecialchars($current_product['name']); ?>">
        </div>
        <div class="detail-info">
            <h1><?= htmlspecialchars($current_product['name']); ?></h1>
            <p class="price">Rs.<?= number_format($current_product['price'], 2); ?> PKR</p>
            <p class="description"><?= htmlspecialchars($current_product['description']); ?></p>

            <form method="POST" class="add-to-cart-form">
                <input type="hidden" name="product_id" value="<?= htmlspecialchars($current_product['id']); ?>">
                <div class="quantity-selector">
                    <label for="quantity">Qty:</label>
                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="10">
                </div>
                <button type="submit" name="add_to_cart" class="add-to-cart-btn">Add to Cart</button>
                <a href="Markers and Highlighters.php" class="back-btn">← Back to Products</a>
            </form>
        </div>
    </div>
</section>

<?php else: ?>
<!-- PRODUCT LIST (no buttons, hover to detail) -->
<section class="markers-colors">
    <h1>Markers & Highlighters</h1>
    <p>"📚 Study Smart, Create Brighter"</p>
    <div class="product-grid">
        <?php foreach ($products as $id => $product): ?>
        <div class="product-card" onclick="window.location='Markers and Highlighters.php?product=<?= $id ?>'">
            <img src="<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
            <h3><?= htmlspecialchars($product['name']); ?></h3>
            <p class="price">Rs.<?= number_format($product['price'], 2); ?> PKR</p>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

</body>
</html>