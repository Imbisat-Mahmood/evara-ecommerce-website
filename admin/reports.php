<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

/* TOTAL ORDERS */
$total_orders = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders")
)['total'];

/* TOTAL REVENUE (COMPLETED ONLY) */
$total_revenue = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT SUM(total) AS revenue FROM orders WHERE status='Completed'")
)['revenue'] ?? 0;

/* TOTAL CUSTOMERS */
$total_customers = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM users")
)['total'];

/* ORDERS BY STATUS (FOR TABLE) */
$status_table = mysqli_query($conn, "
    SELECT status, COUNT(*) AS count 
    FROM orders 
    GROUP BY status
");

/* ORDERS BY STATUS (FOR CHART) */
$status_chart = mysqli_query($conn, "
    SELECT status, COUNT(*) AS total 
    FROM orders 
    GROUP BY status
");

$statuses = [];
$status_counts = [];

while ($row = mysqli_fetch_assoc($status_chart)) {
    $statuses[] = $row['status'];
    $status_counts[] = $row['total'];
}

/* MONTHLY REVENUE (LINE CHART) */
$revenue_chart = mysqli_query($conn, "
    SELECT MONTH(created_at) AS month, SUM(total) AS revenue
    FROM orders
    WHERE status = 'Completed'
    GROUP BY MONTH(created_at)
");

$months = [];
$revenues = [];

while ($row = mysqli_fetch_assoc($revenue_chart)) {
    $months[] = date("F", mktime(0, 0, 0, $row['month'], 1));
    $revenues[] = $row['revenue'];
}

/* RECENT ORDERS */
$recent_orders = mysqli_query($conn, "
    SELECT id, customer_name, total, status, created_at
    FROM orders
    ORDER BY created_at DESC
    LIMIT 5
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reports - Evara Admin</title>

    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="orders.css">
</head>

<body class="admin-dashboard">

<!-- HEADER -->
<header class="admin-header">
    <div class="admin-brand">
        <h2>Evara Admin Dashboard</h2>
    </div>
    <div class="admin-user">
        <?php echo htmlspecialchars($_SESSION['admin_name']); ?>
        <a href="admin_logout.php" class="btn-logout">Logout</a>
    </div>
</header>

<div class="admin-container">

<!-- SIDEBAR -->
<nav class="admin-sidebar">
    <ul class="sidebar-nav">
        <li><a href="admin_index.php">Dashboard</a></li>
        <li><a href="products.php">Products</a></li>
        <li><a href="categories.php">Categories</a></li>
        <li><a href="orders.php">Orders</a></li>
        <li><a href="customers.php">Customers</a></li>
        <li><a href="reports.php" class="active">Reports</a></li>
        <li><a href="settings.php">Settings</a></li>
    </ul>
</nav>

<!-- MAIN CONTENT -->
<main class="admin-main">

    <!-- PAGE HEADER -->
    <div class="page-header">
        <h1 class="page-title">Reports Overview</h1>
    </div>

    <!-- STATS CARDS -->
    <div class="details-grid">

        <div class="detail-item">
            <div class="detail-label">Total Orders</div>
            <div class="detail-value"><?php echo $total_orders; ?></div>
        </div>

        <div class="detail-item">
            <div class="detail-label">Completed Revenue</div>
            <div class="detail-value">Rs. <?php echo number_format($total_revenue, 2); ?></div>
        </div>

        <div class="detail-item">
            <div class="detail-label">Total Customers</div>
            <div class="detail-value"><?php echo $total_customers; ?></div>
        </div>

    </div>

    <!-- CHARTS -->
    <div class="details-grid">

        <div class="detail-item">
            <h3 class="card-title">Orders by Status</h3>
            <canvas id="statusChart" height="220"></canvas>
        </div>

        <div class="detail-item">
            <h3 class="card-title">Monthly Revenue</h3>
            <canvas id="revenueChart" height="220"></canvas>
        </div>

    </div>

    <!-- ORDERS BY STATUS TABLE -->
    <div class="content-card">
        <h3 class="card-title">Orders by Status (Table)</h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Total Orders</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($status_table)): ?>
                <tr>
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo $row['count']; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- RECENT ORDERS -->
    <div class="content-card">
        <h3 class="card-title">Recent Orders</h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while($order = mysqli_fetch_assoc($recent_orders)): ?>
                <tr>
                    <td>#<?php echo $order['id']; ?></td>
                    <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                    <td>Rs. <?php echo number_format($order['total'], 2); ?></td>
                    <td><?php echo $order['status']; ?></td>
                    <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</main>
</div>

<!-- CHART.JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
/* ORDERS BY STATUS - DOUGHNUT */
new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: <?php echo json_encode($statuses); ?>,
        datasets: [{
            data: <?php echo json_encode($status_counts); ?>,
            backgroundColor: [
                '#ff9800',
                '#2196f3',
                '#4caf50',
                '#f44336'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});

/* MONTHLY REVENUE - LINE */
new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
        labels: <?php echo json_encode($months); ?>,
        datasets: [{
            label: 'Revenue (Rs)',
            data: <?php echo json_encode($revenues); ?>,
            borderColor: '#7c3aed',
            backgroundColor: 'rgba(124,58,237,0.1)',
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>

</body>
</html>
