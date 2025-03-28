<?php
/**
 * Main configuration file
 * 
 * Contains all the global configuration settings for the application
 */

// Site configuration
define('SITENAME', 'Car Rental System');
define('APP_VERSION', '1.0.0');

// URL configuration
define('BASE_URL', 'http://localhost/car-rental');
define('URLROOT', BASE_URL);
define('ASSETS_URL', BASE_URL . '/assets');

// App Root
define('APPROOT', dirname(dirname(__FILE__)));

// Public folder
define('PUBLICROOT', dirname(dirname(dirname(__FILE__))) . '/public');

// Upload directories
define('UPLOAD_DIR', PUBLICROOT . '/uploads');
define('CAR_IMAGES_DIR', UPLOAD_DIR . '/cars');

// Session configuration
define('SESSION_NAME', 'car_rental_session');
define('SESSION_LIFETIME', 86400); // 24 hours

// Error reporting
define('DISPLAY_ERRORS', true);

// Set timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Default pagination limit
define('DEFAULT_RECORDS_PER_PAGE', 10);

// Initialize session
if (!isset($_SESSION)) {
    session_name(SESSION_NAME);
    session_start();
}

// Configure error reporting
if (DISPLAY_ERRORS) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}

// Initialize flash messages if not set
if (!isset($_SESSION['flash_messages'])) {
    $_SESSION['flash_messages'] = [];
}