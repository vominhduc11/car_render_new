<?php
/**
 * Database configuration file
 * 
 * Contains database connection settings
 */

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '123456');
define('DB_NAME', 'car_rental_new');

// Database charset
define('DB_CHARSET', 'utf8mb4');

// PDO options
define('DB_ERRMODE', PDO::ERRMODE_EXCEPTION);
define('DB_PERSISTENT', true);
define('DB_EMULATE_PREPARES', false);

// Database table names
define('TABLE_USERS', 'users');
define('TABLE_CARS', 'cars');
define('TABLE_BOOKINGS', 'bookings');
define('TABLE_REVIEWS', 'reviews');
define('TABLE_SETTINGS', 'settings');

// Backup settings
define('BACKUP_DIR', APPROOT . '/backups');
define('BACKUP_FREQUENCY', 'daily'); // 'daily', 'weekly', 'manual'