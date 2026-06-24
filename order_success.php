<?php
session_start();
$order_id = $_GET['order_id'] ?? 'N/A';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Successful - Evara</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <style>
        .success-container {
            text-align: center;
            padding: 50px 20px;
            max-width: 600px;
            margin: 50px auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .success-icon {
            font-size: 80px;
            color: #28a745;
            margin-bottom: 20px;
        }
        .success-container h1 {
            color: #28a745;
            margin-bottom: 20px;
        }
        .order-details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 30px 0;
            text-align: left;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px;
            font-size: 16px;
        }
        .btn-home {
            background: #28a745;
        }
    </style>
</head>
<body>

<h3>FREE SHIPPING on Orders above Rs. 2999/-</h3>

<div id="navbar">
    <a href="index.php">
        <img src="images/logo 1.png" class="logo">
    </a>
</div>

<div class="success-container">
    <div class="success-icon">✅</div>
    <h1>Order Successful!</h1>
    
    <div class="order-details">
        <p><strong>Order ID:</strong> #<?php echo htmlspecialchars($order_id); ?></p>
        <p><strong>Status:</strong> Pending</p>
        <p><strong>Estimated Delivery:</strong> 3-5 business days</p>
        <p>A confirmation email has been sent to your email address.</p>
        <p>Our team will contact you shortly for delivery details.</p>
    </div>
    
    <p>Thank you for shopping with Evara!</p>
    
    <div style="margin-top: 30px;">
        <a href="index.php" class="btn btn-home">Continue Shopping</a>
        <a href="order_success.php" class="btn">View My Orders</a>
    </div>
</div>

</body>
</html>