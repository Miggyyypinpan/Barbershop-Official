<?php
// Contact page for MANNS Barbershop website
// Purpose: Provide contact information and messaging functionality
$pageTitle = 'Contact Us';

// Include common header to maintain consistent page layout
require_once 'includes/header.php';
?>

<!-- Main Contact Section -->
<section class="contact">
    <div class="container">
        <div class="section-title">
            <h2>Contact Us</h2>
        </div>
        
        <!-- Contact Information Cards -->
        <div class="contact-info">
            <!-- Location Card -->
            <div class="contact-card">
                <div class="contact-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h3>Our Location</h3>
                <p>157, Dell Street,</p>
                <p>New Gelly City</p>
            </div>
            
            <!-- Phone Card -->
            <div class="contact-card">
                <div class="contact-icon">
                    <i class="fas fa-phone"></i>
                </div>
                <h3>Phone Number</h3>
                <p>(09) 9521 11 254</p>
            </div>
            
            <!-- Email Card -->
            <div class="contact-card">
                <div class="contact-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <h3>Email</h3>
                <p>mannsbarbershop1@gmail.com</p>
            </div>
            
            <!-- Hours of Operation Card -->
            <div class="contact-card">
                <div class="contact-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h3>Opening Hours</h3>
                <p>Monday - Friday: 9am - 6pm</p>
                <p>Saturday: 10am - 5pm</p>
                <p>Sunday: Closed</p>
            </div>
        </div>
        
        <!-- Map Location Section -->
<section class="contact">
    <div class="container">
        <div class="section-title">
            <h2>Find Us</h2>
        </div>
        
        <!-- Embedded Google Maps for precise location -->
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
        
        <!-- Customer Message Form -->
        <div class="booking-form" style="margin-top: 4rem;">
            <h2 style="text-align: center; margin-bottom: 2rem;">Send Us a Message</h2>
            <form id="contact-form">
                <!-- Name and Email in Same Row -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="contact-name">Name</label>
                        <input type="text" id="contact-name" name="name" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="contact-email">Email</label>
                        <input type="email" id="contact-email" name="email" class="form-control" required>
                    </div>
                </div>
                
                <!-- Subject Input -->
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" class="form-control" required>
                </div>
                
                <!-- Message Textarea -->
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" class="form-control" rows="5" required></textarea>
                </div>
                
                <button type="submit" class="btn">Send Message</button>
            </form>
        </div>
    </div>
</section>

<?php
// Include footer to maintain consistent page layout
require_once 'includes/footer.php';
?>