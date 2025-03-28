<?php
// Admin Login Page for MANNS Barbershop Management System/
// Purpose: Handle admin authentication and access control

// Start PHP session to manage user authentication
session_start();

// Include essential configuration and utility files
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Check if admin is already logged in
// Redirect to dashboard if session exists
//email:admin@mannsbarbershop.com
// password:admin123
// to insert new admin, either use phpmyadmin or shell --> INSERT INTO users (name, email, password, role) VALUES ('NAME', 'name@example.com', 'PASSWORD', 'admin');
if(isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'admin') {
    header('Location: index.php');
    exit;
}

// Initialize error message variable
$error = '';

// Process login form submission /
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize user input to prevent injection attacks
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    
    // Validate input fields are not empty /
    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password';
    } else {
        try {
            // Prepare SQL statement to find admin user
            // Uses parameterized query for security
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND role = 'admin'");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            // Fetch user details from database
            $user = $stmt->fetch();
            
            if ($user) {
                // Implement password hashing for security
                // Note: Uses OLD_PASSWORD MySQL hash method
                $input_hash = '*' . strtoupper(sha1(sha1($password, true)));
                
                // Verify user credentials
                if ($input_hash === $user['password']) {
                    // Regenerate session ID to prevent session fixation
                    session_regenerate_id();

                    // Store user information in session variables
                    $_SESSION['user_id'] = $user['users_id'];
                    $_SESSION['user_name'] = $user['name'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_role'] = $user['role'];
                    
                    // Redirect to admin dashboard after successful login
                    header('Location: index.php');
                    exit;
                } else {
                    // Display generic error for security
                    $error = 'Invalid email or password';
                }
            } else {
                // Handle non-existent admin user
                $error = 'Invalid email or password';
            }
        } catch (PDOException $e) {
            // Log database-related errors
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - MANNS Barbershop</title>
    <style>
        /* CSS styles remain unchanged */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            width: 300px;
        }
        .login-container h2 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
        .btn {
            width: 100%;
            padding: 10px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        
        <!-- Display error messages if any -->
        <?php if (!empty($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <!-- Login form with email and password fields -->
        <form method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>
</html>