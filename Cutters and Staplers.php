<?php
session_start();

// Define product data array (10 products)
$products = [
    36 => [
        'id' => 36,
        'name' => 'Amazing Scissor',
        'price' => 300.00,
        'image' => 'Stationary/SCI S1.avif',
        'rating' => 5,
        'reviews' => 1,
        'description' => 'High-quality amazing scissors for precise cutting.'
    ],
    37 => [
        'id' => 37,
        'name' => 'Carrot Farm Flower - Cutter',
        'price' => 200.00,
        'image' => 'Stationary/sci S2.webp',
        'rating' => 5,
        'reviews' => 3,
        'description' => 'Carrot and farm flower shaped craft cutter.'
    ],
    38 => [
        'id' => 38,
        'name' => 'Utility Cutter',
        'price' => 450.00,
        'image' => 'Stationary/Sci S3.webp',
        'rating' => 5,
        'reviews' => 2,
        'description' => 'Multi-purpose utility cutter for various materials.'
    ],
    39 => [
        'id' => 39,
        'name' => 'Kuromi Purple - Scissor',
        'price' => 2000.00,
        'image' => 'Stationary/sci s4.webp',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Kuromi character purple colored scissors.'
    ],
    40 => [
        'id' => 40,
        'name' => 'Pastel Color Flower - Cutter',
        'price' => 190.00,
        'image' => 'Stationary/sci S5.webp',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Pastel color flower shaped craft cutter.'
    ],
    41 => [
        'id' => 41,
        'name' => 'Cute Bear - Cutter',
        'price' => 200.00,
        'image' => 'Stationary/sci S6.webp',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Cute bear shaped craft cutter for creative projects.'
    ],
    42 => [
        'id' => 42,
        'name' => 'Macaron Candy Color Scissor With Paper Cutter',
        'price' => 500.00,
        'image' => 'Stationary/sci s7.webp',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Macaron candy colored scissors with built-in paper cutter.'
    ],
    43 => [
        'id' => 43,
        'name' => 'Washi Tape Cutter and Dispenser',
        'price' => 600.00,
        'image' => 'Stationary/Sci s8.webp',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Washi tape cutter and dispenser for craft projects.'
    ],
    44 => [
        'id' => 44,
        'name' => 'Panda - Scissor',
        'price' => 300.00,
        'image' => 'Stationary/sci s9.webp',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Panda themed scissors with cute design.'
    ],
    45 => [
        'id' => 45,
        'name' => '1 Pcs Portable Folding Mini Scissors',
        'price' => 700.00,
        'image' => 'Stationary/sci S10.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Portable folding mini scissors for on-the-go use.'
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
        $redirect_url = 'Cutters and Staplers.php';
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
<title><?= $current_product ? htmlspecialchars($current_product['name']) . ' - Evara' : 'Cutters & Staplers - Evara' ?></title>
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
                <a href="Cutters and Staplers.php" class="back-btn">← Back to Products</a>
            </form>
        </div>
    </div>
</section>

<?php else: ?>
<!-- PRODUCT LIST (no buttons, hover to detail) -->
<section class="cutters">
    <h1>Cutters & Staplers</h1>
    <p>"Neat, Sharp & Always Handy ✂️"</p>
    <div class="product-grid">
        <?php foreach ($products as $id => $product): ?>
        <div class="product-card" onclick="window.location='Cutters and Staplers.php?product=<?= $id ?>'">
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