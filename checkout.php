<?php
session_start();

// Redirect if cart is empty
if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

// Calculate total
$total = 0;
$cart_items = [];
foreach ($_SESSION['cart'] as $id => $item) {
    $total += $item['price'] * $item['quantity'];
    $cart_items[] = $item;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Evara</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        
    </style>
</head>
<body>

<h3>FREE SHIPPING on Orders above Rs. 2999/-</h3>

<div id="navbar">
    <a href="index.php">
        <img src="images/logo 1.png" class="logo">
    </a>
    <div class="icons">
        <a href="cart.php">🛒 Back to Cart</a>
    </div>
</div>

<div class="checkout-container">
    <h2>Checkout</h2>
    
    <?php if (isset($_GET['error'])): ?>
        <div class="error"><?php echo htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>
    
    <form action="process_order.php" method="POST" class="checkout-form" id="checkoutForm">
        
        <!-- Customer Information -->
        <div class="form-section">
            <h3>Customer Information</h3>
            
            <div class="form-group">
                <label>Full Name *</label>
                <input type="text" name="name" required value="Rayyan Ahmed">
            </div>
            
            <div class="form-group">
                <label>Email Address *</label>
                <input type="email" name="email" required value="rayyan985@gmail.com">
            </div>
            
            <div class="form-group">
                <label>Phone Number *</label>
                <input type="tel" name="phone" required value="03248932148">
            </div>
            
            <div class="form-group">
                <label>Country</label>
                <input type="text" name="country" value="Pakistan" readonly>
            </div>
            
            <div class="form-group">
                <label>City *</label>
                <select name="city" required>
                    <option value="">Select City</option>
                    <option value="Rawalpindi" selected>Rawalpindi</option>
                    <option value="Islamabad">Islamabad</option>
                    <option value="Karachi">Karachi</option>
                    <option value="Lahore">Lahore</option>
                    <option value="Faisalabad">Faisalabad</option>
                    <option value="Multan">Multan</option>
                    <option value="Peshawar">Peshawar</option>
                    <option value="Quetta">Quetta</option>
                    <option value="Gujranwala">Gujranwala</option>
                    <option value="Sialkot">Sialkot</option>
                    <option value="Hyderabad">Hyderabad</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Delivery Address *</label>
                <textarea name="address" rows="4" required placeholder="House #, Street #, Block, Area, City">Opposite to Allama Iqbal High School st#1 hs#5 HMC Road ISB</textarea>
            </div>
            
            <!-- ========== PAYMENT METHOD ========== -->
            <div class="payment-methods">
                <h3>Payment Method</h3>
                
                <!-- Cash on Delivery -->
                <label class="payment-option selected" id="codOption">
                    <input type="radio" name="payment_method" value="cod" checked required>
                    <span class="payment-icon cod-icon">💵</span>
                    <div class="payment-info">
                        <span class="payment-title">Cash on Delivery (COD)</span>
                        <span class="payment-desc">Pay when your order arrives. No online payment required.</span>
                    </div>
                </label>
                
                <!-- Credit/Debit Card -->
                <label class="payment-option disabled">
                    <input type="radio" name="payment_method" value="card" disabled>
                    <span class="payment-icon card-icon">💳</span>
                    <div class="payment-info">
                        <span class="payment-title">Credit / Debit Card</span>
                        <span class="payment-desc">Visa, MasterCard, UnionPay - Coming Soon</span>
                    </div>
                </label>
                
                <!-- Bank Transfer -->
                <label class="payment-option disabled">
                    <input type="radio" name="payment_method" value="bank" disabled>
                    <span class="payment-icon bank-icon">🏦</span>
                    <div class="payment-info">
                        <span class="payment-title">Bank Transfer / JazzCash / EasyPaisa</span>
                        <span class="payment-desc">Bank details will be provided after order - Coming Soon</span>
                    </div>
                </label>
            </div>
            
            <!-- ========== SHIPPING METHOD ========== -->
            <div class="shipping-methods">
                <h3>Shipping Method</h3>
                
                <div class="shipping-option">
                    <div class="shipping-title">Standard Delivery</div>
                    <div class="shipping-desc">
                        <?php if ($total >= 2999): ?>
                            <span style="color: #28a745; font-weight: bold;">FREE SHIPPING</span> - 
                        <?php else: ?>
                            Delivery Charges: PKR 200 - 
                        <?php endif; ?>
                        3-5 business days
                    </div>
                </div>
                
                <div class="shipping-option" style="opacity: 0.6;">
                    <div class="shipping-title">Express Delivery</div>
                    <div class="shipping-desc">PKR 500 - 1-2 business days - Coming Soon</div>
                </div>
            </div>
            
        </div>
        
        <!-- Order Summary -->
        <div class="order-summary">
            <h3>Order Summary</h3>
            
            <?php foreach ($_SESSION['cart'] as $item): ?>
                <div class="order-item">
                    <span><?php echo htmlspecialchars($item['name']); ?> × <?php echo $item['quantity']; ?></span>
                    <span>PKR <?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                </div>
            <?php endforeach; ?>
            
            <!-- Shipping Calculation -->
            <div class="order-item">
                <span>Shipping</span>
                <span>
                    <?php if ($total >= 2999): ?>
                        <span style="color: #28a745; font-weight: bold;">FREE</span>
                    <?php else: ?>
                        PKR 200.00
                    <?php endif; ?>
                </span>
            </div>
            
            <?php 
            // Calculate final total
            $shipping_charge = ($total >= 2999) ? 0 : 200;
            $final_total = $total + $shipping_charge;
            ?>
            
            <div class="order-total">
                <span>Total Amount</span>
                <span>PKR <?php echo number_format($final_total, 2); ?></span>
            </div>
            
            <input type="hidden" name="total" value="<?php echo $final_total; ?>">
            <input type="hidden" name="shipping_charge" value="<?php echo $shipping_charge; ?>">
            
            <button type="submit" class="submit-btn" name="place_order" id="placeOrderBtn">
                Place Order (PKR <?php echo number_format($final_total, 2); ?>)
            </button>
            
            <div style="margin-top: 15px; text-align: center;">
                <p style="color: #666; font-size: 12px; line-height: 1.5;">
                    By placing your order, you agree to our 
                    <a href="#" style="color: #007bff;">Terms & Conditions</a> and 
                    <a href="#" style="color: #007bff;">Privacy Policy</a>.
                </p>
                <p style="color: #666; font-size: 12px; margin-top: 5px;">
                    Delivery within 3-5 business days.<br>
                    For cash on delivery, exact change is appreciated.
                </p>
            </div>
        </div>
    </form>
</div>

<!-- JavaScript for Payment Method Selection -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Payment method selection
    const paymentOptions = document.querySelectorAll('.payment-option');
    const placeOrderBtn = document.getElementById('placeOrderBtn');
    
    paymentOptions.forEach(option => {
        const radio = option.querySelector('input[type="radio"]');
        
        option.addEventListener('click', function() {
            if (option.classList.contains('disabled')) {
                return; // Don't select disabled options
            }
            
            // Remove selected class from all options
            paymentOptions.forEach(opt => {
                opt.classList.remove('selected');
            });
            
            // Add selected class to clicked option
            option.classList.add('selected');
            
            // Check the radio button
            radio.checked = true;
        });
        
        // When radio is checked via keyboard
        radio.addEventListener('change', function() {
            if (this.checked && !option.classList.contains('disabled')) {
                paymentOptions.forEach(opt => {
                    opt.classList.remove('selected');
                });
                option.classList.add('selected');
            }
        });
    });
    
    // Form submission validation
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        const placeOrderBtn = document.getElementById('placeOrderBtn');
        
        // Disable button and show loading
        placeOrderBtn.disabled = true;
        placeOrderBtn.innerHTML = 'Processing Order...';
        placeOrderBtn.style.background = '#6c757d';
        
        // Get selected payment method
        const selectedPayment = document.querySelector('input[name="payment_method"]:checked');
        
        if (selectedPayment && selectedPayment.value === 'cod') {
            // Show COD confirmation
            if (!confirm('You selected Cash on Delivery. Pay when your order arrives. Continue?')) {
                e.preventDefault();
                placeOrderBtn.disabled = false;
                placeOrderBtn.innerHTML = 'Place Order (PKR <?php echo number_format($final_total, 2); ?>)';
                placeOrderBtn.style.background = '#28a745';
            }
        }
    });
    
    // City change event
    const citySelect = document.querySelector('select[name="city"]');
    citySelect.addEventListener('change', function() {
        const addressTextarea = document.querySelector('textarea[name="address"]');
        
        // Update address placeholder based on selected city
        const city = this.value;
        if (city) {
            addressTextarea.placeholder = `House #, Street #, Block, Area, ${city}`;
            
            // Auto-fill sample address for selected city
            const sampleAddresses = {
                'Karachi': 'House #B-25, Street #5, Block 7, Gulshan-e-Iqbal, Karachi',
                'Lahore': 'House #123, Street #45, Block C, Johar Town, Lahore',
                'Islamabad': 'House #45, Street #12, Sector G-10/2, Islamabad',
                'Rawalpindi': 'Opposite to Allama Iqbal High School st#1 hs#5 HMC Road, Rawalpindi',
                'Faisalabad': 'House #78, Street #3, Block B, Peoples Colony, Faisalabad'
            };
            
            if (sampleAddresses[city] && !addressTextarea.value) {
                addressTextarea.value = sampleAddresses[city];
            }
        }
    });
});
</script>

</body>
</html>