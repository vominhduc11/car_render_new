<?php
/**
 * Main Application Entry
 * Loads configuration and starts the application
 */

// Load Config
require_once '../app/config/config.php';
require_once '../app/config/database.php';

// Autoload Core Libraries
spl_autoload_register(function($className) {
    // List of directories to search for class files
    $directories = [
        '../app/core/',
        '../app/controllers/',
        '../app/models/'
    ];
    
    // Loop through directories
    foreach ($directories as $directory) {
        $file = $directory . $className . '.php';
        
        // Check if file exists
        if (file_exists($file)) {
            require_once $file;
            return true;
        }
    }
    
    return false;
});

// Create App instance
$app = new App();