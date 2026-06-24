<?php
session_start();

// Define product data array (10 products)
$products = [
    26 => [
        'id' => 26,
        'name' => '2000ML Motivational Transparent Drinking Water Bottle',
        'price' => 1000.00,
        'image' => 'Stationary/Water W1.avif',
        'rating' => 5,
        'reviews' => 1,
        'description' => 'Large 2000ML motivational transparent water bottle with inspirational quotes. BPA-free.'
    ],
    27 => [
        'id' => 27,
        'name' => '400ml Glass Water Bottle',
        'price' => 700.00,
        'image' => 'Stationary/water W2.avif',
        'rating' => 5,
        'reviews' => 3,
        'description' => 'Elegant 400ml glass water bottle with protective sleeve. Eco-friendly and reusable.'
    ],
    28 => [
        'id' => 28,
        'name' => 'Hello Master Borosilicate Water Bottle 480ML',
        'price' => 650.00,
        'image' => 'Stationary/water W3.avif',
        'rating' => 5,
        'reviews' => 2,
        'description' => 'Premium borosilicate glass water bottle. Heat-resistant and dishwasher safe.'
    ],
    29 => [
        'id' => 29,
        'name' => 'Color Coated Steel Thermos Bottle',
        'price' => 1800.00,
        'image' => 'Stationary/WAter W4.webp',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Color coated stainless steel thermos bottle. Keeps drinks hot/cold for hours.'
    ],
    30 => [
        'id' => 30,
        'name' => 'Plastic Water Bottle and Sipper',
        'price' => 690.00,
        'image' => 'Stationary/water w5.webp',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Convenient plastic water bottle with sipper cap. Leak-proof and portable.'
    ],
    31 => [
        'id' => 31,
        'name' => 'Transparent Plastic Water Bottle',
        'price' => 490.00,
        'image' => 'Stationary/water w6.webp',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Clear transparent plastic water bottle. Lightweight and durable design.'
    ],
    32 => [
        'id' => 32,
        'name' => 'Cute Thermos insulated Sipper Bottle',
        'price' => 1490.00,
        'image' => 'Stationary/Water W7.webp',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Adorable insulated thermos sipper bottle. Perfect for kids and adults.'
    ],
    33 => [
        'id' => 33,
        'name' => 'Spirit Sipper Water Bottle',
        'price' => 1190.00,
        'image' => 'Stationary/Water W8.webp',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Spirit themed sipper water bottle. Motivational design for daily hydration.'
    ],
    34 => [
        'id' => 34,
        'name' => 'Smart Crystal Glass Colored Travel Water Bottle 500ml Fancy',
        'price' => 590.00,
        'image' => 'Stationary/water w9.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Fancy crystal glass colored travel water bottle. Stylish and functional.'
    ],
    35 => [
        'id' => 35,
        'name' => 'Panda Water Bottle for Outdoor',
        'price' => 990.00,
        'image' => 'Stationary/water w10.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Cute panda themed water bottle for outdoor activities. Durable and fun design.'
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
        $redirect_url = 'Water Bottle.php';
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
<title><?= $current_product ? htmlspecialchars($current_product['name']) . ' - Evara' : 'Water Bottles - Evara' ?></title>
<link rel="stylesheet" href="style.css">
<style>
/* Additional CSS for hover redirect and pink buttons */
.product-card {
    cursor: pointer;
    transition: transform 0.3s ease;
}

.product-card:hover {
    transform: translateY(-5px);
}

.add-to-cart-btn {
    background-color: #ff4081; /* Pink color */
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
}

.add-to-cart-btn:hover {
    background-color: #e91e63; /* Darker pink on hover */
}

/* Center heading and subheading */
.water-bottles h1,
.water-bottles p {
    text-align: center;
}

.water-bottles h1 {
    margin-bottom: 10px;
    font-size: 2.5rem;
}

.water-bottles p {
    font-size: 1.2rem;
    color: #666;
    margin-bottom: 30px;
}
</style>
</head>
<body>

<h3>FREE SHIPPING on Orders above Rs. 2999/-</h3>

<!-- Navigation (with correct file names) -->
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
                <a href="Water Bottle.php" class="back-btn">← Back to Products</a>
            </form>
        </div>
    </div>
</section>

<?php else: ?>
<!-- PRODUCT LIST (no buttons, hover to detail) -->
<section class="water-bottles">
    <h1>Water Bottles</h1>
    <p>"Sip in Style, Anytime Anywhere ✨"</p>
    <div class="product-grid">
        <?php foreach ($products as $id => $product): ?>
        <div class="product-card" onclick="window.location='Water Bottle.php?product=<?= $id ?>'">
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