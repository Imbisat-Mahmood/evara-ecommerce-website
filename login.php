<?php
session_start();
require_once 'config/db.php';

$email = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validation
    if ($email === '') {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    }

    if ($password === '') {
        $errors['password'] = 'Password is required';
    }

    if (empty($errors)) {
        $stmt = $conn->prepare(
            "SELECT id, name, email, password, role 
             FROM users 
             WHERE email = ? LIMIT 1"
        );
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                // Set session data
                $_SESSION['user'] = [
                    'id'    => $user['id'],
                    'name'  => $user['name'],
                    'email' => $user['email'],
                    'role'  => $user['role']
                ];
                
                // Redirect based on role
                if ($user['role'] === 'admin') {
                    // Set admin session separately for admin panel
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_id'] = $user['id'];
                    $_SESSION['admin_name'] = $user['name'];
                    $_SESSION['admin_email'] = $user['email'];
                    $_SESSION['admin_role'] = $user['role'];
                    
                    // Redirect to admin dashboard
                    header('Location: admin/admin_index.php');
                } else {
                    // Redirect regular users to home page
                    header('Location: index.php');
                }
                exit();
            } else {
                $errors['password'] = 'Incorrect password';
            }
        } else {
            $errors['email'] = 'Account not found';
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Evara – Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- MAIN SITE CSS -->
<link rel="stylesheet" href="style.css">

<!-- LOGIN-ONLY CSS (SAFE / SCOPED) -->
<style>
    
    
</style>
</head>

<body>

<div class="login-page">
    <div class="login-container">

        <div class="header-row">
            <a href="index.php">
                <img src="images/logo 1.png" class="logo" alt="Evara">
            </a>
            <h2>Login</h2>
        </div>

        <p class="subtitle">Welcome back to Evara</p>

        <form method="POST">
            <label>Email Address</label>
            <input type="email" name="email"
                   value="<?= htmlspecialchars($email) ?>"
                   class="<?= isset($errors['email']) ? 'error-input' : '' ?>"
                   placeholder="Enter your email">
            <?php if(isset($errors['email'])): ?>
                <span class="error-text"><?= $errors['email'] ?></span>
            <?php endif; ?>

            <label>Password</label>
            <input type="password" name="password"
                   class="<?= isset($errors['password']) ? 'error-input' : '' ?>"
                   placeholder="Enter your password">
            <?php if(isset($errors['password'])): ?>
                <span class="error-text"><?= $errors['password'] ?></span>
            <?php endif; ?>

            <button class="btn" type="submit">Login</button>
        </form>

        <p class="signup-link">
            Don't have an account?
            <a href="sigin.php">Sign Up</a>
        </p>

       

       

    </div>
</div>

<!-- Optional: JavaScript for better UX -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Clear error on input focus
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.classList.remove('error-input');
                const errorSpan = this.nextElementSibling;
                if (errorSpan && errorSpan.classList.contains('error-text')) {
                    errorSpan.style.display = 'none';
                }
            });
        });
    });
</script>

</body>
</html>