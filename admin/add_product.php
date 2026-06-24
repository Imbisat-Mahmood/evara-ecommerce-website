<?php
// /admin/add-product.php
session_start();
require_once __DIR__ . '/../config/db.php';

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

$message = '';
$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $name = $_POST['name'] ?? '';
        $category_id = $_POST['category_id'] ?? '';
        $price = $_POST['price'] ?? '';
        $description = $_POST['description'] ?? '';
        $rating = $_POST['rating'] ?? 0;
        $reviews = $_POST['reviews'] ?? 0;
        
        // Handle image upload
        $image = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../../uploads/products/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
            $targetPath = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $image = '/uploads/products/' . $fileName;
            }
        }
        
        // Insert product
        $stmt = $pdo->prepare("
            INSERT INTO products (category_id, name, price, image, description, rating, reviews) 
            VALUES (:category_id, :name, :price, :image, :description, :rating, :reviews)
        ");
        
        $stmt->execute([
            ':category_id' => $category_id,
            ':name' => $name,
            ':price' => $price,
            ':image' => $image,
            ':description' => $description,
            ':rating' => $rating,
            ':reviews' => $reviews
        ]);
        
        $_SESSION['message'] = "✅ Product added successfully!";
        header("Location: products.php");
        exit();
        
    } catch(PDOException $e) {
        $message = "❌ Error adding product: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Evara Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Use same sidebar styles from products.php */
        :root {
            --sidebar-bg: rgb(234, 168, 207);
            --sidebar-hover: #242627;
            --sidebar-text: #1f2121;
            --sidebar-active: #3498db;
            --primary-color: #3498db;
            --secondary-color: #2ecc71;
            --danger-color: #e74c3c;
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
        
        .nav-item:hover, .nav-item.active {
            background-color: var(--sidebar-hover);
            color: white;
            border-left-color: var(--sidebar-active);
        }
        
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 30px;
        }
        
        .header {
            background-color: var(--card-bg);
            padding: 25px 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.08);
        }
        
        .header h1 {
            color: var(--text-dark);
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .back-link {
            color: var(--primary-color);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 15px;
            margin-top: 10px;
        }
        
        .back-link:hover {
            text-decoration: underline;
        }
        
        .form-container {
            background-color: var(--card-bg);
            border-radius: 12px;
            padding: 35px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: var(--text-dark);
            font-size: 15px;
        }
        
        .form-control {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            font-size: 15px;
            transition: border-color 0.3s ease;
            background-color: white;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }
        
        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }
        
        .image-preview {
            width: 150px;
            height: 150px;
            border-radius: 10px;
            background-color: #f8f9fa;
            border: 2px dashed var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin-top: 10px;
        }
        
        .image-preview img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }
        
        .btn {
            padding: 14px 28px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), #2980b9);
            color: white;
            box-shadow: 0 3px 12px rgba(52, 152, 219, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 18px rgba(52, 152, 219, 0.4);
        }
        
        .btn-secondary {
            background-color: #f8f9fa;
            color: var(--text-dark);
            border: 1px solid var(--border-color);
        }
        
        .btn-secondary:hover {
            background-color: #e9ecef;
        }
        
        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 35px;
            padding-top: 25px;
            border-top: 1px solid var(--border-color);
        }
        
        .message {
            padding: 18px 25px;
            background-color: #f8d7da;
            color: #721c24;
            border-left: 5px solid var(--danger-color);
            margin-bottom: 25px;
            border-radius: 8px;
            display: <?php echo !empty($message) ? 'flex' : 'none'; ?>;
            align-items: center;
            gap: 12px;
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
            
            .form-row {
                grid-template-columns: 1fr;
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
            <li><a href="dashboard.php" class="nav-item"><i class="fas fa-home"></i> <span class="nav-text">Dashboard</span></a></li>
            <li><a href="products.php" class="nav-item"><i class="fas fa-box"></i> <span class="nav-text">Products</span></a></li>
            <li><a href="add-product.php" class="nav-item active"><i class="fas fa-plus-circle"></i> <span class="nav-text">Add Product</span></a></li>
            <li><a href="categories.php" class="nav-item"><i class="fas fa-tags"></i> <span class="nav-text">Categories</span></a></li>
            <li><a href="orders.php" class="nav-item"><i class="fas fa-shopping-cart"></i> <span class="nav-text">Orders</span></a></li>
            <li><a href="customers.php" class="nav-item"><i class="fas fa-users"></i> <span class="nav-text">Customers</span></a></li>
            <li><a href="reports.php" class="nav-item"><i class="fas fa-chart-bar"></i> <span class="nav-text">Reports</span></a></li>
            
        </ul>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <h1>Add New Product</h1>
            <a href="products.php" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Products
            </a>
        </div>
        
        <?php if (!empty($message)): ?>
        <div class="message">
            <i class="fas fa-exclamation-circle"></i> 
            <?php echo htmlspecialchars($message); ?>
        </div>
        <?php endif; ?>
        
        <div class="form-container">
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Product Name *</label>
                        <input type="text" name="name" class="form-control" required 
                               placeholder="Enter product name">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Category *</label>
                        <select name="category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['id']; ?>">
                                <?php echo htmlspecialchars($category['name']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Price (Rs.) *</label>
                        <input type="number" name="price" class="form-control" required 
                               step="0.01" min="0" placeholder="0.00">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Product Image</label>
                        <input type="file" name="image" class="form-control" 
                               accept="image/*" onchange="previewImage(this)">
                        <div class="image-preview" id="imagePreview">
                            <span style="color: var(--text-light);">No image selected</span>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" 
                              placeholder="Enter product description..."></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Rating (0-5)</label>
                        <input type="number" name="rating" class="form-control" 
                               step="0.1" min="0" max="5" value="0">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Number of Reviews</label>
                        <input type="number" name="reviews" class="form-control" 
                               min="0" value="0">
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Product
                    </button>
                    <a href="products.php" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                }
                
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.innerHTML = '<span style="color: var(--text-light);">No image selected</span>';
            }
        }
        
        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const name = this.querySelector('input[name="name"]').value.trim();
            const price = this.querySelector('input[name="price"]').value;
            const category = this.querySelector('select[name="category_id"]').value;
            
            if (!name || !price || !category) {
                e.preventDefault();
                alert('Please fill in all required fields (Name, Category, Price).');
            }
        });
    </script>
</body>
</html>