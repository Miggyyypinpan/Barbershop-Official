<?php
// This is the main about page for our barbershop website
// Purpose: Display information about the barbershop and our team of barbers
$pageTitle = 'About Us';

// Include common header file to maintain consistent page layout
require_once 'includes/header.php';

// Import necessary functions for retrieving barber information
require_once 'includes/functions.php';

// Fetch all barbers from the database to display on the page
$barbers = getBarbers();
?>

<!-- About Section -->
<section class="about">
    <div class="container">
        <div class="about-content">
            <div class="about-img">
                <!-- Main image representing our barbershop -->
                <img src="img/about.jpg" alt="MANNS Barbershop" class="about-img">
            </div>
            
            <div class="about-text">
                <h2>Our Story</h2>
                <!-- Paragraphs describing the barbershop's history and philosophy -->
                <p>MANNS Barbershop was established in 2015 with a vision to create a modern barbershop that honors traditional grooming techniques while embracing contemporary styles.</p>
                
                <p>What started as a small passion project has grown into a beloved establishment where clients can relax, socialize, and leave looking and feeling their best.</p>
                
                <p>Our team of skilled barbers are dedicated to their craft, continuously honing their skills and staying up-to-date with the latest trends and techniques.</p>
                
                <p>At MANNS, we believe that a great haircut is more than just a service—it's an experience. That's why we strive to create a welcoming atmosphere where everyone feels comfortable and valued.</p>
                
                <!-- Call-to-action button to book an appointment -->
                <a href="booking.php" class="btn">Book an Appointment</a>
            </div>
        </div>
    </div>
</section>

<!-- Barbers Section - Dynamically display barber profiles from database -->
<section class="barbers" style="background-color: #f5f5f5;">
    <div class="container">
        <div class="section-title">
            <h2>Meet Our Team</h2>
        </div>
        
        <!-- Grid layout to display each barber's profile -->
        <div class="barbers-grid">
            <?php foreach($barbers as $barber): ?>
                <div class="barber-card">
                    <!-- Dynamically load barber image based on their ID -->
                    <img src="img/barber-<?php echo $barber['barbers_id']; ?>.jpg" alt="<?php echo $barber['name']; ?>" class="barber-img">
                    <div class="barber-info">
                        <h3><?php echo $barber['name']; ?></h3>
                        <p><?php echo $barber['specialty']; ?></p>
                        <!-- Individual booking link for each barber -->
                        <a href="booking.php?barber=<?php echo $barber['barbers_id']; ?>" class="btn">Book with <?php echo $barber['name']; ?></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Map Location Section to help customers find our barbershop -->
<section class="contact">
    <div class="container">
        <div class="section-title">
            <h2>Find Us</h2>
        </div>
        
        <!-- Embedded Google Maps to show our exact location -->
        <div class="map-container">
        <iframe 
    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3066.4303775519934!2d-105.0437946!3d39.774896!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x876b879cac62edef%3A0x7c8fdb94250f551a!2sSpruce%20Barbershop!5e0!3m2!1sen!2sph!4v1742490259142!5m2!1sen!2sph" 
    width="100%" 
    height="450" 
    style="border:0;" 
    allowfullscreen 
    loading="lazy" 
    referrerpolicy="no-referrer-when-downgrade">
</iframe>
        </div>
    </div>
</section>

<?php
// Include footer to maintain consistent page layout
require_once 'includes/footer.php';
?>