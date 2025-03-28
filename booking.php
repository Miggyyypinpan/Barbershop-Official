<?php
// Booking page for MANNS Barbershop website
// Goal: Allow customers to book appointments online
$pageTitle = 'Book Your Appointment';

// Include common header to maintain consistent page layout
require_once 'includes/header.php';

// Import necessary functions to fetch barbershop data
require_once 'includes/functions.php';

// Retrieve list of available barbers and services from database
$barbers = getBarbers();
$services = getServices();

// Check if a specific barber was pre-selected (e.g., from About page)
$selectedBarber = isset($_GET['barber']) ? (int)$_GET['barber'] : '';
?>

<!-- Main Booking Section -->
<section class="booking">
    <div class="container">
        <div class="section-title">
            <h2>Book Your Appointment</h2>
            <!-- Clear policy for cancellations and late arrivals -->
            <p>Cancellations or reschedules must be communicated at least one hour in advance. If you are more than 20 minutes late without prior notice, the appointment will be automatically canceled.</p>
        </div>
        
        <!-- Comprehensive Booking Form -->
<div class="booking-form">
    <form id="booking-form" method="post">
        <!-- Personal Information Section -->
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="tel" id="phone" name="phone" class="form-control" required>
            </div>
        </div>
        
        <div class="form-row">
            <!-- Dynamically populate barber dropdown from database -->
            <div class="form-group">
                <label for="barber">Choose a Barber</label>
                <select id="barber" name="barber" class="form-control" required>
                    <option value="">Select Barber</option>
                    <?php foreach($barbers as $barber): ?>
                        <option value="<?php echo $barber['barbers_id']; ?>" <?php echo ($selectedBarber == $barber['barbers_id']) ? 'selected' : ''; ?>>
                            <?php echo $barber['name']; ?> - <?php echo $barber['specialty']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <!-- Services dropdown with pricing -->
            <div class="form-group">
                <label for="service">Select Service</label>
                <select id="service" name="service" class="form-control" required>
                    <option value="">Select Service</option>
                    <?php foreach($services as $service): ?>
                        <option value="<?php echo $service['services_id']; ?>">
                            <?php echo $service['name']; ?> - $<?php echo $service['price']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        
        <div class="form-row">
            <!-- Date and Time Selection -->
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" id="date" name="date" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="time">Time</label>
                <select id="time" name="time" class="form-control" required>
                    <option value="">Select Time</option>
                    <!-- Time slots will be dynamically populated by JavaScript -->
                </select>
            </div>
        </div>
        
        <!-- Optional Notes Section -->
        <div class="form-group">
            <label for="notes">Special Requests (Optional)</label>
            <textarea id="notes" name="notes" class="form-control" rows="3"></textarea>
        </div>
        
        <button type="submit" class="btn">Book Appointment</button>
    </form>
</div>
        
        <!-- Services Overview Section -->
        <div class="section-title" style="margin-top: 4rem;">
            <h2>Our Services</h2>
        </div>
        
        <!-- Grid display of all available services -->
        <div class="services-grid">
            <?php foreach($services as $service): ?>
                <div class="service-card">
                    <img src="img/service-<?php echo $service['services_id']; ?>.jpg" alt="<?php echo $service['name']; ?>" class="service-img">
                    <div class="service-content">
                        <h3><?php echo $service['name']; ?></h3>
                        <p><?php echo $service['description']; ?></p>
                        <div class="service-price">$<?php echo $service['price']; ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php
// Include footer to maintain consistent page layout
require_once 'includes/footer.php';
?>