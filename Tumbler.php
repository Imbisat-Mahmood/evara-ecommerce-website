<?php
session_start();

// Define product data array (10 products)
$products = [
    21 => [  // ← CHANGED: '21' to 21 (numeric key)
        'id' => 21,  // ← CHANGED: '21' to 21 (numeric ID)
        'name' => 'Premium Stainless Steel Tumblers',
        'price' => 6000.00,
        'image' => 'Stationary/tumbler w2.avif',
        'rating' => 5,
        'reviews' => 1,
        'description' => 'Stylish, durable, and travel-friendly stainless steel tumblers.'
    ],
    22 => [  // ← CHANGED: '22' to 22 (numeric key)
        'id' => 22,  // ← CHANGED: '22' to 22 (numeric ID)
        'name' => 'Stainless Steel Straw with Silicone Tip',
        'price' => 7000.00,
        'image' => 'Stationary/tumbler w4.avif',
        'rating' => 5,
        'reviews' => 3,
        'description' => 'Premium stainless steel straw with soft silicone tip for comfortable drinking.'
    ],
    23 => [  // ← CHANGED: '23' to 23 (numeric key)
        'id' => 23,  // ← CHANGED: '23' to 23 (numeric ID)
        'name' => 'Stanley Tumbler - 40oz',
        'price' => 6500.00,
        'image' => 'Stationary/tumbler w3.avif',
        'rating' => 5,
        'reviews' => 2,
        'description' => 'Classic Stanley tumbler with 40oz capacity. Perfect for all-day hydration.'
    ],
    24 => [  // ← CHANGED: '24' to 24 (numeric key)
        'id' => 24,  // ← CHANGED: '24' to 24 (numeric ID)
        'name' => '40oz Insulated Tumbler Thermos Flask',
        'price' => 7500.00,
        'image' => 'Stationary/tumbler w5.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Insulated thermos flask with straw and lid. Keeps drinks at perfect temperature.'
    ],
    25 => [  // ← CHANGED: '25' to 25 (numeric key)
        'id' => 25,  // ← CHANGED: '25' to 25 (numeric ID)
        'name' => 'Stanley Tumbler with Straw & Lid',
        'price' => 6600.00,
        'image' => 'Stationary/tumbler w8.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Insulated tumbler thermos flask with straw and lid - Stanley style.'
    ]
];

// Handle Add to Cart
if (isset($_POST['add_to_cart'])) {
    $product_id = (int)$_POST['product_id'];  // ← CHANGED: Added (int) cast
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    
    if (isset($products[$product_id])) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = [
                'id' => $product_id,  // ← KEPT: 'id' field
                'name' => $products[$product_id]['name'],
                'price' => $products[$product_id]['price'],
                'image' => $products[$product_id]['image'],
                'quantity' => $quantity
            ];
        }
        
        // Redirect to prevent form resubmission
        $redirect_url = 'tumbler.php';
        if (isset($_GET['product'])) {
            $redirect_url .= '?product=' . (int)$_GET['product'];  // ← CHANGED: Added (int) cast
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
<title><?= $current_product ? htmlspecialchars($current_product['name']) . ' - Evara' : 'Tumblers - Evara' ?></title>
<link rel="stylesheet" href="style.css">
<style>
/* Additional CSS for hover redirect and pink buttons */

</style>
</head>
<body>

<h3>FREE SHIPPING on Orders above Rs. 2999/-</h3>

<!-- Navigation (fixed file names) -->
<div id="navbar">
    <a href="index.php"><img src="images/logo 1.png" alt="Evara Logo" class="logo"></a>
    <div class="menu">
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
        <a href="new-arrival.php"><span>🆕</span> New Arrivals</a>
    </div>

    <div class="icons">
        <div class="search-container">
            <form method="GET" action="search.php" class="search-form">
                <input type="text" name="q" placeholder="Search products..." class="search-input" autocomplete="off">
                <button type="submit" class="search-btn">🔍</button>
            </form>
        </div>
        <a href="signin.php" title="Account"><i class="fas fa-user"></i></a>
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
                <a href="tumbler.php" class="back-btn">← Back to Products</a>
            </form>
        </div>
    </div>
</section>

<?php else: ?>
<!-- PRODUCT LIST (no buttons, hover to detail) -->
<section class="tumblers">
    <h1>Tumblers</h1>
    <p>"Sip Smart, Stay Stylish 🔥"</p>
    <div class="product-grid">
        <?php foreach ($products as $id => $product): ?>
        <div class="product-card" onclick="window.location='tumbler.php?product=<?= $id ?>'">
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