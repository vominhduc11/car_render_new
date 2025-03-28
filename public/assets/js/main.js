/**
 * Main JavaScript File
 * Contains common functionality for the application
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize Bootstrap popovers
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    const popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
    
    // Flash Messages Auto-Close
    const flashMessages = document.querySelectorAll('.alert-dismissible');
    flashMessages.forEach(function(message) {
        // Auto-close flash messages after 5 seconds
        setTimeout(function() {
            const closeButton = message.querySelector('.btn-close');
            if (closeButton) {
                closeButton.click();
            } else {
                message.remove();
            }
        }, 5000);
    });
    
    // Mobile Menu Toggle
    const navbarToggler = document.querySelector('.navbar-toggler');
    if (navbarToggler) {
        navbarToggler.addEventListener('click', function() {
            this.classList.toggle('active');
        });
    }
    
    // Admin Sidebar Toggle
    const sidebarToggle = document.querySelector('.admin-sidebar-toggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            const sidebar = document.querySelector('.admin-sidebar');
            const content = document.querySelector('.admin-content');
            sidebar.classList.toggle('collapsed');
            content.classList.toggle('expanded');
        });
    }
    
    // Mobile Admin Sidebar Toggle
    const mobileToggle = document.querySelector('.mobile-sidebar-toggle');
    if (mobileToggle) {
        mobileToggle.addEventListener('click', function() {
            const sidebar = document.querySelector('.admin-sidebar');
            sidebar.classList.toggle('mobile-open');
        });
    }
    
    // Back to Top Button
    const backToTopButton = document.querySelector('.back-to-top');
    if (backToTopButton) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add('show');
            } else {
                backToTopButton.classList.remove('show');
            }
        });
        
        backToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
    
    // Form Input Focus Effects
    const formInputs = document.querySelectorAll('.form-control, .form-select');
    formInputs.forEach(function(input) {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focus');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focus');
        });
    });
    
    // Sticky Header
    const header = document.querySelector('.main-header');
    if (header) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 50) {
                header.classList.add('sticky');
            } else {
                header.classList.remove('sticky');
            }
        });
    }
    
    // Password Toggle Visibility
    const passwordToggles = document.querySelectorAll('.password-toggle');
    passwordToggles.forEach(function(toggle) {
        toggle.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
    
    // Car Filter Price Range
    const priceRange = document.getElementById('price-range');
    const priceValue = document.getElementById('price-value');
    
    if (priceRange && priceValue) {
        priceRange.addEventListener('input', function() {
            priceValue.textContent = parseInt(this.value).toLocaleString() + ' VND';
        });
    }
    
    // Initialize Date Range Pickers
    const dateRangePickers = document.querySelectorAll('.date-range-picker');
    if (dateRangePickers.length > 0) {
        dateRangePickers.forEach(function(picker) {
            const today = new Date();
            new DateRangePicker(picker, {
                minDate: today,
                format: 'yyyy-mm-dd'
            });
        });
    }
    
    // Current Year in Footer Copyright
    const currentYearElements = document.querySelectorAll('.current-year');
    const currentYear = new Date().getFullYear();
    
    currentYearElements.forEach(function(element) {
        element.textContent = currentYear;
    });
    
    // Car Gallery Image Switcher
    const galleryThumbs = document.querySelectorAll('.gallery-thumb');
    const mainImage = document.querySelector('.main-image img');
    
    if (galleryThumbs.length > 0 && mainImage) {
        galleryThumbs.forEach(function(thumb) {
            thumb.addEventListener('click', function() {
                // Remove active class from all thumbnails
                galleryThumbs.forEach(function(t) {
                    t.classList.remove('active');
                });
                
                // Add active class to clicked thumbnail
                this.classList.add('active');
                
                // Update main image
                mainImage.src = this.getAttribute('data-src');
                mainImage.alt = this.querySelector('img').alt;
            });
        });
    }
    
    // Booking Date Validation
    const pickupDateInput = document.getElementById('pickup_date');
    const returnDateInput = document.getElementById('return_date');
    
    if (pickupDateInput && returnDateInput) {
        // Set minimum date for pickup date (today)
        const today = new Date();
        const tomorrow = new Date(today);
        tomorrow.setDate(today.getDate() + 1);
        
        const formattedToday = today.toISOString().split('T')[0];
        const formattedTomorrow = tomorrow.toISOString().split('T')[0];
        
        pickupDateInput.min = formattedToday;
        returnDateInput.min = formattedTomorrow;
        
        // Update return date minimum when pickup date changes
        pickupDateInput.addEventListener('change', function() {
            const selectedPickupDate = new Date(this.value);
            const minReturnDate = new Date(selectedPickupDate);
            minReturnDate.setDate(selectedPickupDate.getDate() + 1);
            
            const formattedMinReturnDate = minReturnDate.toISOString().split('T')[0];
            returnDateInput.min = formattedMinReturnDate;
            
            // Reset return date if it's before the minimum
            if (new Date(returnDateInput.value) < minReturnDate) {
                returnDateInput.value = formattedMinReturnDate;
            }
        });
    }
    
    // Mobile Filter Toggle
    const filterToggle = document.querySelector('.filter-toggle');
    const filterSidebar = document.querySelector('.filter-card');
    
    if (filterToggle && filterSidebar) {
        filterToggle.addEventListener('click', function() {
            filterSidebar.classList.toggle('show');
        });
    }
    
    // Car Sorting
    const sortSelect = document.getElementById('sort-by');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const sortValue = this.value;
            const carCards = document.querySelectorAll('.car-list > div');
            const carList = document.querySelector('.car-list');
            
            // Convert NodeList to Array for sorting
            const carArray = Array.from(carCards);
            
            carArray.sort(function(a, b) {
                const aValue = a.getAttribute('data-' + sortValue.split('-')[0]);
                const bValue = b.getAttribute('data-' + sortValue.split('-')[0]);
                
                if (sortValue.endsWith('-asc')) {
                    return aValue.localeCompare(bValue, undefined, {numeric: true});
                } else {
                    return bValue.localeCompare(aValue, undefined, {numeric: true});
                }
            });
            
            // Clear car list
            while (carList.firstChild) {
                carList.removeChild(carList.firstChild);
            }
            
            // Append sorted cars
            carArray.forEach(function(car) {
                carList.appendChild(car);
            });
        });
    }
});