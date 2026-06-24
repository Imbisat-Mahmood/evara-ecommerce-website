<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

/* ADD CATEGORY */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    mysqli_query($conn, "INSERT INTO categories (name) VALUES ('$name')");
    $success = "Category added successfully";
}

/* DELETE CATEGORY */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = (int) $_POST['delete_id'];
    mysqli_query($conn, "DELETE FROM categories WHERE id=$id");
    $success = "Category deleted successfully";
}

/* FETCH */
$categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Categories - Admin</title>
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
        Welcome, <?php echo $_SESSION['admin_name']; ?>
        <a href="admin_logout.php" class="btn-logout">Logout</a>
    </div>
</header>

<div class="admin-container">

<!-- SIDEBAR -->
<nav class="admin-sidebar">
    <ul class="sidebar-nav">
        <li><a href="admin_index.php">Dashboard</a></li>
        <li><a href="products.php">Products</a></li>
        <li><a href="categories.php" class="active">Categories</a></li>
        <li><a href="orders.php">Orders</a></li>
        <li><a href="customers.php">Customers</a></li>
        <li><a href="reports.php">Reports</a></li>
        <li><a href="settings.php">Settings</a></li>
    </ul>
</nav>

<!-- MAIN -->
<main class="admin-main">

    <div class="page-header">
        <h1 class="page-title">Categories</h1>
    </div>

    <?php if(isset($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <div class="content-card">
        <h3 class="card-title">Add Category</h3>
        <form method="POST" style="display:flex; gap:10px;">
            <input type="text" name="name" class="form-select" required>
            <button class="btn btn-primary" name="add_category">Add</button>
        </form>
    </div>

    <div class="content-card">
        <h3 class="card-title">All Categories</h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($c = mysqli_fetch_assoc($categories)): ?>
                <tr>
                    <td><?php echo $c['id']; ?></td>
                    <td><?php echo htmlspecialchars($c['name']); ?></td>
                    <td>
                        <form method="POST" onsubmit="return confirm('Delete category?')">
                            <input type="hidden" name="delete_id" value="<?php echo $c['id']; ?>
                            ">
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

