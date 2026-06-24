<?php
session_start();

/* =========================
   CART LOGIC
========================= */

// Calculate cart total
$total = 0;
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }
}

// Handle quantity update
if (isset($_POST['update_cart'])) {
    foreach ($_POST['qty'] as $id => $qty) {
        if ($qty <= 0) {
            unset($_SESSION['cart'][$id]);
        } else {
            $_SESSION['cart'][$id]['quantity'] = $qty;
        }
    }
    header("Location: cart.php");
    exit;
}

// Handle remove item
if (isset($_GET['remove'])) {
    $remove_id = (int)$_GET['remove'];
    unset($_SESSION['cart'][$remove_id]);
    header("Location: cart.php");
    exit;
}

$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart - Evara</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="cart.css">

    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>

<!-- OFFER BAR -->
<h3>FREE SHIPPING on Orders above Rs. 2999/-</h3>

<!-- NAVBAR -->
<div id="navbar">
    <a href="index.php">
        <img src="images/logo 1.png" alt="Evara Logo" class="logo">
    </a>

    <div class="menu">
        <nav class="navbar">
            <ul>
                <li class="dropdown">
                    <a href="#">✏️ Stationery</a>
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
                    <a href="#">✨ Elite Bottles</a>
                    <ul class="dropdown-menu">
                        <li><a href="water-bottle.php">Water Bottles</a></li>
                        <li><a href="tumbler.php">Tumblers</a></li>
                    </ul>
                </li>
            </ul>
        </nav>

        <a href="new-arrival.php">🆕 New Arrivals</a>
        <a href="sale.php">💖 Sale</a>
    </div>

    <div class="icons">
        <a href="#">🔍</a>
        <a href="<?php echo isset($_SESSION['user']) ? 'profile.php' : 'login.php'; ?>">👤</a>
        <a href="#">❤️</a>
        <a href="cart.php">🛒 <?php echo $cart_count > 0 ? '(' . $cart_count . ')' : ''; ?></a>
    </div>
</div>

<!-- ================= CART PAGE ================= -->
<div class="cart-page">
    <h2>Your Shopping Cart</h2>

    <?php if (!empty($_SESSION['cart'])): ?>
    <form method="POST">

        <div class="cart-grid">
            <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                <div class="cart-card">

                    <img src="<?php echo $item['image']; ?>" class="cart-card-img" alt="Product">

                    <div class="cart-card-details">
                        <h4><?php echo $item['name']; ?></h4>
                        <p class="price">PKR <?php echo number_format($item['price'], 2); ?></p>

                        <div class="qty-row">
                            <label>Qty</label>
                            <input type="number"
                                   name="qty[<?php echo $id; ?>]"
                                   value="<?php echo $item['quantity']; ?>"
                                   min="1">
                        </div>

                        <p class="subtotal">
                            Subtotal:
                            <b>PKR <?php echo number_format($item['price'] * $item['quantity'], 2); ?></b>
                        </p>

                        <a href="cart.php?remove=<?php echo $id; ?>" class="remove-btn">
                            ✖ Remove
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="cart-actions">
          

            <?php if (isset($_SESSION['user'])): ?>
                <a href="checkout.php" class="checkout-btn">
                    Proceed to Checkout (PKR <?php echo number_format($total, 2); ?>)
                </a>
            <?php else: ?>
                <a href="login.php?redirect=checkout" class="checkout-btn">
                    Login to Checkout
                </a>
            <?php endif; ?>
        </div>

    </form>

    <?php else: ?>
        <p class="empty-cart">
            Your cart is empty.
            <br><br>
            <a href="index.php">Continue Shopping</a>
        </p>
    <?php endif; ?>
</div>

<!-- FOOTER -->
<div class="footer">
    <div class="footer-section">
        <h3>About Evara</h3>
        <p>Evara is where ideas take shape. Premium stationery designed to inspire.</p>
    </div>

    <div class="footer-section">
        <h3>Quick Links</h3>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="#">Shop</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </div>

    <div class="footer-section">
        <h3>Customer Care</h3>
        <ul>
            <li><a href="#">FAQs</a></li>
            <li><a href="#">Shipping</a></li>
            <li><a href="#">Privacy Policy</a></li>
        </ul>
    </div>
</div>

<p class="copyright">
    © 2025 Evara. All rights reserved.
</p>

</body>
</html>