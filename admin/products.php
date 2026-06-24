<?php
// /admin/products.php
session_start();

// Initialize message
$message = '';

// Use your existing db.php file
require_once __DIR__ . '/../config/db.php';

// Check if PDO connection exists
if (!isset($pdo)) {
    die("Database connection not established. Please check config/db.php");
}

// Auto-login for testing (remove in production)
if (!isset($_SESSION['admin_logged_in'])) {
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_name'] = 'Evara Admin';
}

// Handle product deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
    $product_id = intval($_POST['product_id']);
    
    try {
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
        $stmt->execute([':id' => $product_id]);
        
        $_SESSION['message'] = "✅ Product deleted successfully.";
        header("Location: products.php");
        exit();
        
    } catch(PDOException $e) {
        $_SESSION['message'] = "❌ Error deleting product: " . $e->getMessage();
        header("Location: products.php");
        exit();
    }
}

// Check for stored message
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

// Fetch products with category information
try {
    $query = "SELECT p.*, c.name as category_name 
              FROM products p 
              LEFT JOIN categories c ON p.category_id = c.id 
              ORDER BY p.created_at DESC";
    
    $stmt = $pdo->query($query);
    $products = $stmt->fetchAll();
    $total_products = count($products);
    
} catch(PDOException $e) {
    die("Error fetching products: " . $e->getMessage());
}

