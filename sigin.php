<?php
session_start();
require_once 'config/db.php'; // Include database connection

// Initialize variables
$full_name = $email = $password = $confirm_password = '';
$errors = [];
$success_message = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validate full name
    if (empty($full_name)) {
        $errors['full_name'] = 'Full name is required';
    } elseif (strlen($full_name) < 2) {
        $errors['full_name'] = 'Full name must be at least 2 characters';
    }
    
    // Validate email
    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address';
    }
    
    // Validate password
    if (empty($password)) {
        $errors['password'] = 'Password is required';
    } elseif (strlen($password) < 6) {
        $errors['password'] = 'Password must be at least 6 characters';
    }
    
    // Validate confirm password
    if (empty($confirm_password)) {
        $errors['confirm_password'] = 'Please confirm your password';
    } elseif ($password !== $confirm_password) {
        $errors['confirm_password'] = 'Passwords do not match';
    }
    
    // Check if email already exists in database
    if (empty($errors) && !empty($email)) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $errors['email'] = 'This email is already registered';
        }
        $stmt->close();
    }
    
    // If no errors, process registration
    if (empty($errors)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert user into database
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'customer')");
        $stmt->bind_param("sss", $full_name, $email, $hashed_password);
        
        if ($stmt->execute()) {
            // Get the newly created user ID
            $user_id = $stmt->insert_id;
            
            // Store user data in session
            $_SESSION['user'] = [
                'id' => $user_id,
                'name' => $full_name,
                'email' => $email,
                'role' => 'customer',
                'registered_at' => date('Y-m-d H:i:s')
            ];
            
            // Set success message
            $success_message = 'Account created successfully! You are now logged in.';
            
            // Clear form fields
            $full_name = $email = $password = $confirm_password = '';
            
            // Optionally redirect to homepage
            // header('Location: index.php');
            // exit();
        } else {
            $errors['database'] = 'Registration failed. Please try again.';
        }
        $stmt->close();
    }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evara - Create Account</title>
    <!-- Use your existing CSS -->
    <link rel="stylesheet" href="style.css">
    <style>
        
    </style>
</head>
<body>

<div class="signup-page">
    <div class="signup-container">
        <div class="header-row">
            <a href="index.php">
                <img src="images/logo 1.png" alt="Evara Logo" class="logo">
            </a>
            <h2>Create Account</h2>
        </div>

        <p class="subtitle">Join Evara — Aesthetic Essentials for You</p>
        
        <?php if ($success_message): ?>
            <div class="success-message">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($errors['database'])): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($errors['database']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div>
                <label for="full_name">Full Name</label>
                <input type="text" 
                       id="full_name" 
                       name="full_name" 
                       placeholder="Enter your full name"
                       value="<?php echo htmlspecialchars($full_name); ?>"
                       <?php echo isset($errors['full_name']) ? 'class="error-input"' : ''; ?>>
                <?php if (isset($errors['full_name'])): ?>
                    <span class="error-text"><?php echo htmlspecialchars($errors['full_name']); ?></span>
                <?php endif; ?>
            </div>

            <div>
                <label for="email">Email Address</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       placeholder="Enter your email"
                       value="<?php echo htmlspecialchars($email); ?>"
                       <?php echo isset($errors['email']) ? 'class="error-input"' : ''; ?>>
                <?php if (isset($errors['email'])): ?>
                    <span class="error-text"><?php echo htmlspecialchars($errors['email']); ?></span>
                <?php endif; ?>
            </div>

            <div>
                <label for="password">Password</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       placeholder="Create a password (min. 6 characters)"
                       <?php echo isset($errors['password']) ? 'class="error-input"' : ''; ?>>
                <?php if (isset($errors['password'])): ?>
                    <span class="error-text"><?php echo htmlspecialchars($errors['password']); ?></span>
                <?php endif; ?>
            </div>

            <div>
                <label for="confirm_password">Confirm Password</label>
                <input type="password" 
                       id="confirm_password" 
                       name="confirm_password" 
                       placeholder="Re-enter password"
                       <?php echo isset($errors['confirm_password']) ? 'class="error-input"' : ''; ?>>
                <?php if (isset($errors['confirm_password'])): ?>
                    <span class="error-text"><?php echo htmlspecialchars($errors['confirm_password']); ?></span>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn">Sign Up</button>
        </form>
        
        <p class="login-link">
            Already have an account?
            <a href="login.php">Login</a>
        </p>
        
       
    </div>
</div>

</body>
</html>