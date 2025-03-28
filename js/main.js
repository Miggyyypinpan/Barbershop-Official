// main.js
// TODO: This is the main JavaScript file for our barbershop website
// Handles user interactions like mobile navigation, booking form, and basic site functionality

document.addEventListener('DOMContentLoaded', function() {
    // Mobile navigation toggle 
    // This part handles the responsive menu for mobile devices
    const mobileNavToggle = document.querySelector('.mobile-nav-toggle');
    const navMenu = document.querySelector('.nav-menu');
    
    if (mobileNavToggle) {
        mobileNavToggle.addEventListener('click', function() {
            // Note: Toggle active class to show/hide mobile menu
            // Switch between hamburger and close icon
            navMenu.classList.toggle('active');
            const isOpen = navMenu.classList.contains('active');
            // Dynamically change icon based on menu state
            mobileNavToggle.innerHTML = isOpen ? '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>';
        });
    }

    // Booking Form Functionality
    // Key components for handling appointment bookings
    const bookingForm = document.getElementById('booking-form');
    const barberSelect = document.getElementById('barber');
    const serviceSelect = document.getElementById('service');
    const dateInput = document.getElementById('date');
    const timeSelect = document.getElementById('time');
    
    if (bookingForm) {
        // Set minimum date to today to prevent past bookings
        // Helps prevent invalid date selections
        const today = new Date();
        const yyyy = today.getFullYear();
        let mm = today.getMonth() + 1;
        let dd = today.getDate();
        
        if (mm < 10) mm = '0' + mm;
        if (dd < 10) dd = '0' + dd;
        
        const formattedToday = yyyy + '-' + mm + '-' + dd;
        dateInput.setAttribute('min', formattedToday);
        
        // Generate available time slots for booking
        populateTimeSlots();
        
        // Handle form submission with AJAX
        bookingForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate form before sending data
            // Ensures all required fields are filled
            if (!validateForm()) {
                return false;
            }
            
            // Prepare form data for server submission
            const formData = new FormData(bookingForm);
            
            // Send booking data to server using fetch API
            // Uses process_booking.php to handle server-side logic
            fetch('process_booking.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Check server response and show appropriate message
                if (data.status === 'success') {
                    showBookingConfirmation(data.booking);
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                // Error handling for network or server issues
                console.error('Error:', error);
                alert('An error occurred while processing your booking. Please try again.');
            });
        });
    }
    
    // Generate time slots dynamically
    // Creates booking time options from 9 AM to 6 PM
    function populateTimeSlots() {
        if (!timeSelect) return;
        
        timeSelect.innerHTML = '';
        
        // Create time slots with 30-minute intervals
        // Skips 6:30 PM as it's likely closing time
        for (let hour = 9; hour <= 18; hour++) {
            for (let minute of ['00', '30']) {
                if (hour === 18 && minute === '30') continue; // Skip 6:30 PM
                
                // Convert 24-hour format to 12-hour for user-friendly display
                const formattedHour = hour % 12 || 12;
                const ampm = hour < 12 ? 'AM' : 'PM';
                const timeValue = `${hour}:${minute}`;
                const timeText = `${formattedHour}:${minute} ${ampm}`;
                
                // Create and append time slot options
                const option = document.createElement('option');
                option.value = timeValue;
                option.textContent = timeText;
                timeSelect.appendChild(option);
            }
        }
    }
    
    // Basic form validation function
    // Checks if required fields are filled
    function validateForm() {
        let isValid = true;
        const requiredFields = bookingForm.querySelectorAll('[required]');
        
        // Add/remove error class based on field completion
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('error');
            } else {
                field.classList.remove('error');
            }
        });
        
        return isValid;
    }
    
    // Show booking confirmation details
    // Replaces form with a confirmation message
    function showBookingConfirmation(booking) {
        const formContainer = document.querySelector('.booking-form');
        
        // Format date in a more readable format
        const selectedDate = new Date(booking.date);
        const formattedDate = selectedDate.toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        
        // Convert time to 12-hour format
        const timeParts = booking.time.split(':');
        const hour = parseInt(timeParts[0]);
        const minute = timeParts[1];
        const formattedHour = hour % 12 || 12;
        const ampm = hour < 12 ? 'AM' : 'PM';
        const formattedTime = `${formattedHour}:${minute} ${ampm}`;
        
        // Dynamic confirmation message with booking details
        formContainer.innerHTML = `
            <div class="booking-confirmation">
                <h2>Booking Confirmed!</h2>
                <p>Thank you for booking with us. Your appointment has been saved in our system.</p>
                <p>Here are your booking details:</p>
                <ul>
                    <li><strong>Name:</strong> ${booking.name}</li>
                    <li><strong>Barber:</strong> ${booking.barber}</li>
                    <li><strong>Service:</strong> ${booking.service} ($${booking.service_price})</li>
                    <li><strong>Date:</strong> ${formattedDate}</li>
                    <li><strong>Time:</strong> ${formattedTime}</li>
                </ul>
                <p>We look forward to seeing you!</p>
                <button class="btn" onclick="window.location.reload()">Make Another Booking</button>
            </div>
        `;
    }

    // Placeholder for map initialization
    // Note: Requires Google Maps API integration
    const mapContainer = document.getElementById('map');
    if (mapContainer) {
        // TODO: Replace with actual Google Maps API implementation
        // Currently just shows a placeholder message
        mapContainer.innerHTML = `
            <div style="height: 100%; display: flex; align-items: center; justify-content: center; background-color: #f0f0f0;">
                <p>Google Map will be loaded here. You'll need to add your Google Maps API key.</p>
            </div>
        `;
    }
}
);

// Review Section Comment
// Consider for future improvements like:
// 1. More robust form validation
// 2. Client-side and server-side error handling
// 3. Accessibility improvements
// 4. Performance optimization