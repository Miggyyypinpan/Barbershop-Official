<?php
// admin/add_booking.php
// comment: This is the page for admins to manually add new bookings

// Start PHP session for user authentication
session_start();
require_once '../includes/config.php';
require_once '../includes/functions.php';

// comment: Authentication check to ensure only admin users can access this page
// Prevents unauthorized access by redirecting non-admin users
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// comment: Fetch available barbers and services from database
// Uses custom functions defined in functions.php
$barbers = getBarbers();
$services = getServices();

// Initialize error and success message variables
$error = '';
$success = '';

// comment: Handle form submission with POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // comment: Sanitize and validate user inputs to prevent security risks
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $barber_id = (int)$_POST['barber'];
    $service_id = (int)$_POST['service'];
    $booking_date = sanitize($_POST['date']);
    $booking_time = sanitize($_POST['time']);
    $notes = sanitize($_POST['notes'] ?? '');

    // comment: Perform server-side validation of form inputs
    if (empty($name) || empty($email) || empty($phone) || empty($booking_date) || empty($booking_time)) {
        $error = 'Please fill in all required fields';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format';
    } else {
        try {
            // comment: Prepare SQL statement to insert new booking
            // Uses prepared statement to prevent SQL injection
            $stmt = $pdo->prepare("
                INSERT INTO bookings 
                (name, email, phone, barber_id, service_id, booking_date, booking_time, notes) 
                VALUES 
                (:name, :email, :phone, :barber_id, :service_id, :booking_date, :booking_time, :notes)
            ");
            
            // Execute the prepared statement with sanitized inputs
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':phone' => $phone,
                ':barber_id' => $barber_id,
                ':service_id' => $service_id,
                ':booking_date' => $booking_date,
                ':booking_time' => $booking_time,
                ':notes' => $notes
            ]);

            // comment: Show success message and reset form fields
            $success = 'Booking added successfully';
            
            // Clear form after successful submission
            $name = $email = $phone = $booking_date = $booking_time = $notes = '';
        } catch (PDOException $e) {
            // comment: Catch and display any database-related errors
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Booking - MANNS Barbershop</title>
    <style>
        /* comment: CSS styling for the add booking form 
           Uses a clean, simple design with responsive layout */
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
            max-width: 600px;
            margin: 0 auto;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, 
        .form-group select, 
        .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .error-message {
            color: red;
            margin-bottom: 15px;
        }
        .success-message {
            color: green;
            margin-bottom: 15px;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-back {
            margin-top: 10px;
            text-align: center;
        }
        .btn-back a {
            color: #333;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add New Booking</h2>
        
        <!-- comment: Display error messages if any -->
        <?php if (!empty($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <!-- comment: Display success message after successful booking -->
        <?php if (!empty($success)): ?>
            <div class="success-message"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <!-- comment: Booking form with input fields for customer details -->
        <form method="post">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" 
                       value="<?php echo htmlspecialchars($name ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" 
                       value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="tel" id="phone" name="phone" 
                       value="<?php echo htmlspecialchars($phone ?? ''); ?>" required>
            </div>
            
            <!-- comment: Dynamically populated barber selection dropdown -->
            <div class="form-group">
                <label for="barber">Barber</label>
                <select id="barber" name="barber" required>
                    <?php foreach ($barbers as $barber): ?>
                        <option value="<?php echo $barber['barbers_id']; ?>">
                            <?php echo htmlspecialchars($barber['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- comment: Dynamically populated service selection dropdown -->
            <div class="form-group">
                <label for="service">Service</label>
                <select id="service" name="service" required>
                    <?php foreach ($services as $service): ?>
                        <option value="<?php echo $service['services_id']; ?>">
                            <?php echo htmlspecialchars($service['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" id="date" name="date" 
                       value="<?php echo htmlspecialchars($booking_date ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="time">Time</label>
                <input type="time" id="time" name="time" 
                       value="<?php echo htmlspecialchars($booking_time ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="notes">Notes (Optional)</label>
                <textarea id="notes" name="notes" rows="3"><?php echo htmlspecialchars($notes ?? ''); ?></textarea>
            </div>
            
            <!-- comment: Submit button to add the booking -->
            <button type="submit" class="btn">Add Booking</button>
        </form>
        
        <!-- comment: Navigation link to return to bookings list -->
        <div class="btn-back">
            <a href="index.php">Back to Bookings</a>
        </div>
    </div>
</body>
</html>