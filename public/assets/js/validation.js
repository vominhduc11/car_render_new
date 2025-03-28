/**
 * Form Validation JavaScript File
 * Contains client-side validation functions
 */

document.addEventListener('DOMContentLoaded', function() {
    // Get all forms with validation class
    const forms = document.querySelectorAll('.needs-validation');
    
    // Loop through forms and add validation
    Array.from(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            form.classList.add('was-validated');
        }, false);
    });
    
    // Username validation
    const usernameInputs = document.querySelectorAll('input[name="username"]');
    usernameInputs.forEach(function(input) {
        input.addEventListener('input', function() {
            const value = this.value.trim();
            
            // Check length (at least 3 characters)
            if (value.length < 3) {
                this.setCustomValidity('Username must be at least 3 characters long');
            } else {
                this.setCustomValidity('');
            }
        });
    });
    
    // Email validation
    const emailInputs = document.querySelectorAll('input[type="email"]');
    emailInputs.forEach(function(input) {
        input.addEventListener('input', function() {
            const value = this.value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (!emailRegex.test(value)) {
                this.setCustomValidity('Please enter a valid email address');
            } else {
                this.setCustomValidity('');
            }
        });
    });
    
    // Password validation
    const passwordInputs = document.querySelectorAll('input[name="password"], input[name="new_password"]');
    passwordInputs.forEach(function(input) {
        input.addEventListener('input', function() {
            const value = this.value;
            
            // Minimum length check
            if (value.length < 6) {
                this.setCustomValidity('Password must be at least 6 characters long');
                return;
            }
            
            // Optional: Check for password strength
            const hasUpperCase = /[A-Z]/.test(value);
            const hasLowerCase = /[a-z]/.test(value);
            const hasNumbers = /\d/.test(value);
            const hasSpecialChars = /[!@#$%^&*(),.?":{}|<>]/.test(value);
            
            // Create a strength indicator
            const passwordStrength = document.getElementById('password-strength');
            
            if (passwordStrength) {
                let strength = 0;
                if (hasUpperCase) strength++;
                if (hasLowerCase) strength++;
                if (hasNumbers) strength++;
                if (hasSpecialChars) strength++;
                
                let strengthText = '';
                let strengthClass = '';
                
                if (strength === 4) {
                    strengthText = 'Strong';
                    strengthClass = 'text-success';
                } else if (strength === 3) {
                    strengthText = 'Good';
                    strengthClass = 'text-info';
                } else if (strength === 2) {
                    strengthText = 'Fair';
                    strengthClass = 'text-warning';
                } else {
                    strengthText = 'Weak';
                    strengthClass = 'text-danger';
                }
                
                passwordStrength.textContent = 'Password Strength: ' + strengthText;
                passwordStrength.className = '';
                passwordStrength.classList.add(strengthClass);
            }
            
            this.setCustomValidity('');
        });
    });
    
    // Confirm password validation
    const confirmPasswordInputs = document.querySelectorAll('input[name="confirm_password"]');
    confirmPasswordInputs.forEach(function(input) {
        input.addEventListener('input', function() {
            const passwordInput = this.form.querySelector('input[name="password"], input[name="new_password"]');
            
            if (passwordInput && this.value !== passwordInput.value) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });
    });
    
    // Phone number validation
    const phoneInputs = document.querySelectorAll('input[name="phone"]');
    phoneInputs.forEach(function(input) {
        input.addEventListener('input', function() {
            const value = this.value.trim();
            const phoneRegex = /^[0-9]{10,11}$/;
            
            if (!phoneRegex.test(value)) {
                this.setCustomValidity('Please enter a valid phone number (10-11 digits)');
            } else {
                this.setCustomValidity('');
            }
        });
    });
    
    // Credit card validation
    const cardNumberInput = document.getElementById('card_number');
    if (cardNumberInput) {
        cardNumberInput.addEventListener('input', function() {
            // Remove non-digit characters
            let value = this.value.replace(/\D/g, '');
            
            // Format with spaces
            if (value.length > 0) {
                value = value.match(/.{1,4}/g).join(' ');
            }
            
            this.value = value;
            
            // Validate using Luhn algorithm
            const digits = this.value.replace(/\D/g, '');
            if (digits.length < 13 || digits.length > 19) {
                this.setCustomValidity('Please enter a valid card number');
            } else {
                // Simple Luhn check
                let sum = 0;
                let shouldDouble = false;
                
                // Loop from right to left
                for (let i = digits.length - 1; i >= 0; i--) {
                    let digit = parseInt(digits.charAt(i));
                    
                    if (shouldDouble) {
                        digit *= 2;
                        if (digit > 9) {
                            digit -= 9;
                        }
                    }
                    
                    sum += digit;
                    shouldDouble = !shouldDouble;
                }
                
                if (sum % 10 !== 0) {
                    this.setCustomValidity('Please enter a valid card number');
                } else {
                    this.setCustomValidity('');
                }
            }
        });
    }
    
    // Expiry date validation
    const expiryDateInput = document.getElementById('expiry_date');
    if (expiryDateInput) {
        expiryDateInput.addEventListener('input', function() {
            // Format as MM/YY
            let value = this.value.replace(/\D/g, '');
            
            if (value.length > 0) {
                if (value.length <= 2) {
                    this.value = value;
                } else {
                    this.value = value.substring(0, 2) + '/' + value.substring(2, 4);
                }
            }
            
            // Validate expiry date
            const today = new Date();
            const currentMonth = today.getMonth() + 1; // 1-12
            const currentYear = today.getFullYear() % 100; // Last two digits
            
            if (this.value.length === 5) {
                const [month, year] = this.value.split('/').map(Number);
                
                if (month < 1 || month > 12) {
                    this.setCustomValidity('Please enter a valid month (01-12)');
                } else if (year < currentYear || (year === currentYear && month < currentMonth)) {
                    this.setCustomValidity('Card has expired');
                } else {
                    this.setCustomValidity('');
                }
            } else {
                this.setCustomValidity('Please enter a valid expiry date (MM/YY)');
            }
        });
    }
    
    // CVV validation
    const cvvInput = document.getElementById('cvv');
    if (cvvInput) {
        cvvInput.addEventListener('input', function() {
            // Allow only digits
            this.value = this.value.replace(/\D/g, '');
            
            // Validate CVV length
            if (this.value.length < 3 || this.value.length > 4) {
                this.setCustomValidity('CVV must be 3 or 4 digits');
            } else {
                this.setCustomValidity('');
            }
        });
    }
    
    // Date validation for pickup and return dates
    const pickupDateInput = document.getElementById('pickup_date');
    const returnDateInput = document.getElementById('return_date');
    
    if (pickupDateInput && returnDateInput) {
        // Set minimum date for pickup (today)
        const today = new Date();
        const tomorrow = new Date(today);
        tomorrow.setDate(tomorrow.getDate() + 1);
        
        const formatDate = function(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        };
        
        pickupDateInput.min = formatDate(today);
        returnDateInput.min = formatDate(tomorrow);
        
        // Validate pickup date
        pickupDateInput.addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            
            if (selectedDate < today) {
                this.setCustomValidity('Pickup date cannot be in the past');
            } else {
                this.setCustomValidity('');
                
                // Update return date minimum
                const minReturnDate = new Date(selectedDate);
                minReturnDate.setDate(minReturnDate.getDate() + 1);
                returnDateInput.min = formatDate(minReturnDate);
                
                // If return date is before new minimum, update it
                if (new Date(returnDateInput.value) < minReturnDate) {
                    returnDateInput.value = formatDate(minReturnDate);
                }
            }
        });
        
        // Validate return date
        returnDateInput.addEventListener('change', function() {
            const pickupDate = new Date(pickupDateInput.value);
            const selectedDate = new Date(this.value);
            const minReturnDate = new Date(pickupDate);
            minReturnDate.setDate(minReturnDate.getDate() + 1);
            
            if (selectedDate < minReturnDate) {
                this.setCustomValidity('Return date must be at least 1 day after pickup date');
            } else {
                this.setCustomValidity('');
            }
        });
    }
    
    // File upload validation
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(function(input) {
        input.addEventListener('change', function() {
            const file = this.files[0];
            
            if (file) {
                // Check file size (max 5MB)
                const maxSize = 5 * 1024 * 1024; // 5MB in bytes
                if (file.size > maxSize) {
                    this.setCustomValidity('File size exceeds 5MB limit');
                    return;
                }
                
                // Check file type
                const acceptedTypes = this.accept.split(',').map(type => type.trim());
                const fileType = file.type;
                
                if (acceptedTypes.length > 0 && !acceptedTypes.some(type => {
                    // Handle wildcards like 'image/*'
                    if (type.endsWith('/*')) {
                        const mainType = type.split('/')[0];
                        return fileType.startsWith(mainType + '/');
                    }
                    return type === fileType;
                })) {
                    this.setCustomValidity('Invalid file type. Accepted types: ' + this.accept);
                    return;
                }
                
                this.setCustomValidity('');
            }
        });
    });
    
    // Terms and conditions checkbox validation
    const termsCheckbox = document.getElementById('terms');
    if (termsCheckbox) {
        termsCheckbox.addEventListener('change', function() {
            if (!this.checked) {
                this.setCustomValidity('You must agree to the terms and conditions');
            } else {
                this.setCustomValidity('');
            }
        });
    }
});