<?php
session_start();

// Define product data array (15 products)
$products = [
    66 => [
        'id' => 66,
        'name' => 'MyKitab - Printed Diary - Jungle',
        'price' => 400.00,
        'image' => 'Stationary/Diary S1.avif',
        'rating' => 5,
        'reviews' => 1,
        'description' => 'Jungle themed printed diary from MyKitab. Perfect for nature lovers.'
    ],
    67 => [
        'id' => 67,
        'name' => 'Premium A5 Notebook with Elastic Band',
        'price' => 400.00,
        'image' => 'Stationary/diary S2.avif',
        'rating' => 5,
        'reviews' => 3,
        'description' => 'Premium A5 size notebook with elastic band closure. High quality paper.'
    ],
    68 => [
        'id' => 68,
        'name' => 'Krome diaries for girls',
        'price' => 500.00,
        'image' => 'Stationary/diary S3.avif',
        'rating' => 5,
        'reviews' => 2,
        'description' => 'Colorful Krome diaries specially designed for girls with attractive patterns.'
    ],
    69 => [
        'id' => 69,
        'name' => 'Premium A5 Notebook with Elastic Band Unicorn',
        'price' => 600.00,
        'image' => 'Stationary/diary s7.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Unicorn themed premium A5 notebook with elastic band. Magical design.'
    ],
    70 => [
        'id' => 70,
        'name' => 'Diary Notebook for Girls',
        'price' => 550.00,
        'image' => 'Stationary/diary s5.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Special diary notebook designed for girls with lock and key feature.'
    ],
    71 => [
        'id' => 71,
        'name' => 'Panda Spiral Notebook',
        'price' => 300.00,
        'image' => 'Stationary/diary s6.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Cute panda themed spiral notebook. Perfect for students and notes.'
    ],
    72 => [
        'id' => 72,
        'name' => 'Unicorn Diaries',
        'price' => 400.00,
        'image' => 'Stationary/diary 4.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Magical unicorn themed diaries with sparkles and rainbow designs.'
    ],
    73 => [
        'id' => 73,
        'name' => 'Pattern Notebook',
        'price' => 300.00,
        'image' => 'Stationary/diary s8avif.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Geometric pattern notebook with artistic design. A4 size.'
    ],
    74 => [
        'id' => 74,
        'name' => 'A4 Spiral Notebook',
        'price' => 300.00,
        'image' => 'Stationary/diary s9.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Standard A4 size spiral notebook. Perfect for office and school use.'
    ],
    75 => [
        'id' => 75,
        'name' => 'Kraft Cover Dot Matric A5 Notebook',
        'price' => 400.00,
        'image' => 'Stationary/diary s10.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Kraft cover dot matrix A5 notebook. Minimalist design for professionals.'
    ],
    76 => [
        'id' => 76,
        'name' => 'Dream Planet Flip Coil Pocket Mini Notepad',
        'price' => 250.00,
        'image' => 'Stationary/diary s11.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Pocket sized mini notepad with flip coil binding. Space and planet theme.'
    ],
    77 => [
        'id' => 77,
        'name' => 'Pastel colour diaries',
        'price' => 1000.00,
        'image' => 'Stationary/diary s12.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Set of pastel color diaries. Soft colors for daily journaling.'
    ],
    1 => [
        'id' => 1,
        'name' => 'Lavender Color Diary',
        'price' => 400.00,
        'image' => 'Stationary/diary 4.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Beautiful lavender colored diary with floral patterns. A5 size.'
    ],
    78 => [
        'id' => 78,
        'name' => 'WE Bears A4 Notebook',
        'price' => 300.00,
        'image' => 'Stationary/diary s14.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'WE Bears themed A4 notebook. Cartoon design for kids and teens.'
    ],
    79 => [
        'id' => 79,
        'name' => 'Shimmer Diary',
        'price' => 400.00,
        'image' => 'Stationary/diary s15.avif',
        'rating' => 5,
        'reviews' => 4,
        'description' => 'Shimmer effect diary with sparkling cover. Perfect for special occasions.'
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
        $redirect_url = 'Notebooks and Diaries.php';
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
<title><?= $current_product ? htmlspecialchars($current_product['name']) . ' - Evara' : 'Notebooks & Diaries - Evara' ?></title>
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
                <a href="Notebooks and Diaries.php" class="back-btn">← Back to Products</a>
            </form>
        </div>
    </div>
</section>

<?php else: ?>
<!-- PRODUCT LIST (no buttons, hover to detail) -->
<section class="notebooks">
    <h1>Notebooks & Diaries</h1>
    <p>"Write More, Dream Bigger 💭"</p>
    <div class="product-grid">
        <?php foreach ($products as $id => $product): ?>
        <div class="product-card" onclick="window.location='Notebooks and Diaries.php?product=<?= $id ?>'">
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