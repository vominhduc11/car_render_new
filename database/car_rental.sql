-- Car Rental System Database Schema

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- Database: `car_rental`
CREATE DATABASE IF NOT EXISTS `car_rental` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `car_rental`;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text DEFAULT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `year` int(4) NOT NULL,
  `license_plate` varchar(20) NOT NULL,
  `color` varchar(30) NOT NULL,
  `seats` int(2) NOT NULL,
  `transmission` enum('auto','manual') NOT NULL,
  `fuel` varchar(20) NOT NULL,
  `price_per_day` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('available','maintenance','rented') NOT NULL DEFAULT 'available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `license_plate` (`license_plate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `pickup_date` date NOT NULL,
  `return_date` date NOT NULL,
  `pickup_location` varchar(255) NOT NULL,
  `return_location` varchar(255) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','completed','cancelled') NOT NULL DEFAULT 'pending',
  `payment_status` enum('pending','paid') NOT NULL DEFAULT 'pending',
  `admin_notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `car_id` (`car_id`),
  CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `rating` int(1) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `car_id` (`car_id`),
  KEY `booking_id` (`booking_id`),
  CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_ibfk_3` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(50) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Default admin user
--

INSERT INTO `users` (`username`, `password`, `email`, `full_name`, `phone`, `address`, `role`) VALUES
('admin', '$2y$10$SvS/QdKcxVVEqbfduvOgqOnlDXb/Z8JbM3e2QGvqFbjRsOn6AeNSu', 'admin@car-rental.com', 'System Administrator', '0987654321', 'Car Rental HQ', 'admin');

--
-- Default settings
--

INSERT INTO `settings` (`setting_key`, `setting_value`) VALUES
('company_name', 'Car Rental'),
('company_address', '123 Đường ABC, Quận XYZ, TP. Hồ Chí Minh'),
('company_phone', '0987654321'),
('company_email', 'info@car-rental.com'),
('booking_limit', '3'),
('maintenance_mode', '0'),
('default_currency', 'VND'),
('tax_rate', '10'),
('min_rental_days', '1');

--
-- Sample car data
--

INSERT INTO `cars` (`brand`, `model`, `year`, `license_plate`, `color`, `seats`, `transmission`, `fuel`, `price_per_day`, `status`, `description`) VALUES
('Toyota', 'Camry', 2021, '51A-123.45', 'White', 5, 'auto', 'Gasoline', 700000, 'available', 'Comfortable sedan perfect for family trips.'),
('Honda', 'Civic', 2020, '51B-678.90', 'Black', 5, 'auto', 'Gasoline', 650000, 'available', 'Economical and reliable sedan.'),
('Mazda', 'CX-5', 2021, '51C-234.56', 'Red', 5, 'auto', 'Gasoline', 850000, 'available', 'Stylish SUV with great handling.'),
('Ford', 'Ranger', 2019, '51D-789.01', 'Blue', 5, 'manual', 'Diesel', 900000, 'available', 'Powerful pickup truck for all terrains.'),
('Hyundai', 'Accent', 2022, '51E-345.67', 'Silver', 5, 'auto', 'Gasoline', 600000, 'available', 'Fuel-efficient compact sedan.'),
('Kia', 'Seltos', 2021, '51F-890.12', 'White', 5, 'auto', 'Gasoline', 750000, 'available', 'Compact SUV with modern features.'),
('Mitsubishi', 'Xpander', 2020, '51G-456.78', 'Gray', 7, 'auto', 'Gasoline', 800000, 'available', 'Spacious MPV for family outings.'),
('Nissan', 'Navara', 2019, '51H-901.23', 'Black', 5, 'manual', 'Diesel', 950000, 'available', 'Durable pickup with comfortable interior.'),
('Suzuki', 'Ertiga', 2021, '51I-567.89', 'Silver', 7, 'auto', 'Gasoline', 750000, 'available', 'Affordable and practical MPV.'),
('Audi', 'A4', 2020, '51K-012.34', 'Black', 5, 'auto', 'Gasoline', 1500000, 'available', 'Luxury sedan with premium features.');