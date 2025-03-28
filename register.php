<?php
// Set the page title for the registration page
$pageTitle = 'Register';

// Include necessary files for header, configuration, and utility functions
require_once 'includes/header.php';
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Prevent logged-in users from accessing registration page
if(isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';   // Variable to store registration errors
$success = ''; // Variable to store success messages

// Handle registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize user inputs to prevent potential security risks
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    
    // Validate user inputs
    if (empty($name) || empty($email) || empty($password) || empty($confirmPassword)) {
        $error = 'Please fill in all fields';
    } elseif ($password !== $confirmPassword) {
        $error = 'Passwords do not match';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters long';
    } else {
        try {
            // Check if email is already registered
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $error = 'Email address already registered';
            } else {
                // Securely hash the password before storing
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                
                // Insert new user into the database
                $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $hashedPassword);
                $stmt->execute();
                
                // Set success message for user
                $success = 'Registration successful! You can now log in.';
            }
        } catch (PDOException $e) {
            // Log and display database-related errors
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}
?>

<!-- Registration Section with responsive design -->
<section class="auth">
    <div class="container">
        <div class="auth-form">
            <h2>Create an Account</h2>
            
            <!-- Display error messages if any -->
            <?php if (!empty($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <!-- Display success message after successful registration -->
            <?php if (!empty($success)): ?>
                <div class="success-message"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <!-- Registration form with input validation -->
            <form id="register-form" method="post" action="register.php">
                <div class="form-group">
                    <label for="register-name">Full Name</label>
                    <input type="text" id="register-name" name="name" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="register-email">Email</label>
                    <input type="email" id="register-email" name="email" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="register-password">Password</label>
                    <input type="password" id="register-password" name="password" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="register-confirm-password">Confirm Password</label>
                    <input type="password" id="register-confirm-password" name="confirm_password" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <!-- Full-width register button for better UX -->
                    <button type="submit" class="btn" style="width: 100%;">Register</button>
                </div>
                
                <!-- Link to login page for existing users -->
                <a href="login.php" class="auth-link">Already have an account? Login</a>
            </form>
        </div>
    </div>
</section>

<?php
// Include footer to maintain consistent page structure
require_once 'includes/footer.php';
?>