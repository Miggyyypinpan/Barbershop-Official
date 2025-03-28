<?php
// Helper functions for the barbershop website project

/**
 * Sanitize user input to prevent XSS attacks
 * Security is crucial in web development!
 * 
 * @param string $data The input to sanitize
 * @return string Sanitized input
 */
function sanitize($data) {
    $data = trim($data);         // Remove whitespace
    $data = stripslashes($data); // Remove backslashes
    $data = htmlspecialchars($data); // Convert special characters to HTML entities
    return $data;
}

/**
 * Check user login status
 * Essential for access control and personalization
 * 
 * @return bool True if user is logged in, false otherwise
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']); // Simple session check
}

/**
 * Redirect user to another page
 * Useful for navigation and after form submissions
 * 
 * @param string $location URL to redirect to
 * @return void
 */
function redirect($location) {
    header("Location: $location"); // HTTP redirect
    exit; // Stop script execution after redirect
}

/**
 * Display error messages with consistent styling
 * Improves user feedback
 * 
 * @param string $message The error message
 * @return string HTML for the error message
 */
function displayError($message) {
    return '<div class="error-message">' . $message . '</div>';
}

/**
 * Display success messages with consistent styling
 * Provides positive user feedback
 * 
 * @param string $message The success message
 * @return string HTML for the success message
 */
function displaySuccess($message) {
    return '<div class="success-message">' . $message . '</div>';
}

/**
 * Fetch list of barbers from database
 * Dynamic data retrieval for booking page
 * 
 * @return array List of barbers
 */
function getBarbers() {
    // TODO: Replace with PDO in future for better security
    $db = new mysqli("localhost", "root", "", "barbershop_db");

    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error); // Improve error handling later
    }

    $sql = "SELECT barbers_id, name, specialty FROM barbers";
    $result = $db->query($sql);

    $barbers = [];
    while ($row = $result->fetch_assoc()) {
        $barbers[] = $row;
    }

    $db->close();
    return $barbers;
}

/**
 * Fetch list of services from database
 * Allows dynamic service display
 * 
 * @return array List of services
 */
function getServices() {
    // TODO: Replace with PDO in future for better security
    $db = new mysqli("localhost", "root", "", "barbershop_db"); 

    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error); // Improve error handling later
    }

    $sql = "SELECT services_id, name, price, description FROM services";
    $result = $db->query($sql);

    $services = [];
    while ($row = $result->fetch_assoc()) {
        $services[] = $row;
    }

    $db->close();
    return $services;
}

?>