<?php
// Logout script for admin panel
// Handles user session termination

// Start the session to access session variables
session_start();

// Clear all session variables to log out the user
// This removes all stored user information
$_SESSION = array();

// Completely destroy the current session
// Ensures no session data remains
session_destroy();

// Redirect user to the login page after logout
// Prevents access to admin pages without authentication
header('Location: login.php');
exit;
?>