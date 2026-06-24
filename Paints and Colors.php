<?php
session_start();

// Define product data array (15 products)
$products = [
    56 => [
        'id' => 56,
        'name' => 'Giorgione Professional Classic Colour Pencil Set 12/24/36/48/72/120 Colored Pencil Color',
        'price' => 700.00,
        'image' => 'Stationary/Paint S1.avif',
        'rating' => 5,
        'reviews' => 1,
        'description' => 'Professional quality colored pencils in various set sizes. Perfect for artists and designers.'
    ],
    57=> [
        'id' => 57,
        'name' => 'Pack of 2 special Mercury Brito Colored pencil 12 pcs set for student',
        'price' => 200.00,
        'image' => 'Stationary/PAINT S2.avif',
        'rating' => 5,
        'reviews' => 3,
        'description' => 'Special Mercury Brito colored pencil set, pack of 2 with 12 pieces each. Perfect for students.'
    ],
    58 => [
        'id' => 58,
        'name' => 'Acrylic Color Paints, Paint Tubes, Set of 12/24 Colours',
        'price' => 500.00,
        'image' => 'Stationary/PAINT S3.avif',
        'rating' => 5,
        'reviews' => 2,
        'description' => 'Acrylic color paints in tubes, available in sets of 12 or 24 vibrant colors.'
    ],
    59 => [
        'id' => 59,
        'name' => 'M&G Acrylic Paints 75ml per tube 1pc Pack High quality pigments available in 48 Shades',
        'price' => 400.00,
        'image' => 'Stationary/PAINT S4avif.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'M&G acrylic paints, 75ml per tube, high quality pigments available in 48 different shades.'
    ],
    60 => [
        'id' => 60,
        'name' => 'Professional Art Brush Set Water Color Oil Acrylic Artist Paint Brush Set',
        'price' => 400.00,
        'image' => 'Stationary/paint S5.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Professional art brush set suitable for watercolor, oil, and acrylic painting.'
    ],
    61 => [
        'id' => 61,
        'name' => 'Acrylic Paint Set Waterproof Non Toxic Ceramic DIY Paint',
        'price' => 100.00,
        'image' => 'Stationary/Paint S6.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Waterproof, non-toxic acrylic paint set suitable for ceramic and DIY projects.'
    ],
    62 => [
        'id' => 62,
        'name' => 'Marie\'s Oil Color Paint Tube 50 ml',
        'price' => 400.00,
        'image' => 'Stationary/PAINT S7.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Marie\'s oil color paint in 50ml tubes. High quality oil paints for professional artists.'
    ],
    63 => [
        'id' => 63,
        'name' => '3 Piece Of 12X12 Inches Canvas Boards with easel',
        'price' => 700.00,
        'image' => 'Stationary/PAINT S8.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Set of 3 canvas boards measuring 12x12 inches each, includes a sturdy easel.'
    ],
    64 => [
        'id' => 64,
        'name' => '15pcs Fine Detail Paint Brush Set',
        'price' => 600.00,
        'image' => 'Stationary/PAINT S9.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => '15 piece fine detail paint brush set for intricate artwork and detailed painting.'
    ],
    65 => [
        'id' => 65,
        'name' => '5pcs Sponge',
        'price' => 200.00,
        'image' => 'Stationary/PAINT S10.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Set of 5 painting sponges for various painting techniques and textures.'
    ],
    
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
        $redirect_url = 'Paints and Colors.php';
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
<title><?= $current_product ? htmlspecialchars($current_product['name']) . ' - Evara' : 'Artistic Paints & Colors - Evara' ?></title>
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
                <a href="Paints and Colors.php" class="back-btn">← Back to Products</a>
            </form>
        </div>
    </div>
</section>

<?php else: ?>
<!-- PRODUCT LIST (no buttons, hover to detail) -->
<section class="paints-colors">
    <h1>Artistic Paints & Colours</h1>
    <p>"Unleash your creativity with vibrant shades and premium pigments."✨</p>
    <div class="product-grid">
        <?php foreach ($products as $id => $product): ?>
        <div class="product-card" onclick="window.location='Paints and Colors.php?product=<?= $id ?>'">
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