<?php
// admin/index.php
// comment: This is the main admin dashboard page for managing bookings

session_start();
require_once '../includes/config.php';
require_once '../includes/functions.php';

// comment: Authentication check to ensure only admin users can access this page
// Redirects to login page if user is not authenticated or not an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// comment: Fetch all bookings from the database using PDO
// Ordered by booking date and time for easy viewing
try {
    $stmt = $pdo->query("
        SELECT bookings_id, name, email, booking_date, booking_time, notes
        FROM bookings
        ORDER BY booking_date, booking_time
    ");
    $bookings = $stmt->fetchAll();
} catch (PDOException $e) {
    $bookings = [];
    $error = "Could not fetch bookings: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - MANNS Barbershop</title>
    <style>
        /* comment: Basic CSS styling for the admin dashboard */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .btn-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .actions a {
            margin-right: 10px;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        .btn-edit {
            background-color: #4CAF50;
            color: white;
        }
        .btn-delete {
            background-color: #f44336;
            color: white;
        }
        .btn-add {
            background-color: #2196F3;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 4px;
        }
        .btn-logout {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            text-decoration: none;
        }
        .actions a:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Admin Dashboard</h1>
            <!-- comment: Logout button to end admin session -->
            <a href="logout.php" class="btn-logout">Logout</a>
        </div>

        <div class="btn-container">
            <h2>Bookings</h2>
            <!-- comment: Button to add new bookings from the dashboard -->
            <a href="add_booking.php" class="btn-add">+ Add Booking</a>
        </div>

        <!-- comment: Display any errors that occurred during booking retrieval -->
        <?php if (!empty($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <!-- comment: Table to display all current bookings -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Notes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- comment: Loop through bookings and create a row for each -->
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <!-- comment: Use htmlspecialchars to prevent XSS attacks -->
                        <td><?php echo htmlspecialchars($booking['bookings_id']); ?></td>
                        <td><?php echo htmlspecialchars($booking['name']); ?></td>
                        <td><?php echo htmlspecialchars($booking['email']); ?></td>
                        <td><?php echo htmlspecialchars($booking['booking_date']); ?></td>
                        <td><?php echo htmlspecialchars($booking['booking_time']); ?></td>
                        <td><?php echo htmlspecialchars($booking['notes']); ?></td>
                        <td class="actions">
                            <!-- comment: Edit and delete actions for each booking -->
                            <a href="edit_booking.php?id=<?php echo $booking['bookings_id']; ?>" class="btn-edit">Edit</a>
                            <!-- comment: Confirmation dialog to prevent accidental deletions -->
                            <a href="delete_booking.php?id=<?php echo $booking['bookings_id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this booking?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>