<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = (int) $_POST['delete_id'];
    mysqli_query($conn, "DELETE FROM users WHERE id=$id");
    $success = "Customer deleted";
}

$users = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Customers</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="orders.css">
</head>

<body class="admin-dashboard">

<header class="admin-header">
    <div class="admin-brand"><h2>Evara Admin Dashboard</h2></div>
    <div class="admin-user">
        <?php echo $_SESSION['admin_name']; ?>
        <a href="admin_logout.php" class="btn-logout">Logout</a>
    </div>
</header>

<div class="admin-container">

<nav class="admin-sidebar">
    <ul class="sidebar-nav">
        <li><a href="admin_index.php">Dashboard</a></li>
        <li><a href="products.php">Products</a></li>
        <li><a href="categories.php">Categories</a></li>
        <li><a href="orders.php">Orders</a></li>
        <li><a href="customers.php" class="active">Customers</a></li>
        <li><a href="reports.php">Reports</a></li>
        <li><a href="settings.php">Settings</a></li>
    </ul>
</nav>

<main class="admin-main">

<div class="page-header">
    <h1 class="page-title">Customers</h1>
</div>

<?php if(isset($success)): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
<?php endif; ?>

<div class="content-card">
<table class="admin-table">
<thead>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Joined</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php while($u = mysqli_fetch_assoc($users)): ?>
<tr>
<td><?php echo $u['id']; ?></td>
<td><?php echo htmlspecialchars($u['name']); ?></td>
<td><?php echo htmlspecialchars($u['email']); ?></td>
<td><?php echo date('M d, Y', strtotime($u['created_at'])); ?></td>
<td>
<form method="POST" onsubmit="return confirm('Delete customer?')">
<input type="hidden" name="delete_id" value="<?php echo $u['id']; ?>">
<button class="btn-small btn-delete">Delete</button>
</form>
</td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>

</main>
</div>
</body>
</html>
