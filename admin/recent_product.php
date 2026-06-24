<?php
// recent_product.php
// Product management system with stock status editing

// Start session for messages
session_start();

// Initialize message
$message = '';

// Sample product data (In real app, this would come from database)
$products = [
    [
        'id' => 1,
        'name' => '12 Color Unlimited Writing Color Pencil',
        'price' => 100.00,
        'stock' => 0,
        'status' => 'out',
        'image' => 'https://images.unsplash.com/photo-1583484963886-cfe2bff2945f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=200&q=80'
    ],
    [
        'id' => 2,
        'name' => 'Colored Pencil Pen Set – 12 Replaceable Nibs',
        'price' => 500.00,
        'stock' => 0,
        'status' => 'out',
        'image' => 'https://images.unsplash.com/photo-1544725176-7c40e5a71c5e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=200&q=80'
    ],
    [
        'id' => 3,
        'name' => 'Colorful Rainbow Pencil',
        'price' => 60.00,
        'stock' => 0,
        'status' => 'out',
        'image' => 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=200&q=80'
    ],
    [
        'id' => 4,
        'name' => 'Pencil With Eraser Press Type 0.5mm',
        'price' => 400.00,
        'stock' => 0,
        'status' => 'out',
        'image' => 'https://images.unsplash.com/photo-1583485088034-697b5bc54ccd?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=200&q=80'
    ],
    [
        'id' => 5,
        'name' => 'Peach Cute Pencils',
        'price' => 300.00,
        'stock' => 0,
        'status' => 'out',
        'image' => 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=200&q=80'
    ]
];

// Handle stock update request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_stock'])) {
    $product_id = intval($_POST['product_id']);
    $new_status = $_POST['new_status'];
    
    // Find and update the product
    foreach ($products as &$product) {
        if ($product['id'] == $product_id) {
            if ($new_status === 'in') {
                $product['stock'] = 50;
                $product['status'] = 'in';
                $message = "Product '{$product['name']}' marked as IN STOCK with 50 units.";
            } else {
                $product['stock'] = 0;
                $product['status'] = 'out';
                $message = "Product '{$product['name']}' marked as OUT OF STOCK.";
            }
            break;
        }
    }
    
    // Store message in session
    $_SESSION['message'] = $message;
    
    // Redirect to avoid form resubmission
    header("Location: recent_product.php");
    exit();
}

