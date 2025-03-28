<?php
// Include necessary configuration and utility files
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Check if the request is a POST method (form submission)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and collect form input to prevent security risks
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $barber_id = (int)$_POST['barber'];      // Cast to integer for additional type safety
    $service_id = (int)$_POST['service'];    // Cast to integer for additional type safety
    $booking_date = sanitize($_POST['date']);
    $booking_time = sanitize($_POST['time']);
    $notes = sanitize($_POST['notes']);
    
    // Validate required fields to ensure all critical information is provided
    if (empty($name) || empty($email) || empty($phone) || empty($barber_id) || 
        empty($service_id) || empty($booking_date) || empty($booking_time)) {
        $response = [
            'status' => 'error',
            'message' => 'All fields are required except notes.'
        ];
    } else {
        try {
            // Prepare SQL statement using PDO for secure database insertion
            $stmt = $pdo->prepare("INSERT INTO bookings (name, email, phone, barber_id, service_id, booking_date, booking_time, notes) 
                                VALUES (:name, :email, :phone, :barber_id, :service_id, :booking_date, :booking_time, :notes)");
            
            // Bind parameters to prevent SQL injection
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':barber_id', $barber_id);
            $stmt->bindParam(':service_id', $service_id);
            $stmt->bindParam(':booking_date', $booking_date);
            $stmt->bindParam(':booking_time', $booking_time);
            $stmt->bindParam(':notes', $notes);
            
            // Execute the database insertion
            $stmt->execute();
            
            // Retrieve additional details for booking confirmation
            $barbers = getBarbers();
            $services = getServices();
            
            // Find matching barber name
            $barber_name = '';
            foreach ($barbers as $barber) {
                if ($barber['barbers_id'] == $barber_id) {
                    $barber_name = $barber['name'];
                    break;
                }
            }
            
            // Find matching service details
            $service_name = '';
            $service_price = 0;
            foreach ($services as $service) {
                if ($service['services_id'] == $service_id) {
                    $service_name = $service['name'];
                    $service_price = $service['price'];
                    break;
                }
            }
            
            // Prepare successful response with booking details
            $response = [
                'status' => 'success',
                'message' => 'Booking created successfully!',
                'booking' => [
                    'name' => $name,
                    'barber' => $barber_name,
                    'service' => $service_name,
                    'service_price' => $service_price,
                    'date' => $booking_date,
                    'time' => $booking_time
                ]
            ];
        } catch (PDOException $e) {
            // Handle and log any database-related errors
            $response = [
                'status' => 'error',
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }
    
    // Send JSON response back to the client
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Redirect to booking page if not a POST request
header('Location: booking.php');
exit;
?>