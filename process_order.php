<?php
session_start();
require_once __DIR__ . '/config/db.php';

// Redirect if cart is empty
if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

// Redirect if not POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: checkout.php");
    exit;
}

// Get form data
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$city = $_POST['city'] ?? '';
$country = $_POST['country'] ?? 'Pakistan';
$address = $_POST['address'] ?? '';
$total = $_POST['total'] ?? 0;
$user_id = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : null;

// Validate required fields
$errors = [];
if (empty($name)) $errors[] = "Name is required";
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required";
if (empty($phone) || strlen($phone) < 10) $errors[] = "Valid phone number is required";
if (empty($city)) $errors[] = "City is required";
if (empty($address)) $errors[] = "Address is required";
if ($total <= 0) $errors[] = "Invalid order total";

// If validation errors, redirect back with errors
if (!empty($errors)) {
    $error_string = urlencode(implode(" | ", $errors));
    header("Location: checkout.php?error=" . $error_string);
    exit;
}

try {
    // Start transaction
    $pdo->beginTransaction();
    
    // 1. Insert order into orders table (WITH user_id)
    $stmt = $pdo->prepare("
        INSERT INTO orders 
        (user_id, customer_name, customer_email, customer_phone, customer_city, 
         customer_country, customer_address, total, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Pending')
    ");
    
    $stmt->execute([
        $user_id,      // user_id (can be NULL for guest checkout)
        $name,
        $email,
        $phone,
        $city,
        $country,
        $address,
        $total
    ]);
    
    $order_id = $pdo->lastInsertId();
    
    // 2. Insert order items
    $itemStmt = $pdo->prepare("
        INSERT INTO order_items (order_id, product_id, quantity, price)
        VALUES (?, ?, ?, ?)
    ");
    
    foreach ($_SESSION['cart'] as $product_id => $item) {
        // Make sure product_id is numeric
        if (is_numeric($product_id)) {
            $itemStmt->execute([
                $order_id,
                $product_id,
                $item['quantity'],
                $item['price']
            ]);
        }
    }
    
    // Commit transaction
    $pdo->commit();
    
    // Clear cart
    unset($_SESSION['cart']);
    
    // Redirect to success page
    header("Location: order_success.php?order_id=" . $order_id);
    exit;
    
} catch (PDOException $e) {
    // Rollback on error
    $pdo->rollBack();
    
    // Log error
    error_log("Order processing error: " . $e->getMessage());
    
    // Redirect with error
    header("Location: checkout.php?error=Database error: " . urlencode($e->getMessage()));
    exit;
}
?>