// Check for stored message
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recent Products Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            color: #333;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        
        header {
            padding: 25px 30px;
            border-bottom: 1px solid #eaeaea;
        }
        
        h1 {
            color: #2c3e50;
            font-size: 28px;
            margin-bottom: 8px;
        }
        
        .subtitle {
            color: #7f8c8d;
            font-size: 16px;
        }
        
        .message {
            padding: 15px 30px;
            background-color: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
            margin: 0 30px 20px;
            border-radius: 4px;
            display: <?php echo !empty($message) ? 'block' : 'none'; ?>;
        }
        
        .products-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .products-table thead {
            background-color: #f8f9fa;
        }
        
        .products-table th {
            text-align: left;
            padding: 18px 20px;
            font-weight: 600;
            color: #2c3e50;
            border-bottom: 2px solid #eaeaea;
        }
        
        .products-table td {
            padding: 20px;
            border-bottom: 1px solid #eaeaea;
            vertical-align: middle;
        }
        
        .product-info {
            display: flex;
            align-items: center;
        }
        
        .product-image {
            width: 70px;
            height: 70px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 15px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }
        
        .product-name {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        
        .price {
            color: #27ae60;
            font-weight: 700;
            font-size: 16px;
        }
        
        .stock-status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }
        
        .in-stock {
            background-color: #d5f4e6;
            color: #27ae60;
        }
        
        .out-of-stock {
            background-color: #ffeaea;
            color: #e74c3c;
        }
        
        .actions {
            display: flex;
            gap: 10px;
        }
        
        .btn {
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            text-decoration: none;
        }
        
        .btn-view {
            background-color: #e8f4fc;
            color: #3498db;
        }
        
        .btn-view:hover {
            background-color: #d6eaf8;
        }
        
        .btn-edit {
            background-color: #f0f7ff;
            color: #2980b9;
            position: relative;
        }
        
        .btn-edit:hover {
            background-color: #e1ecf7;
        }
        
        .edit-form {
            display: inline;
        }
        
        .edit-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 10px 0;
            min-width: 180px;
            z-index: 10;
            display: none;
        }
        
        .edit-dropdown.show {
            display: block;
        }
        
        .edit-dropdown button {
            width: 100%;
            padding: 12px 20px;
            background: none;
            border: none;
            text-align: left;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #333;
            font-size: 14px;
        }
        
        .edit-dropdown button:hover {
            background-color: #f5f7fa;
        }
        
        .edit-dropdown i {
            width: 20px;
            color: #7f8c8d;
        }
        
        .form-btn {
            width: 100%;
            padding: 12px 20px;
            background: none;
            border: none;
            text-align: left;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #333;
            font-size: 14px;
            font-family: inherit;
        }
        
        .form-btn:hover {
            background-color: #f5f7fa;
        }
        
        .view-all {
            display: inline-block;
            margin: 25px 30px;
            color: #3498db;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
        }
        
        .view-all i {
            margin-left: 8px;
            transition: transform 0.3s;
        }
        
        .view-all:hover i {
            transform: translateX(5px);
        }
        
        .footer {
            padding: 20px 30px;
            border-top: 1px solid #eaeaea;
            color: #7f8c8d;
            font-size: 14px;
        }
        
        @media (max-width: 992px) {
            .products-table {
                display: block;
                overflow-x: auto;
            }
            
            .product-info {
                min-width: 250px;
            }
        }
        
        @media (max-width: 768px) {
            .container {
                border-radius: 8px;
            }
            
            header {
                padding: 20px;
            }
            
            h1 {
                font-size: 24px;
            }
            
            .products-table th, .products-table td {
                padding: 15px 10px;
            }
            
            .btn {
                padding: 7px 12px;
                font-size: 13px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Recent Products</h1>
            <p class="subtitle">Manage your product inventory and status</p>
        </header>
        
        <?php if (!empty($message)): ?>
        <div class="message" id="message">
            <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($message); ?>
        </div>
        <?php endif; ?>
        
        <table class="products-table">
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
                <?php foreach ($products as $product): ?>
                <tr>
                    <td>
                        <div class="product-info">
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
                            <div>
                                <div class="product-name"><?php echo htmlspecialchars($product['name']); ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="price">Rs. <?php echo number_format($product['price'], 2); ?></td>
                    <td><?php echo $product['stock']; ?></td>
                    <td>
                        <span class="stock-status <?php echo $product['status'] === 'in' ? 'in-stock' : 'out-of-stock'; ?>">
                            <?php echo $product['status'] === 'in' ? 'In stock' : 'Out of stock'; ?>
                        </span>
                    </td>
                    <td>
                        <div class="actions">
                            <button class="btn btn-view">
                                <i class="fas fa-eye"></i> View
                            </button>
                            <div class="edit-container">
                                <button class="btn btn-edit" onclick="toggleDropdown(<?php echo $product['id']; ?>)">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <div class="edit-dropdown" id="dropdown-<?php echo $product['id']; ?>">
                                    <form method="POST" action="recent_product.php" class="edit-form">
                                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                        <input type="hidden" name="update_stock" value="1">
                                        <input type="hidden" name="new_status" value="in">
                                        <button type="submit" class="form-btn">
                                            <i class="fas fa-check-circle"></i> Mark In Stock
                                        </button>
                                    </form>
                                    <form method="POST" action="recent_product.php" class="edit-form">
                                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                        <input type="hidden" name="update_stock" value="1">
                                        <input type="hidden" name="new_status" value="out">
                                        <button type="submit" class="form-btn">
                                            <i class="fas fa-times-circle"></i> Mark Out of Stock
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <a href="#" class="view-all">
            View All Products <i class="fas fa-arrow-right"></i>
        </a>
        
        <div class="footer">
            <p>Product inventory management system. Last updated: <?php echo date('F j, Y, g:i a'); ?></p>
        </div>
    </div>

    <script>
        // Toggle dropdown menus
        function toggleDropdown(productId) {
            const dropdown = document.getElementById('dropdown-' + productId);
            const allDropdowns = document.querySelectorAll('.edit-dropdown');
            
            // Close all other dropdowns
            allDropdowns.forEach(d => {
                if (d !== dropdown) d.classList.remove('show');
            });
            
            // Toggle current dropdown
            dropdown.classList.toggle('show');
        }
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.edit-container')) {
                document.querySelectorAll('.edit-dropdown').forEach(d => {
                    d.classList.remove('show');
                });
            }
        });
        
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
    </script>
</body>
</html>