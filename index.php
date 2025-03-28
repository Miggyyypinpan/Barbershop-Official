<?php
// TODO: Set up main page title - this will show up in browser tab
$pageTitle = 'Home';

// Include header file - this contains site-wide header elements
require_once 'includes/header.php';

// Import custom functions to fetch services and barbers from database
require_once 'includes/functions.php';

// Fetch services and barbers data from database
$services = getServices();
$barbers = getBarbers();
?>

<!-- Hero Section: Welcoming and introducing the barbershop -->
<section class="hero">
    <div class="hero-content">
        <h1>Welcome to MANNS BARBERSHOP</h1>
        <p>EST 2015.</p>
        <!-- Quirky tagline to grab attention -->
        <p>MANNS BARBERSHOP YOU WILL SUDDENLY BECOME HANDSOME HERE</p>
        <p>U.S Based Barbershop</p>
        <!-- Quick link to booking page -->
        <a href="booking.php" class="btn">Book Now</a>
    </div>
</section>

<!-- Services Section: Showcase top 3 services -->
<section class="services">
    <div class="container">
        <div class="section-title">
            <h2>Our Services</h2>
        </div>
        
        <div class="services-grid">
            <?php 
            // Display first 3 services using array_slice
            // Helps prevent overwhelming users with too many options
            foreach(array_slice($services, 0, 3) as $service): ?>
                <div class="service-card">
                    <!-- Dynamic image loading based on service ID -->
                    <img src="img/service-<?php echo $service['services_id']; ?>.jpg" alt="<?php echo $service['name']; ?>" class="service-img">
                    <div class="service-content">
                        <h3><?php echo $service['name']; ?></h3>
                        <p><?php echo $service['description']; ?></p>
                        <!-- Price display for each service -->
                        <div class="service-price">$<?php echo $service['price']; ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Link to full services page -->
        <div class="text-center" style="text-align: center; margin-top: 2rem;">
            <a href="booking.php" class="btn">View All Services</a>
        </div>
    </div>
</section>

<!-- Barbers Section: Introduce the team -->
<section class="barbers">
    <div class="container">
        <div class="section-title">
            <h2>Meet Our Barbers</h2>
        </div>
        
        <div class="barbers-grid">
            <?php 
            // Loop through all barbers and create individual cards
            foreach($barbers as $barber): ?>
                <div class="barber-card">
                    <!-- Dynamic barber image loading -->
                    <img src="img/barber-<?php echo $barber['barbers_id']; ?>.jpg" alt="<?php echo $barber['name']; ?>" class="barber-img">
                    <div class="barber-info">
                        <h3><?php echo $barber['name']; ?></h3>
                        <p><?php echo $barber['specialty']; ?></p>
                        <!-- Direct booking link for specific barber -->
                        <a href="booking.php?barber=<?php echo $barber['barbers_id']; ?>" class="btn">Book with <?php echo $barber['name']; ?></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Reviews Section: Social proof and customer testimonials -->
<section class="reviews-section">
    <div class="container">
        <h2 class="section-title">What Our Clients Say</h2>
        
        <div class="reviews-slider">
            <?php
            //coded reviews 
            $reviews = [
                [
                    'rating' => 5,
                    'text' => 'Thank you for a very nice service! 👍',
                    'author' => 'Paul M'
                ],
                [
                    'rating' => 5,
                    'text' => 'Best haircut I\'ve had in years. Very professional!',
                    'author' => 'James K'
                ],
                [
                    'rating' => 5,
                    'text' => 'Great atmosphere and talented barbers. Highly recommend!',
                    'author' => 'Michael R'
                ],
                [
                    'rating' => 5,
                    'text' => 'Love the attention to detail. Will definitely be back!',
                    'author' => 'Robert T'
                ]
            ];
            
            // Generate review slides dynamically
            foreach($reviews as $index => $review) {
                // First slide is visible, others are hidden
                $style = ($index === 0) ? '' : 'style="display: none;"';
                
                echo '<div class="review-card" ' . $style . '>';
                
                // Display star rating
                echo '<div class="rating">';
                for($i = 1; $i <= 5; $i++) {
                    echo '<span class="star filled">★</span>';
                }
                echo '</div>';
                
                // Sanitize review text to prevent XSS
                echo '<p class="review-text">"' . htmlspecialchars($review['text']) . '"</p>';
                
                // Display review author
                echo '<p class="review-author">- ' . htmlspecialchars($review['author']) . '</p>';
                
                echo '</div>'; // End review-card
            }
            ?>
        </div>
        
        <!-- Navigation dots for reviews slider -->
        <div class="slider-nav">
            <?php for($i = 0; $i < count($reviews); $i++): ?>
                <span class="nav-dot <?php echo $i === 0 ? 'active' : ''; ?>" data-slide="<?php echo $i; ?>"></span>
            <?php endfor; ?>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize reviews slider variables
    let currentSlide = 0;
    const slides = document.querySelectorAll('.review-card');
    const dots = document.querySelectorAll('.nav-dot');
    const totalSlides = slides.length;
    
    // Function to update slide display
    function showSlide(n) {
        // Hide all slides and remove active state
        for(let i = 0; i < slides.length; i++) {
            slides[i].style.display = 'none';
            dots[i].classList.remove('active');
        }
        
        // Show selected slide and mark dot as active
        slides[n].style.display = 'block';
        dots[n].classList.add('active');
        currentSlide = n;
    }
    
    // Add click events to navigation dots
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            showSlide(index);
        });
    });
    
    // Automatically change slides
    function autoSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        showSlide(currentSlide);
    }
    
    // Set interval for auto-sliding (5 seconds)
    setInterval(autoSlide, 5000);
});
</script>

<style>
/* Reviews Section Styling */
.reviews-section {
    padding: 60px 0;
    background-color: #f9f7f4;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 15px;
}

.section-title {
    text-align: center;
    font-size: 2.5rem;
    margin-bottom: 40px;
    color: #2c2c2c;
    font-family: 'Playfair Display', serif;
}

.reviews-slider {
    position: relative;
    max-width: 800px;
    margin: 0 auto;
    overflow: hidden;
}

.review-card {
    background-color: #fff;
    border-radius: 8px;
    padding: 30px;
    margin: 10px auto;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    text-align: center;
}

.rating {
    margin-bottom: 15px;
}

.star {
    color: #ffd700; /* Gold color for filled stars */
    font-size: 24px;
    margin: 0 2px;
}

.review-text {
    font-size: 1.2rem;
    line-height: 1.6;
    margin-bottom: 20px;
    color: #4a4a4a;
    font-style: italic;
}

.review-author {
    font-weight: 600;
    font-size: 1.1rem;
    color: #333;
}

.slider-nav {
    text-align: center;
    margin-top: 30px;
}

.nav-dot {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: #d9d9d9;
    margin: 0 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.nav-dot.active {
    background-color: #876445; /* Barbershop brown color */
    width: 12px;
    height: 12px;
}
</style>

<?php
// Include footer file to maintain consistent site structure
require_once 'includes/footer.php';
?>