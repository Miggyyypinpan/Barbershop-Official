<?php
// This script handles deleting a booking from the admin panel

session_start(); // Start the PHP session to manage user authentication

// Include necessary configuration and function files
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Ensure only admin users can access this page
// Redirects to login page if not an admin or not logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Retrieve the booking ID from the URL parameter
// Convert to integer to prevent SQL injection
$booking_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Process booking deletion if a valid booking ID is provided
if ($booking_id > 0) {
    try {
        // Prepare and execute SQL statement to delete the booking
        // Note: Using 'bookings_id' as the column name in the database
        $stmt = $pdo->prepare("DELETE FROM bookings WHERE bookings_id = :id");
        $stmt->bindParam(':id', $booking_id);
        $stmt->execute();

        // Redirect to bookings list with a success message
        // Uses URL parameter to display message on the next page
        header('Location: index.php?message=Booking+deleted+successfully');
        exit;
    } catch (PDOException $e) {
        // Handle database errors and redirect with an error message
        // Potential errors: database connection issues, invalid SQL, etc.
        header('Location: index.php?error=Could+not+delete+booking');
        exit;
    }
} else {
    // Handle cases with invalid or missing booking ID
    header('Location: index.php?error=Invalid+booking+ID');
    exit;
}
?>