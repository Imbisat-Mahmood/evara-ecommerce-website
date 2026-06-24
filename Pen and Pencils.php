<?php
session_start();
require_once __DIR__ . '/config/db.php';

/* ADD TO CART */
if (isset($_POST['add_to_cart'])) {
    $id  = (int) $_POST['product_id'];
    $qty = max(1, (int) $_POST['quantity']);

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] += $qty;
    } else {
        $_SESSION['cart'][$id] = [
              'id' => $product_id,  
            'name' => $_POST['product_name'],
            'price' => $_POST['product_price'],
            'image' => $_POST['product_image'],
            'quantity' => $qty
        ];
    }

    header("Location: Pen and Pencils.php?product=$id");
    exit;
}

/* FETCH ALL PRODUCTS (CATEGORY = Pens & Pencils) */
$products = [];
$result = $conn->query("SELECT * FROM products WHERE category_id = 1");

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $products[$row['id']] = $row;
    }
}

/* SINGLE PRODUCT */
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
<title><?= $current_product ? htmlspecialchars($current_product['name']) . ' - Evara' : 'Pen & Pencil Collection - Evara' ?></title>
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
.pen-and-pencils h1,
.pen-and-pencils p {
    text-align: center;
}

.pen-and-pencils h1 {
    margin-bottom: 10px;
    font-size: 2.5rem;
}

.pen-and-pencils p {
    font-size: 1.2rem;
    color: #666;
    margin-bottom: 30px;
}
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
                <input type="hidden" name="product_id" value="<?= $current_product['id']; ?>">
                <input type="hidden" name="product_name" value="<?= htmlspecialchars($current_product['name']); ?>">
                <input type="hidden" name="product_price" value="<?= $current_product['price']; ?>">
                <input type="hidden" name="product_image" value="<?= htmlspecialchars($current_product['image']); ?>">
                <div class="quantity-selector">
                    <label for="quantity">Qty:</label>
                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="10">
                </div>
                <button type="submit" name="add_to_cart" class="add-to-cart-btn">Add to Cart</button>
                <a href="Pen and Pencils.php" class="back-btn">← Back to Products</a>
            </form>
        </div>
    </div>
</section>

<?php else: ?>
<!-- PRODUCT LIST (no buttons, hover to detail) -->
<section class="pen-and-pencils">
    <h1>Pen & Pencil Collection</h1>
    <p>"Write with Precision, Create with Style ✨"</p>
    <div class="product-grid">
        <?php foreach ($products as $id => $product): ?>
        <div class="product-card" onclick="window.location='Pen and Pencils.php?product=<?= $id ?>'">
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