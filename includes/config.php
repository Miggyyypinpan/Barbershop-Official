<?php
// TODO: This is my database configuration file for the barbershop website

$db_host = 'localhost';      // Database host (local development environment)
$db_name = 'barbershop_db';  // Database name for my barbershop project
$db_user = 'root';           // Default MySQL username for local setup
$db_pass = '';               // Empty password for local development 

// Using PDO for secure database connection
try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    
    // Error handling and fetch mode configuration - important for robust code
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Set default fetch to associative array for easier data handling
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    // Connection successful - ready to interact with database
} catch(PDOException $e) {
    // Basic error handling - will improve in future versions
    // IMPORTANT: Remove error details in production to prevent info leakage
    $db_error = "Database connection error. Please try again later.";
}
?>