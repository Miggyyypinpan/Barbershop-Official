<!-- Footer for barbershop website - learned about responsive design -->
<footer>
        <div class="container">
            <div class="footer-content">
                <!-- About Us section - brief company description -->
                <div class="footer-column">
                    <h3>About Us</h3>
                    <p>MANNS is a premier barbershop dedicated to providing exceptional grooming services in a relaxed and stylish environment.</p>
                </div>
                
                <!-- Quick navigation links - improve user experience -->
                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="booking.php">Book Now</a></li>
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </div>
                
                <!-- Contact information - make it easy for customers to reach out -->
                <div class="footer-column">
                    <h3>Contact Info</h3>
                    <ul class="footer-links">
                        <li><i class="fas fa-map-marker-alt"></i> 157, Dell Street, New Gelly City</li>
                        <li><i class="fas fa-phone"></i> (09) 9521 11 254</li>
                        <li><i class="fas fa-envelope"></i> mannsbarbershop1@gmail.com</li>
                        <li><i class="fas fa-clock"></i> Mon-Sat: 9am - 6pm</li>
                    </ul>
                </div>
                
                <!-- Social media links - important for online presence -->
                <div class="footer-column">
                    <h3>Follow Us</h3>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            
            <!-- Dynamic copyright year -->
            <div class="copyright">
                <p>&copy; <?php echo date('Y'); ?> MANNS Barbershop. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
    
    <script src="js/main.js"></script>
</body>
</html>