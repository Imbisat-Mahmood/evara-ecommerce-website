<?php
session_start();
require_once '../config/db.php';

// Redirect to login if not admin
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Handle actions
$action = $_GET['action'] ?? '';
$order_id = $_GET['id'] ?? 0;

// Handle status update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $order_id = intval($_POST['order_id']);
    $new_status = mysqli_real_escape_string($conn, $_POST['status']);
    
    // Update query without updated_at column
    $update_sql = "UPDATE orders SET status = '$new_status' WHERE id = $order_id";
    
    if (mysqli_query($conn, $update_sql)) {
        $success = "Order #$order_id status updated to $new_status";
    } else {
        $error = "Error updating order: " . mysqli_error($conn);
    }
}

// Handle order deletion
if ($action == 'delete' && $order_id > 0) {
    $delete_sql = "DELETE FROM orders WHERE id = $order_id";
    if (mysqli_query($conn, $delete_sql)) {
        $success = "Order #$order_id deleted successfully";
    } else {
        $error = "Error deleting order: " . mysqli_error($conn);
    }
}

// Fetch all orders with customer info (using customer data from orders table)
$orders_query = "
    SELECT o.*, u.name as registered_customer_name
    FROM orders o 
    LEFT JOIN users u ON o.user_id = u.id 
    ORDER BY o.created_at DESC
";
$orders_result = mysqli_query($conn, $orders_query);

// Get order statuses from ENUM definition
$statuses = ['Pending', 'Processing', 'Completed', 'Cancelled']; // Capitalized as in ENUM
$current_status = $_GET['status'] ?? 'all';

