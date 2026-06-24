<?php
session_start();

// Define product data array (10 products)
$products = [
    101 => [
        'id' => 101,
        'name' => 'Hand Painted Tote Bag',
        'price' => 400.00,
        'image' => 'Stationary/TOTE B1.avif',
        'rating' => 5,
        'reviews' => 1,
        'description' => 'Beautiful hand painted tote bag with unique artistic design.'
    ],
    102 => [
        'id' => 102,
        'name' => 'Stylish Tote Bags',
        'price' => 400.00,
        'image' => 'Stationary/tote s19.avif',
        'rating' => 5,
        'reviews' => 3,
        'description' => 'Set of stylish tote bags for different occasions. Modern and fashionable.'
    ],
    103 => [
        'id' => 103,
        'name' => 'Hand painted tote bag for girls eco friendly 38cm×42cm',
        'price' => 350.00,
        'image' => 'Stationary/tote  b3.avif',
        'rating' => 5,
        'reviews' => 2,
        'description' => 'Eco-friendly hand painted tote bag for girls. Size: 38cm × 42cm.'
    ],
    104 => [
        'id' => 104,
        'name' => 'Hand Painted tote bag for Girls',
        'price' => 4000.00,
        'image' => 'Stationary/tote s4.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Premium hand painted tote bag specially designed for girls.'
    ],
    105 => [
        'id' => 105,
        'name' => 'Butterfly Large Capacity Bag',
        'price' => 390.00,
        'image' => 'Stationary/Tote S12.webp',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Butterfly themed large capacity tote bag. Spacious and beautiful.'
    ],
    106 => [
        'id' => 106,
        'name' => 'Zipper jeans tote bag 15×17inches',
        'price' => 400.00,
        'image' => 'Stationary/tote B13.webp',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Denim jeans style tote bag with zipper closure. Size: 15×17 inches.'
    ],
    107 => [
        'id' => 107,
        'name' => 'Trendy Leaf Books Tag Printed Beige Color',
        'price' => 500.00,
        'image' => 'Stationary/tote b7.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Trendy leaf and books tag printed beige color tote bag. Literary theme.'
    ],
    108 => [
        'id' => 108,
        'name' => 'I Don\'t Care Lady Printed White Color Tote Bag',
        'price' => 400.00,
        'image' => 'Stationary/Tote B10.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => '"I Don\'t Care" lady printed white color tote bag. Bold statement design.'
    ],
    109 => [
        'id' => 109,
        'name' => 'Flower Tote Bag',
        'price' => 300.00,
        'image' => 'Stationary/Tote B2.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Beautiful flower patterned tote bag. Perfect for spring and summer.'
    ],
    110 => [
        'id' => 110,
        'name' => 'Vintage Eiffel Tower Canvas Tote Bag',
        'price' => 400.00,
        'image' => 'Stationary/tote s11.webp',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Vintage Eiffel Tower printed canvas tote bag. Parisian theme.'
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
        $redirect_url = 'tote-bags.php';
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
<title><?= $current_product ? htmlspecialchars($current_product['name']) . ' - Evara' : 'Tote Bags - Evara' ?></title>
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
                <a href="tote-bags.php" class="back-btn">← Back to Products</a>
            </form>
        </div>
    </div>
</section>

<?php else: ?>
<!-- PRODUCT LIST (no buttons, hover to detail) -->
<section class="tote-bags">
    <h1>Tote Bags</h1>
    <p>"Carry Style, Everywhere ✨"</p>
    <div class="product-grid">
        <?php foreach ($products as $id => $product): ?>
        <div class="product-card" onclick="window.location='tote-bags.php?product=<?= $id ?>'">
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