// Fetch categories for dropdown
$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evara Admin - Products</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sidebar-bg: rgb(234, 168, 207); 
            --sidebar-hover: #34495e;
            --sidebar-text: #2b2f30;
            --sidebar-active: #3498db;
            --primary-color: #3498db;
            --secondary-color: #2ecc71;
            --danger-color: #e74c3c;
            --warning-color: #f39c12;
            --light-bg: #f8f9fa;
            --card-bg: #ffffff;
            --text-dark: #2c3e50;
            --text-light: #7f8c8d;
            --border-color: #e0e0e0;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--light-bg);
            color: var(--text-dark);
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar Styles - EXACT colors from your design */
        .sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            color: var(--sidebar-text);
            position: fixed;
            height: 100vh;
            padding-top: 20px;
            box-shadow: 2px 0 15px rgba(0,0,0,0.1);
        }
        
        .logo {
            padding: 0 25px 30px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 30px;
        }
        
        .logo h2 {
            color: white;
            font-size: 26px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 600;
        }
        
        .logo h2 i {
            color: var(--sidebar-active);
            font-size: 28px;
        }
        
        .nav-menu {
            list-style: none;
            padding: 0;
        }
        
        .nav-item {
            padding: 16px 30px;
            display: flex;
            align-items: center;
            gap: 15px;
            color: var(--sidebar-text);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            font-size: 15px;
        }
        
        .nav-item:hover {
            background-color: var(--sidebar-hover);
            color: white;
            border-left-color: var(--sidebar-active);
        }
        
        .nav-item.active {
            background-color: var(--sidebar-hover);
            color: white;
            border-left-color: var(--sidebar-active);
            font-weight: 600;
        }
        
        .nav-item i {
            width: 22px;
            text-align: center;
            font-size: 18px;
        }
        
        /* Main Content Styles */
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 25px;
        }
        
        .header {
            background-color: var(--card-bg);
            padding: 25px 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header h1 {
            color: var(--text-dark);
            font-size: 28px;
            font-weight: 600;
        }
        
        .welcome {
            color: var(--text-light);
            font-size: 16px;
            margin-top: 8px;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), #2980b9);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
            box-shadow: 0 3px 10px rgba(52, 152, 219, 0.3);
        }
        
        /* Message */
        .message {
            padding: 18px 25px;
            background-color: #d4edda;
            color: #155724;
            border-left: 5px solid var(--secondary-color);
            margin-bottom: 25px;
            border-radius: 8px;
            display: <?php echo !empty($message) ? 'flex' : 'none'; ?>;
            align-items: center;
            gap: 12px;
            font-size: 15px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
        }
        
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border-left-color: var(--danger-color);
        }
        
        /* Products Table Container */
        .table-container {
            background-color: var(--card-bg);
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        
        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--border-color);
        }
        
        .table-header h2 {
            color: var(--text-dark);
            font-size: 22px;
            font-weight: 600;
        }
        
        .btn-add {
            background: linear-gradient(135deg, var(--primary-color), #2980b9);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 3px 12px rgba(52, 152, 219, 0.3);
        }
        
        .btn-add:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 18px rgba(52, 152, 219, 0.4);
        }
        
        /* Products Table */
        .products-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        
        .products-table thead {
            background-color: #f8f9fa;
        }
        
        .products-table th {
            text-align: left;
            padding: 18px 20px;
            font-weight: 600;
            color: var(--text-dark);
            border-bottom: 2px solid var(--border-color);
            white-space: nowrap;
            font-size: 15px;
        }
        
        .products-table td {
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }
        
        .products-table tr:hover {
            background-color: #f8fafc;
        }
        
        .product-info {
            display: flex;
            align-items: center;
            gap: 18px;
        }
        
        .product-image-container {
            width: 85px;
            height: 85px;
            border-radius: 10px;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
            border: 1px solid #eaeaea;
            box-shadow: 0 3px 8px rgba(0,0,0,0.08);
        }
        
        .product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .product-image-container:hover .product-image {
            transform: scale(1.05);
        }
        
        .no-image {
            width: 85px;
            height: 85px;
            border-radius: 10px;
            background: linear-gradient(135deg, #f5f7fa, #e4e8f0);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-light);
            font-size: 28px;
        }
        
        .product-details {
            flex: 1;
        }
        
        .product-name {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
            font-size: 16px;
            line-height: 1.4;
        }
        
        .product-category {
            display: inline-block;
            background-color: #e8f4fc;
            color: var(--primary-color);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .product-meta {
            display: flex;
            gap: 18px;
            margin-top: 10px;
            font-size: 14px;
            color: var(--text-light);
        }
        
        .price {
            color: var(--secondary-color);
            font-weight: 700;
            font-size: 17px;
        }
        
        .rating {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--warning-color);
            font-weight: 600;
        }
        
        .actions {
            display: flex;
            gap: 12px;
        }
        
        .btn-action {
            padding: 10px 16px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-width: 90px;
        }
        
        .btn-view {
            background-color: #e8f4fc;
            color: var(--primary-color);
            border: 1px solid #cfe2ff;
        }
        
        .btn-edit {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        
        .btn-delete {
            background-color: #f8d7da;
            color: var(--danger-color);
            border: 1px solid #f5c6cb;
        }
        
        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        
        /* Edit Dropdown */
        .edit-dropdown {
            position: absolute;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            padding: 10px 0;
            min-width: 180px;
            z-index: 100;
            display: none;
            border: 1px solid var(--border-color);
        }
        
        .edit-dropdown.show {
            display: block;
        }
        
        .edit-dropdown button {
            width: 100%;
            padding: 14px 22px;
            background: none;
            border: none;
            text-align: left;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text-dark);
            font-size: 14px;
            transition: background-color 0.2s ease;
        }
        
        .edit-dropdown button:hover {
            background-color: #f8f9fa;
        }
        
        /* Footer */
        .footer {
            margin-top: 35px;
            text-align: center;
            color: var(--text-light);
            font-size: 14px;
            padding: 25px;
            border-top: 1px solid var(--border-color);
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }
        
        .empty-state i {
            font-size: 70px;
            color: #e0e6ed;
            margin-bottom: 25px;
        }
        
        .empty-state h3 {
            color: var(--text-dark);
            font-size: 22px;
            margin-bottom: 15px;
            font-weight: 600;
        }
        
        .empty-state p {
            color: var(--text-light);
            font-size: 16px;
            margin-bottom: 30px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }
        
        @media (max-width: 992px) {
            .sidebar {
                width: 80px;
            }
            
            .sidebar .nav-text {
                display: none;
            }
            
            .logo h2 span {
                display: none;
            }
            
            .main-content {
                margin-left: 80px;
            }
        }
        
        @media (max-width: 768px) {
            .products-table {
                display: block;
                overflow-x: auto;
            }
            
            .product-info {
                min-width: 350px;
            }
            
            .actions {
                flex-wrap: wrap;
            }
        }
    </style>


</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <h2><i class="fas fa-store"></i> <span>Evara</span></h2>
        </div>
        <ul class="nav-menu">
            <li><a href="admin_index.php" class="nav-item"><i class="fas fa-home"></i> <span class="nav-text">Dashboard</span></a></li>
            <li><a href="products.php" class="nav-item active"><i class="fas fa-box"></i> <span class="nav-text">Products</span></a></li>
            <li><a href="categories.php" class="nav-item"><i class="fas fa-tags"></i> <span class="nav-text">Categories</span></a></li>
            <li><a href="orders.php" class="nav-item"><i class="fas fa-shopping-cart"></i> <span class="nav-text">Orders</span></a></li>
            <li><a href="customers.php" class="nav-item"><i class="fas fa-users"></i> <span class="nav-text">Customers</span></a></li>
            <li><a href="reports.php" class="nav-item"><i class="fas fa-chart-bar"></i> <span class="nav-text">Reports</span></a></li>
            <li><a href="settings.php" class="nav-item"><i class="fas fa-cog"></i> <span class="nav-text">Settings</span></a></li>
        </ul>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <div>
                <h1>Product Management</h1>
                
            </div>
            <div class="user-info">
                <div class="user-avatar">EA</div>
                <div>
                    <strong><?php echo $_SESSION['admin_name']; ?></strong><br>
                    <small>Administrator</small>
                </div>
            </div>
        </div>
        
        <!-- Message -->
        <?php if (!empty($message)): ?>
        <div class="message <?php echo strpos($message, '❌') !== false ? 'error' : ''; ?>" id="message">
            <i class="fas <?php echo strpos($message, '❌') !== false ? 'fa-exclamation-circle' : 'fa-check-circle'; ?>"></i> 
            <?php echo htmlspecialchars($message); ?>
        </div>
        <?php endif; ?>
        
        <!-- Products Table -->
        <div class="table-container">
            <div class="table-header">
                <h2>All Products (<?php echo $total_products; ?>)</h2>
                <button class="btn-add" onclick="window.location.href='add_product.php'">
                    <i class="fas fa-plus"></i> Add New Product
                </button>
            </div>
            
            <?php if ($total_products > 0): ?>
            <table class="products-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Rating</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td>
                            <div class="product-info">
                                <div class="product-image-container">
                                    <?php 
                                    $imagePath = $product['image'] ?? '';
                                    if (!empty($imagePath)): 
                                        // Handle both URLs and local paths
                                        $isUrl = filter_var($imagePath, FILTER_VALIDATE_URL);
                                        $src = $isUrl ? $imagePath : $imagePath;
                                    ?>
                                        <img src="<?php echo htmlspecialchars($src); ?>" 
                                             alt="<?php echo htmlspecialchars($product['name']); ?>"
                                             class="product-image"
                                             onerror="this.onerror=null; this.parentElement.className='no-image'; this.parentElement.innerHTML='<i class=\'fas fa-box\'></i>';">
                                    <?php else: ?>
                                        <div class="no-image">
                                            <i class="fas fa-box"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="product-details">
                                    <div class="product-name"><?php echo htmlspecialchars($product['name']); ?></div>
                                    <div class="product-meta">
                                        <span>ID: #<?php echo str_pad($product['id'], 3, '0', STR_PAD_LEFT); ?></span>
                                        <?php if (isset($product['created_at'])): ?>
                                        <span>Added: <?php echo date('M j, Y', strtotime($product['created_at'])); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <?php if (!empty($product['description'])): ?>
                                    <p style="margin-top: 8px; font-size: 14px; color: var(--text-light); line-height: 1.5;">
                                        <?php echo substr(htmlspecialchars($product['description']), 0, 100); ?>...
                                    </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="product-category"><?php echo htmlspecialchars($product['category_name'] ?? 'Uncategorized'); ?></span>
                        </td>
                        <td class="price">Rs. <?php echo number_format($product['price'], 2); ?></td>
                        <td>
                            <?php if ($product['rating'] > 0): ?>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <?php echo number_format($product['rating'], 1); ?>
                                <?php if ($product['reviews'] > 0): ?>
                                <span style="color: var(--text-light); font-size: 13px;">(<?php echo $product['reviews']; ?>)</span>
                                <?php endif; ?>
                            </div>
                            <?php else: ?>
                            <span style="color: var(--text-light); font-size: 14px;">No ratings</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="actions">
                                <button class="btn-action btn-view" onclick="window.location.href='view-product.php?id=<?php echo $product['id']; ?>'">
                                    <i class="fas fa-eye"></i> View
                                </button>
                                <button class="btn-action btn-edit" onclick="window.location.href='edit_product.php?id=<?php echo $product['id']; ?>'">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form method="POST" action="products.php" style="display: inline;" onsubmit="return confirmDelete()">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <input type="hidden" name="delete_product" value="1">
                                    <button type="submit" class="btn-action btn-delete">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <h3>No Products Found</h3>
                <p>You haven't added any products yet. Start by adding your first product to your store.</p>
                <button class="btn-add" onclick="window.location.href='add_product.php'">
                    <i class="fas fa-plus"></i> Add Your First Product
                </button>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="footer">
            <p><i class="fas fa-database"></i> Evara Product Management System • <?php echo date('F j, Y'); ?> • Total Products: <?php echo $total_products; ?></p>
        </div>
    </div>

    <script>
        // Auto-hide message after 5 seconds
        setTimeout(function() {
            const message = document.getElementById('message');
            if (message) {
                message.style.transition = 'opacity 0.5s';
                message.style.opacity = '0';
                setTimeout(() => {
                    message.style.display = 'none';
                }, 500);
            }
        }, 5000);
        
        function confirmDelete() {
            return confirm('Are you sure you want to delete this product? This action cannot be undone.');
        }
        
        // Make table rows clickable (optional)
        document.querySelectorAll('.products-table tbody tr').forEach(row => {
            row.addEventListener('click', function(e) {
                if (!e.target.closest('.actions')) {
                    const productId = this.querySelector('input[name="product_id"]')?.value;
                    if (productId) {
                        window.location.href = 'view-product.php?id=' + productId;
                    }
                }
            });
        });
    </script>
</body>
</html>