// Filter orders if status selected
$filtered_orders = [];
if ($orders_result && mysqli_num_rows($orders_result) > 0) {
    while($order = mysqli_fetch_assoc($orders_result)) {
        if ($current_status == 'all' || $order['status'] == $current_status) {
            $filtered_orders[] = $order;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders - Evara Admin</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Admin CSS -->
    <link rel="stylesheet" href="admin.css">
    
    <style>
        /* Additional styles for orders page */
        
    </style>
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
                    <a href="admin_index.php">
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
                    <a href="orders.php" class="active">
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
                <li>
                    <a href="settings.php">
                        <i class="fas fa-cog"></i> Settings
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="admin-main">
            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">Manage Orders</h1>
                <div>
                    <a href="orders.php" class="btn-small btn-view">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </a>
                </div>
            </div>

            <!-- Messages -->
            <?php if(isset($success)): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                </div>
            <?php endif; ?>
            
            <?php if(isset($error)): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <!-- Status Filter -->
            <div class="status-filter">
                <a href="orders.php?status=all" class="status-btn all <?php echo $current_status == 'all' ? 'active' : ''; ?>">
                    All Orders
                </a>
                <?php foreach($statuses as $status): ?>
                    <a href="orders.php?status=<?php echo $status; ?>" class="status-btn <?php echo $status . ' ' . ($current_status == $status ? 'active' : ''); ?>">
                        <?php echo $status; ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- Orders Table -->
            <div class="content-card">
                <h3 class="card-title">
                    <?php 
                        if($current_status == 'all') {
                            echo 'All Orders';
                        } else {
                            echo $current_status . ' Orders';
                        }
                    ?>
                    <span style="font-size: 14px; color: #666; margin-left: 10px;">
                        (<?php echo count($filtered_orders); ?> orders)
                    </span>
                </h3>
                
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($filtered_orders) > 0): ?>
                            <?php foreach($filtered_orders as $order): ?>
                                <tr>
                                    <td>#<?php echo $order['id']; ?></td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($order['customer_name']); ?></strong>
                                        <?php if(!empty($order['registered_customer_name'])): ?>
                                            <br><small style="color: #666;">(Registered: <?php echo htmlspecialchars($order['registered_customer_name']); ?>)</small>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($order['customer_email']); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                                    <td>Rs. <?php echo number_format($order['total'], 2); ?></td>
                                    <td>
                                        <?php 
                                            $status_class = 'badge-' . strtolower($order['status']);
                                            echo "<span class='badge {$status_class}'>{$order['status']}</span>";
                                        ?>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-small btn-view" onclick="viewOrderDetails(<?php echo $order['id']; ?>)">
                                                <i class="fas fa-eye"></i> View
                                            </button>
                                            <button class="btn-small btn-edit" onclick="editOrder(<?php echo $order['id']; ?>, '<?php echo $order['status']; ?>')">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <a href="orders.php?action=delete&id=<?php echo $order['id']; ?>" 
                                               class="btn-small btn-delete"
                                               onclick="return confirm('Are you sure you want to delete order #<?php echo $order['id']; ?>?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                        </div>
                                        
                                        <!-- Order Details (Hidden by default) -->
                                        <div id="order-details-<?php echo $order['id']; ?>" class="order-details" style="display: none; margin-top: 15px;">
                                            <div class="details-grid">
                                                <div class="detail-item">
                                                    <div class="detail-label">Customer Information</div>
                                                    <div class="detail-value">
                                                        <strong><?php echo htmlspecialchars($order['customer_name']); ?></strong><br>
                                                        <?php echo htmlspecialchars($order['customer_email']); ?><br>
                                                        <?php echo htmlspecialchars($order['customer_phone']); ?>
                                                    </div>
                                                </div>
                                                
                                                <div class="detail-item">
                                                    <div class="detail-label">Shipping Address</div>
                                                    <div class="detail-value">
                                                        <?php echo nl2br(htmlspecialchars($order['customer_address'])); ?><br>
                                                        <?php echo htmlspecialchars($order['customer_city']); ?>, 
                                                        <?php echo htmlspecialchars($order['customer_country']); ?>
                                                    </div>
                                                </div>
                                                
                                                <div class="detail-item">
                                                    <div class="detail-label">Order Information</div>
                                                    <div class="detail-value">
                                                        Order Date: <?php echo date('F j, Y, g:i a', strtotime($order['created_at'])); ?><br>
                                                        Order ID: #<?php echo $order['id']; ?>
                                                    </div>
                                                </div>
                                                
                                                <div class="detail-item">
                                                    <div class="detail-label">Payment Information</div>
                                                    <div class="detail-value">
                                                        Amount: Rs. <?php echo number_format($order['total'], 2); ?><br>
                                                        Status: <span class="badge <?php echo $status_class; ?>"><?php echo $order['status']; ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" style="text-align: center; color: #666; padding: 40px;">
                                    <i class="fas fa-shopping-cart" style="font-size: 48px; color: #e8e6f1; margin-bottom: 15px;"></i><br>
                                    No <?php echo $current_status == 'all' ? '' : $current_status; ?> orders found
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Edit Order Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Update Order Status</h3>
                <button class="close-modal" onclick="closeModal()">&times;</button>
            </div>
            <form method="POST" action="">
                <input type="hidden" name="order_id" id="editOrderId">
                
                <div class="form-group">
                    <label class="form-label">Order Status</label>
                    <select name="status" id="editStatus" class="form-select" required>
                        <option value="Pending">Pending</option>
                        <option value="Processing">Processing</option>
                        <option value="Completed">Completed</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                    <button type="submit" name="update_status" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // View Order Details
        function viewOrderDetails(orderId) {
            const detailsDiv = document.getElementById(`order-details-${orderId}`);
            if (detailsDiv.style.display === 'none') {
                detailsDiv.style.display = 'block';
            } else {
                detailsDiv.style.display = 'none';
            }
        }
        
        // Edit Order Modal
        function editOrder(orderId, currentStatus) {
            document.getElementById('editOrderId').value = orderId;
            document.getElementById('editStatus').value = currentStatus;
            document.getElementById('editModal').style.display = 'flex';
        }
        
        // Close Modal
        function closeModal() {
            document.getElementById('editModal').style.display = 'none';
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('editModal');
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>