<?php
session_start();
require_once '../config/db.php';

// Redirect to login if not admin
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Get statistics for dashboard
$products_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM products"))['count'] ?? 0;
$orders_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM orders"))['count'] ?? 0;
$users_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM users"))['count'] ?? 0;

// Get revenue - check different column names
$revenue = 0;
$order_columns = [];
$check_columns = mysqli_query($conn, "SHOW COLUMNS FROM orders");
while($col = mysqli_fetch_assoc($check_columns)) {
    $order_columns[] = $col['Field'];
}

if (in_array('total_price', $order_columns)) {
    $result = mysqli_query($conn, "SELECT SUM(total_price) as revenue FROM orders WHERE status='completed'");
    $row = mysqli_fetch_assoc($result);
    $revenue = $row['revenue'] ?? 0;
} elseif (in_array('amount', $order_columns)) {
    $result = mysqli_query($conn, "SELECT SUM(amount) as revenue FROM orders WHERE status='completed'");
    $row = mysqli_fetch_assoc($result);
    $revenue = $row['revenue'] ?? 0;
} elseif (in_array('total', $order_columns)) {
    $result = mysqli_query($conn, "SELECT SUM(total) as revenue FROM orders WHERE status='completed'");
    $row = mysqli_fetch_assoc($result);
    $revenue = $row['revenue'] ?? 0;
}

// Recent orders
$recent_orders = mysqli_query($conn, "
    SELECT o.*, u.name as customer_name 
    FROM orders o 
    JOIN users u ON o.user_id = u.id 
    ORDER BY o.created_at DESC 
    LIMIT 5
");

// Recent products
$recent_products = mysqli_query($conn, "SELECT * FROM products ORDER BY created_at DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Evara Admin</title>
   
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Admin CSS (in same admin folder) -->
    <link rel="stylesheet" href="admin.css">
</head>
<body class="admin-dashboard">
    <!-- Admin Header -->
    <header class="admin-header">
        <div class="admin-brand">
            <img src="../images/logo 1.png" alt="Evara Logo" class="logo">
            <h2>Evara Admin Dashboard</h2>
        </div>
        
        <div class="admin-user">
            <span>Welcome, <?php echo htmlspecialchars($_SESSION['admin_name']); ?></span>
            <a href="admin_logout.php" class="btn-logout">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </header>

    <div class="admin-container">
        <!-- Sidebar -->
        <nav class="admin-sidebar">
            <ul class="sidebar-nav">
                <li>
                    <a href="admin_index.php" class="active">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="products.php">
                        <i class="fas fa-box"></i> Products
                    </a>
                </li>
                <li>
                    <a href="categories.php">
                        <i class="fas fa-list"></i> Categories
                    </a>
                </li>
                <li>
                    <a href="orders.php">
                        <i class="fas fa-shopping-cart"></i> Orders
                    </a>
                </li>
                <li>
                    <a href="customers.php">
                        <i class="fas fa-users"></i> Customers
                    </a>
                </li>
                <li>
                    <a href="reports.php">
                        <i class="fas fa-chart-bar"></i> Reports
                    </a>
                </li>
                
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="admin-main">
            <!-- Welcome Section -->
            <section class="admin-welcome">
                <h1 class="welcome-title">Welcome back, <?php echo htmlspecialchars($_SESSION['admin_name']); ?>!</h1>
                <p class="welcome-text">Here's what's happening with your Evara store today.</p>
            </section>

            <!-- Stats Cards -->
            <section class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon products">
                        <i class="fas fa-box"></i>
                    </div>
                    <h3 class="stat-number"><?php echo number_format($products_count); ?></h3>
                    <p class="stat-title">Total Products</p>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon orders">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h3 class="stat-number"><?php echo number_format($orders_count); ?></h3>
                    <p class="stat-title">Total Orders</p>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon customers">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="stat-number"><?php echo number_format($users_count); ?></h3>
                    <p class="stat-title">Total Customers</p>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon revenue">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="stat-number">Rs. <?php echo number_format($revenue, 2); ?></h3>
                    <p class="stat-title">Total Revenue</p>
                </div>
            </section>

            <!-- Recent Orders Section -->
            <section class="content-card">
                <h3 class="card-title">Recent Orders</h3>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($recent_orders && mysqli_num_rows($recent_orders) > 0): ?>
                            <?php while($order = mysqli_fetch_assoc($recent_orders)): ?>
                                <tr>
                                    <td>#<?php echo $order['id']; ?></td>
                                    <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                    <td>
                                        <?php 
                                            $amount = $order['total_price'] ?? $order['amount'] ?? $order['total'] ?? 0;
                                            echo 'Rs. ' . number_format($amount, 2);
                                        ?>
                                    </td>
                                    <td>
                                        <?php if(isset($order['status'])): ?>
                                            <?php 
                                                $status_class = 'badge-'.$order['status'];
                                                echo "<span class='badge {$status_class}'>{$order['status']}</span>";
                                            ?>
                                        <?php else: ?>
                                            <span class="badge badge-pending">Pending</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="orders.php?view=<?php echo $order['id']; ?>" class="btn-small btn-view">View</a>
                                            <a href="orders.php?edit=<?php echo $order['id']; ?>" class="btn-small btn-edit">Edit</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center; color: #666;">No orders found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <a href="orders.php" class="view-all-link">View All Orders →</a>
            </section>

            <!-- Recent Products Section -->
            <section class="content-card">
                <h3 class="card-title">Recent Products</h3>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($recent_products && mysqli_num_rows($recent_products) > 0): ?>
                            <?php while($product = mysqli_fetch_assoc($recent_products)): ?>
                                <tr>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <?php if(!empty($product['image'])): ?>
                                                <img src="../uploads/products/<?php echo $product['image']; ?>" 
                                                     alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                                     class="table-product-img">
                                            <?php endif; ?>
                                            <span><?php echo htmlspecialchars($product['name']); ?></span>
                                        </div>
                                    </td>
                                    <td>Rs. <?php echo number_format($product['price'] ?? 0, 2); ?></td>
                                    <td><?php echo $product['stock'] ?? 0; ?></td>
                                    <td>
                                        <?php if(($product['stock'] ?? 0) > 0): ?>
                                            <span class="badge badge-instock">In Stock</span>
                                        <?php else: ?>
                                            <span class="badge badge-outstock">Out of Stock</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="products.php?view=<?php echo $product['id']; ?>" class="btn-small btn-view">View</a>
                                            <a href="products.php?edit=<?php echo $product['id']; ?>" class="btn-small btn-edit">Edit</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center; color: #666;">No products found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <a href="products.php" class="view-all-link">View All Products →</a>
            </section>
        </main>
    </div>
</body>
</html>