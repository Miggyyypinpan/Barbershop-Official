<?php
// Start PHP session for user management
// Sessions are key for maintaining user state across pages
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Dynamic page title  -->
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - Barbershop' : 'Barbershop'; ?></title>
    
    <!-- Google Fonts - modern typography -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome for icons - makes design more engaging -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <!-- Custom CSS for unique design -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Main website header with responsive navigation -->
    <header>
        <div class="container nav-container">
            <!-- Logo with brand name -->
            <a href="index.php" class="logo">MANNS<span>BARBERSHOP</span></a>
            
            <!-- Mobile navigation toggle - for responsive design -->
            <button class="mobile-nav-toggle">
                <i class="fas fa-bars"></i>
            </button>
            
            <!-- Navigation menu with dynamic login/logout -->
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="index.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="booking.php" class="nav-link">Booking</a>
                </li>
                <li class="nav-item">
                    <a href="about.php" class="nav-link">About</a>
                </li>
                <li class="nav-item">
                    <a href="contact.php" class="nav-link">Contact</a>
                </li>
                <!-- Conditional nav items based on login status -->
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a href="login.php" class="nav-link">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </header>