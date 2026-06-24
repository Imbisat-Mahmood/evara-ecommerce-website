<?php
session_start();

// Define product data array (20 products)
$products = [
    80 => [
        'id' => 80,
        'name' => 'Portable Neck Fan',
        'price' => 2400.00,
        'image' => 'New Arrival/Fan NA.webp',
        'rating' => 5,
        'reviews' => 1,
        'description' => 'Comfortable portable neck fan for hands-free cooling. Perfect for summer.'
    ],
    81 => [
        'id' => 81,
        'name' => 'Premium Markers',
        'price' => 1500.00,
        'image' => 'New Arrival/markers.webp',
        'rating' => 5,
        'reviews' => 3,
        'description' => 'High-quality premium markers for artists and professionals.'
    ],
    82 => [
        'id' => 82,
        'name' => 'Pencil Case with Stationery Bundle',
        'price' => 2400.00,
        'image' => 'images/kawai d.webp',
        'rating' => 5,
        'reviews' => 2,
        'description' => 'Complete pencil case with stationery bundle. Everything you need in one set.'
    ],
    83 => [
        'id' => 84,
        'name' => 'Unicorn Shape Sharpener deal',
        'price' => 180.00,
        'image' => 'New Arrival/Sharpener NA.webp',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Cute unicorn shaped pencil sharpener. Functional and decorative.'
    ],
    84 => [
        'id' => 84,
        'name' => 'A6 Paintings Inspired Sketchbook',
        'price' => 1400.00,
        'image' => 'New Arrival/Paintinh NA.webp',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'A6 size paintings inspired sketchbook. Perfect for artists and designers.'
    ],
    85 => [
        'id' => 85,
        'name' => 'Children Artistic Watercolor Marker Set',
        'price' => 3300.00,
        'image' => 'New Arrival/watercolour NA.webp',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Children artistic watercolor marker set. Safe and non-toxic for kids.'
    ],
    86 => [
        'id' => 86,
        'name' => 'Kawai mix Tapes (Random Set of 10)',
        'price' => 1300.00,
        'image' => 'New Arrival/Tape NA.webp',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Kawai mixed tapes random set of 10. Various cute designs.'
    ],
    87 => [
        'id' => 87,
        'name' => 'Oil Gel Pen (Set of 4)',
        'price' => 1300.00,
        'image' => 'New Arrival/Gel pen NA.webp',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Oil gel pen set of 4. Smooth writing with vibrant colors.'
    ],
     88 => [
        'id' => 88,
        'name' => 'Tyle Tiger Tumbler',
        'price' => 6800.00,
        'image' => 'New Arrival/Tumbler NA.webp',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Tyle tiger themed tumbler. Insulated for hot and cold drinks.'
    ],
    89 => [
        'id' => 89,
        'name' => 'Cartoon Cutters',
        'price' => 180.00,
        'image' => 'New Arrival/Cutter NA.webp',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Cartoon themed cutters for crafts and scrapbooking.'
    ],
    90 => [
        'id' => 90,
        'name' => 'Plush Pencil Case',
        'price' => 500.00,
        'image' => 'New Arrival/PlushPencilCase NA.webp',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Soft plush pencil case. Cuddly and functional for stationery.'
    ],
    91 => [
        'id' => 91,
        'name' => 'Solid Colors Highlighter',
        'price' => 150.00,
        'image' => 'New Arrival/Highlighteer NAwebp.webp',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Solid colors highlighter set. Bright and long-lasting.'
    ],
    92 => [
        'id' => 92,
        'name' => 'Cartoon Waterproof Bandages',
        'price' => 180.00,
        'image' => 'New Arrival/newseasonbandage NA.webp',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Cartoon waterproof bandages. Cute designs for first aid.'
    ],
    93 => [
        'id' => 93,
        'name' => 'Premium Hard Cover Office Notebook Diary',
        'price' => 2300.00,
        'image' => 'New Arrival/Notebook NAwebp.webp',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Premium hard cover office notebook diary. Professional and durable.'
    ],
    94 => [
        'id' => 94,
        'name' => 'Paint Brushes',
        'price' => 1600.00,
        'image' => 'New Arrival/PaintBrushes-NA.webp',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Professional paint brushes set. Various sizes for different techniques.'
    ],
    95 => [
        'id' => 95,
        'name' => 'Outline Metallic Markers',
        'price' => 1400.00,
        'image' => 'New Arrival/Outline_Metallic_Markers NA.webp',
        'rating' => 5,
        'reviews' => 3,
        'description' => 'Outline metallic markers for drawing and crafts. Shiny metallic finish.'
    ],
    96=> [
        'id' => 96,
        'name' => 'Tie n Dye Large Canvas Bags',
        'price' => 2000.00,
        'image' => 'New Arrival/Tie n Dye large Bag.webp',
        'rating' => 5,
        'reviews' => 3,
        'description' => 'Tie and dye large canvas bags. Eco-friendly and stylish.'
    ],
    97 => [
        'id' => 97,
        'name' => 'Portable Handle Color Coated Steel Thermos Bottle',
        'price' => 1500.00,
        'image' => 'New Arrival/ThermosBottle NA.webp',
        'rating' => 5,
        'reviews' => 3,
        'description' => 'Portable handle color coated steel thermos bottle. Keeps drinks hot/cold.'
    ],
    98 => [
        'id' => 98,
        'name' => 'Light Purple Large Capacity - 3 Zip Pouch',
        'price' => 740.00,
        'image' => 'New Arrival/Light Purple -3 zip Pouch.webp',
        'rating' => 5,
        'reviews' => 3,
        'description' => 'Light purple large capacity 3-zip pouch. Multiple compartments for organization.'
    ],
    99 => [
        'id' => 99,
        'name' => 'Unicorn Spiral Sticky Note Book',
        'price' => 440.00,
        'image' => 'New Arrival/Unicorn Spiral Sticky Note Book.webp',
        'rating' => 5,
        'reviews' => 3,
        'description' => 'Unicorn spiral sticky note book. Perfect for reminders and notes.'
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
        $redirect_url = 'New Arrival.php';
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
<title><?= $current_product ? htmlspecialchars($current_product['name']) . ' - Evara' : 'New Arrivals - Evara' ?></title>
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
                <a href="New Arrival.php" class="back-btn">← Back to Products</a>
            </form>
        </div>
    </div>
</section>

<?php else: ?>
<!-- PRODUCT LIST (no buttons, hover to detail) -->
<section class="new-arrivals">
    <h1>New Arrivals You'll Love</h1>
    <p>Check out the latest products just added to our collection! 🎀</p>
    <div class="product-grid">
        <?php foreach ($products as $id => $product): ?>
        <div class="product-card" onclick="window.location='New Arrival.php?product=<?= $id ?>'">
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