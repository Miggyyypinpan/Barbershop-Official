<?php
// Set the page title for the login page
$pageTitle = 'Login';

// Include necessary files for header, configuration, and utility functions
require_once 'includes/header.php';
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Redirect already logged-in users to the homepage
// This prevents logged-in users from accessing the login page again
if(isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$error = ''; // Variable to store any login error messages

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize user input to prevent potential security risks
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    
    // Validate that both email and password are provided
    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password';
    } else {
        try {
            // Prepare a SQL statement to find user by email (using prepared statement for security)
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            // Fetch the user record
            $user = $stmt->fetch();
            
            // Verify password using built-in password_verify function
            if ($user && password_verify($password, $user['password'])) {
                // Regenerate session ID for security
                session_regenerate_id();
                
                // Store user details in session for later use
                $_SESSION['user_id'] = $user['users_id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
                
                // Redirect based on user role (admin or regular user)
                if ($user['role'] === 'admin') {
                    header('Location: admin.php');
                } else {
                    header('Location: index.php');
                }
                exit;
            } else {
                // Generic error message to prevent user enumeration
                $error = 'Invalid email or password';
            }
        } catch (PDOException $e) {
            // Log database errors securely
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}
?>

<!-- Login Section with responsive design -->
<section class="auth">
    <div class="container">
        <div class="auth-form">
            <h2>Login to Your Account</h2>
            
            <!-- Display error messages if any -->
            <?php if (!empty($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <!-- Login form with input validation -->
            <form id="login-form" method="post" action="login.php">
                <div class="form-group">
                    <label for="login-email">Email</label>
                    <input type="email" id="login-email" name="email" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="login-password">Password</label>
                    <input type="password" id="login-password" name="password" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <!-- Full-width login button for better UX -->
                    <button type="submit" class="btn" style="width: 100%;">Login</button>
                </div>
                
                <!-- Link to registration page for new users -->
                <a href="register.php" class="auth-link">Don't have an account? Register</a>
            </form>
        </div>
    </div>
</section>

<?php
// Include footer to maintain consistent page structure
require_once 'includes/footer.php';
?>