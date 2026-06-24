<?php
session_start();


// 🟢 NEW - CORRECT (NUMERIC IDs)
$products = [
    16 => [  // ← Changed from 'shoulder1' to 16
        'id' => 16,  // ← Changed from 'shoulder1' to 16
        'name' => 'New Shoulder Hand bag for girls premium Quality',
        'price' => 1800.00,
        'image' => 'Stationary/Shoulder b1.avif',
        'rating' => 5,
        'reviews' => 1,
        'description' => 'Premium quality shoulder handbag for girls. Durable and fashionable design.'
    ],
    17 => [  // ← Changed from 'shoulder2' to 17
        'id' => 17,  // ← Changed from 'shoulder2' to 17
        'name' => 'Solid Color Beach Straw Shoulder Bag',
        'price' => 1100.00,
        'image' => 'Stationary/Shoulder B7.avif',
        'rating' => 5,
        'reviews' => 3,
        'description' => 'Solid color beach straw shoulder bag. Perfect for summer outings and vacations.'
    ],
    18 => [  // ← Changed from 'shoulder3' to 18
        'id' => 18,  // ← Changed from 'shoulder3' to 18
        'name' => 'High Quality Canvas Shoulder Bag',
        'price' => 1500.00,
        'image' => 'Stationary/SHOULDER b8.avif',
        'rating' => 5,
        'reviews' => 2,
        'description' => 'High quality canvas shoulder bag. Durable material with multiple compartments.'
    ],
    19 => [  // ← Changed from 'shoulder4' to 19
        'id' => 19,  // ← Changed from 'shoulder4' to 19
        'name' => 'Premium Quality Shoulder Bag',
        'price' => 2500.00,
        'image' => 'Stationary/Shoulder B6.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Premium quality shoulder bag with stylish design. Perfect for everyday use.'
    ],
    20 => [  // ← Changed from 'shoulder5' to 20
        'id' => 20,  // ← Changed from 'shoulder5' to 20
        'name' => 'Large Capacity Bag',
        'price' => 1500.00,
        'image' => 'Stationary/Shoulder b9.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Large capacity shoulder bag. Can hold laptop, books, and daily essentials.'
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
    'id' => $product_id,  // ← ADD THIS LINE
    'name' => $products[$product_id]['name'],
    'price' => $products[$product_id]['price'],
    'image' => $products[$product_id]['image'],
    'quantity' => $quantity
];
        }
        
        // Redirect to prevent form resubmission
        $redirect_url = 'shoulder-bags.php';
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
<title><?= $current_product ? htmlspecialchars($current_product['name']) . ' - Evara' : 'Shoulder Bags - Evara' ?></title>
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
                        <li><a href="water-bottle.php">Water Bottles</a></li>
                        <li><a href="tumblers.php">Tumblers</a></li>
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
                <a href="shoulder-bags.php" class="back-btn">← Back to Products</a>
            </form>
        </div>
    </div>
</section>

<?php else: ?>
<!-- PRODUCT LIST (no buttons, hover to detail) -->
<section class="shoulder-bags">
    <h1>Shoulder Bags</h1>
    <p>"Perfect Blend of Fashion & Function 🎀"</p>
    <div class="product-grid">
        <?php foreach ($products as $id => $product): ?>
        <div class="product-card" onclick="window.location='shoulder-bags.php?product=<?= $id ?>'">
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