<?php
// Start the PHP session to access session variables
session_start();

// Clear all session variables (remove user data)
$_SESSION = array();

// Completely destroy the current session for security
session_destroy();

// Redirect user to the homepage after logout
// This ensures the user can't access protected pages
header('Location: index.php');
exit;
?>