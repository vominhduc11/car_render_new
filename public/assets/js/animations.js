/**
 * Animations JavaScript File
 * Contains animations and scroll effects
 */

document.addEventListener('DOMContentLoaded', function() {
    // Animate elements on scroll
    const animateOnScroll = function() {
        const elements = document.querySelectorAll('.animate-on-scroll');
        
        elements.forEach(function(element) {
            // Check if element is in viewport
            const elementTop = element.getBoundingClientRect().top;
            const elementVisible = 150; // Visibility threshold
            
            if (elementTop < window.innerHeight - elementVisible) {
                // Get animation type from data attribute or default to fadeIn
                const animationType = element.getAttribute('data-animation') || 'fadeIn';
                
                // Add animation class
                element.classList.add(animationType);
                element.classList.add('animated');
                
                // Apply delay if specified
                const delay = element.getAttribute('data-delay');
                if (delay) {
                    element.style.animationDelay = delay + 'ms';
                }
                
                // Apply duration if specified
                const duration = element.getAttribute('data-duration');
                if (duration) {
                    element.style.animationDuration = duration + 'ms';
                }
            }
        });
    };
    
    // Run on initial load
    animateOnScroll();
    
    // Run on scroll
    window.addEventListener('scroll', animateOnScroll);
    
    // Parallax effect for hero section
    const heroSection = document.querySelector('.hero-section');
    if (heroSection) {
        window.addEventListener('scroll', function() {
            const scrollPosition = window.pageYOffset;
            heroSection.style.backgroundPositionY = scrollPosition * 0.5 + 'px';
        });
    }
    
    // Counter animation
    const startCounterAnimation = function(element) {
        const target = parseInt(element.getAttribute('data-target'));
        const duration = parseInt(element.getAttribute('data-duration')) || 2000;
        const increment = target / (duration / 16); // 60fps
        let current = 0;
        
        const counter = setInterval(function() {
            current += increment;
            if (current >= target) {
                element.textContent = target.toLocaleString();
                clearInterval(counter);
            } else {
                element.textContent = Math.floor(current).toLocaleString();
            }
        }, 16);
    };
    
    // Initialize counters when in viewport
    const handleCounterScroll = function() {
        const counters = document.querySelectorAll('.counter');
        
        counters.forEach(function(counter) {
            // Check if counter is in viewport and hasn't been animated yet
            if (
                counter.getBoundingClientRect().top < window.innerHeight - 100 &&
                !counter.classList.contains('animated')
            ) {
                counter.classList.add('animated');
                startCounterAnimation(counter);
            }
        });
    };
    
    // Run counter animations on scroll
    window.addEventListener('scroll', handleCounterScroll);
    
    // Initialize counter animations on page load
    handleCounterScroll();
    
    // Typing effect for hero section
    const typingElement = document.querySelector('.typing-effect');
    if (typingElement) {
        const text = typingElement.getAttribute('data-text');
        const typeSpeed = parseInt(typingElement.getAttribute('data-speed')) || 100;
        
        typingElement.textContent = ''; // Clear initial text
        
        let charIndex = 0;
        const typeText = function() {
            if (charIndex < text.length) {
                typingElement.textContent += text.charAt(charIndex);
                charIndex++;
                setTimeout(typeText, typeSpeed);
            }
        };
        
        // Start typing animation
        typeText();
    }
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return; // Skip if href is just "#"
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                const headerOffset = 80; // Adjust for fixed header
                const elementPosition = targetElement.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Image gallery animation
    const galleryItems = document.querySelectorAll('.gallery-item');
    if (galleryItems.length > 0) {
        galleryItems.forEach(function(item, index) {
            // Add animation delay based on index
            item.style.animationDelay = (index * 100) + 'ms';
            
            // Add click event for zoom effect
            item.addEventListener('click', function() {
                this.classList.toggle('zoomed');
            });
        });
    }
    
    // Car hover effect
    const carCards = document.querySelectorAll('.car-card');
    if (carCards.length > 0) {
        carCards.forEach(function(card) {
            card.addEventListener('mouseenter', function() {
                this.classList.add('hover');
            });
            
            card.addEventListener('mouseleave', function() {
                this.classList.remove('hover');
            });
        });
    }
    
    // Animated number counters for stats
    const startStatCounters = function() {
        const statCounters = document.querySelectorAll('.stat-counter');
        
        statCounters.forEach(function(counter) {
            const target = parseInt(counter.getAttribute('data-count'));
            const duration = 2000; // 2 seconds
            const startTime = Date.now();
            
            const updateCounter = function() {
                const currentTime = Date.now();
                const progress = Math.min((currentTime - startTime) / duration, 1);
                const currentCount = Math.floor(progress * target);
                
                counter.textContent = currentCount.toLocaleString();
                
                if (progress < 1) {
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.textContent = target.toLocaleString();
                }
            };
            
            updateCounter();
        });
    };
    
    // Initialize stat counters when stats section enters viewport
    const statsSection = document.querySelector('.stats-section');
    if (statsSection) {
        const observer = new IntersectionObserver(function(entries) {
            if (entries[0].isIntersecting) {
                startStatCounters();
                observer.disconnect(); // Run only once
            }
        });
        
        observer.observe(statsSection);
    }
    
    // Progress bar animation
    const animateProgressBars = function() {
        const progressBars = document.querySelectorAll('.progress-bar');
        
        progressBars.forEach(function(bar) {
            const percentage = bar.getAttribute('aria-valuenow') + '%';
            
            // Reset width to 0 before animation
            bar.style.width = '0%';
            
            // Trigger animation after a small delay
            setTimeout(function() {
                bar.style.width = percentage;
            }, 100);
        });
    };
    
    // Initialize progress bars when in viewport
    const progressSection = document.querySelector('.progress-section');
    if (progressSection) {
        const observer = new IntersectionObserver(function(entries) {
            if (entries[0].isIntersecting) {
                animateProgressBars();
                observer.disconnect(); // Run only once
            }
        });
        
        observer.observe(progressSection);
    }
    
    // Animated logo
    const logo = document.querySelector('.logo');
    if (logo) {
        logo.addEventListener('mouseenter', function() {
            this.classList.add('pulse');
        });
        
        logo.addEventListener('animationend', function() {
            this.classList.remove('pulse');
        });
    }
    
    // Scroll indicator
    const scrollIndicator = document.querySelector('.scroll-indicator');
    if (scrollIndicator) {
        // Hide scroll indicator when page is scrolled
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 100) {
                scrollIndicator.classList.add('fade-out');
            } else {
                scrollIndicator.classList.remove('fade-out');
            }
        });
    }
});