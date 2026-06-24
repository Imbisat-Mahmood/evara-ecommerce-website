<?php
session_start();

// Define product data array (10 products)
$products = [
    46 => [
        'id' => 46,
        'name' => 'Kawaii Pencil Case',
        'price' => 300.00,
        'image' => 'Stationary/POuch s1.avif',
        'rating' => 5,
        'reviews' => 1,
        'description' => 'Cute and functional pencil case with kawaii design. Perfect for students and stationery lovers.'
    ],
    47 => [
        'id' => 47,
        'name' => '1pc Pink/White/Blue Pencil Case',
        'price' => 700.00,
        'image' => 'Stationary/pouch s2.avif',
        'rating' => 5,
        'reviews' => 3,
        'description' => 'Colorful pencil case available in pink, white, or blue. Durable material with smooth zipper.'
    ],
    48 => [
        'id' => 48,
        'name' => 'Ronaldo CR7 Black Box Pouch',
        'price' => 450.00,
        'image' => 'Stationary/pouch s3.avif',
        'rating' => 5,
        'reviews' => 2,
        'description' => 'Official Cristiano Ronaldo branded black box pouch. Perfect for CR7 fans.'
    ],
    49 => [
        'id' => 49,
        'name' => 'Multi Layer Pencil Case',
        'price' => 1000.00,
        'image' => 'Stationary/pouch 4.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Multi-compartment pencil case with separate layers for organized storage.'
    ],
    50 => [
        'id' => 50,
        'name' => 'Space Galaxy Box Pouch',
        'price' => 300.00,
        'image' => 'Stationary/pouch s5.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Space and galaxy themed box pouch with cosmic design elements.'
    ],
    51 => [
        'id' => 51,
        'name' => 'Bowknot Pen Bag',
        'price' => 700.00,
        'image' => 'Stationary/pouch s6.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Elegant pen bag with bowknot design. Perfect for gift giving.'
    ],
    52 => [
        'id' => 52,
        'name' => 'Oxford Large Capacity Pencil Pouch',
        'price' => 300.00,
        'image' => 'Stationary/pouch s7.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'High-quality Oxford fabric pencil pouch with large capacity for all your stationery.'
    ],
    53 => [
        'id' => 53,
        'name' => 'Unicorn Waterproof Transparent Zipper Pouch',
        'price' => 100.00,
        'image' => 'Stationary/pouch s8.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Transparent unicorn themed waterproof zipper pouch. See-through design for easy finding.'
    ],
    54=> [
        'id' => 54,
        'name' => 'Unicorn Waterproof Transparent Zipper Pouch',
        'price' => 100.00,
        'image' => 'Stationary/pouch s9.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Another variant of unicorn transparent zipper pouch with different design elements.'
    ],
    55 => [
        'id' => 55,
        'name' => '1Pcs Pencil Pouch',
        'price' => 700.00,
        'image' => 'Stationary/pouch s10.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Simple and practical pencil pouch for everyday use. Available in various colors.'
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
        $redirect_url = 'Pouches and Storage.php';
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
<title><?= $current_product ? htmlspecialchars($current_product['name']) . ' - Evara' : 'Pouches & Storage - Evara' ?></title>
<link rel="stylesheet" href="style.css">
<style>

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
                <a href="Pouches and Storage.php" class="back-btn">← Back to Products</a>
            </form>
        </div>
    </div>
</section>

<?php else: ?>
<!-- PRODUCT LIST (no buttons, hover to detail) -->
<section class="pouches">
    <h1>Pouches & Storage</h1>
    <p>"Organize Smarter, Carry Better 🎀"</p>
    <div class="product-grid">
        <?php foreach ($products as $id => $product): ?>
        <div class="product-card" onclick="window.location='Pouches and Storage.php?product=<?= $id ?>'">
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