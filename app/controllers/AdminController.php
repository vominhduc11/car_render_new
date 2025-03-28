<?php
/**
 * Admin Controller
 * Handles all admin-related functionality
 */
class AdminController extends Controller {
    private $userModel;
    private $carModel;
    private $bookingModel;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->requireAdmin();
        
        $this->userModel = $this->model('User');
        $this->carModel = $this->model('Car');
        $this->bookingModel = $this->model('Booking');
    }
    
    /**
     * Admin dashboard
     */
    public function index() {
        // Get stats
        $carStats = $this->carModel->countByStatus();
        $bookingStats = $this->bookingModel->countByStatus();
        $userStats = $this->userModel->countByRole();
        
        // Get new users count for the last 30 days
        $newUsersCount = $this->userModel->getNewUsersCount(30);
        $userStats['growth'] = $userStats['total'] > 0 ? round(($newUsersCount / $userStats['total']) * 100, 1) : 0;
        
        // Calculate car growth (for demo purposes, just use a random percentage)
        $carStats['growth'] = 8.5;
        
        // Calculate booking growth (for demo purposes, just use a random percentage)
        $bookingStats['growth'] = 12.3;
        
        // Get recent bookings
        $recentBookings = $this->bookingModel->getBookings([], 'created_at', 'DESC', 5);
        
        // Get pending bookings
        $pendingBookings = $this->bookingModel->getBookings(['status' => 'pending'], 'created_at', 'DESC', 5);
        
        // Get monthly revenue
        $monthlyRevenue = $this->bookingModel->getTotalRevenue('month');
        
        // Get revenue from previous month
        $prevMonthRevenue = $this->bookingModel->getTotalRevenue('prev_month');
        
        // Calculate revenue growth percentage
        $revenueGrowthPercentage = 0;
        if ($prevMonthRevenue > 0) {
            $revenueGrowthPercentage = round((($monthlyRevenue - $prevMonthRevenue) / $prevMonthRevenue) * 100, 1);
        }
        
        // Get revenue by month for the current year
        $revenueByMonth = $this->bookingModel->getRevenueByMonth(date('Y'));
        
        // Format the data for Chart.js
        $monthNames = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
        
        $formattedRevenueByMonth = [];
        foreach ($monthNames as $index => $month) {
            $formattedRevenueByMonth[$month] = $revenueByMonth[$index + 1] ?? 0;
        }
        
        // Prepare data for view
        $data = [
            'title' => 'Admin Dashboard',
            'carStats' => $carStats,
            'bookingStats' => $bookingStats,
            'userStats' => $userStats,
            'recentBookings' => $recentBookings,
            'pendingBookings' => $pendingBookings,
            'monthlyRevenue' => $monthlyRevenue,
            'revenueGrowthPercentage' => $revenueGrowthPercentage,
            'revenueByMonth' => $formattedRevenueByMonth
        ];
        
        // Load view
        $this->view('admin/dashboard', $data);
    }
    
    /**
     * Car management
     */
    public function cars() {
        // Get current page for pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max(1, $page); // Ensure page is at least 1
        
        // Items per page
        $perPage = DEFAULT_RECORDS_PER_PAGE;
        
        // Get filter params from URL
        $filters = [
            'brand' => isset($_GET['brand']) ? trim($_GET['brand']) : '',
            'status' => isset($_GET['status']) ? trim($_GET['status']) : '',
            'search' => isset($_GET['search']) ? trim($_GET['search']) : ''
        ];
        
        // Calculate offset for pagination
        $offset = ($page - 1) * $perPage;
        
        // Get cars with pagination
        $cars = $this->carModel->getCars($filters, 'id', 'DESC', $perPage, $offset);
        
        // Get total cars count for pagination
        $totalCars = count($this->carModel->getCars($filters));
        
        // Calculate total pages
        $totalPages = ceil($totalCars / $perPage);
        
        // Get distinct car brands for filter dropdown
        $brands = $this->carModel->getBrands();
        
        // Prepare data for view
        $data = [
            'title' => 'Car Management',
            'cars' => $cars,
            'brands' => $brands,
            'filters' => $filters,
            'pagination' => [
                'page' => $page,
                'per_page' => $perPage,
                'total_records' => $totalCars,
                'total_pages' => $totalPages
            ]
        ];
        
        // Load view
        $this->view('admin/cars/index', $data);
    }
    
    /**
     * Add new car
     */
    public function addCar() {
        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Handle file upload
            $carImage = '';
            if (!empty($_FILES['image']['name'])) {
                $carImage = $this->handleFileUpload($_FILES['image'], CAR_IMAGES_DIR);
            }
            
            // Initialize data
            $data = [
                'brand' => trim($_POST['brand']),
                'model' => trim($_POST['model']),
                'year' => (int)$_POST['year'],
                'license_plate' => trim($_POST['license_plate']),
                'color' => trim($_POST['color']),
                'seats' => (int)$_POST['seats'],
                'transmission' => trim($_POST['transmission']),
                'fuel' => trim($_POST['fuel']),
                'price_per_day' => (float)$_POST['price_per_day'],
                'image' => $carImage,
                'description' => trim($_POST['description']),
                'status' => trim($_POST['status']),
                'brand_err' => '',
                'model_err' => '',
                'year_err' => '',
                'license_plate_err' => '',
                'color_err' => '',
                'seats_err' => '',
                'price_per_day_err' => ''
            ];
            
            // Validate brand
            if (empty($data['brand'])) {
                $data['brand_err'] = 'Please enter car brand';
            }
            
            // Validate model
            if (empty($data['model'])) {
                $data['model_err'] = 'Please enter car model';
            }
            
            // Validate year
            if (empty($data['year'])) {
                $data['year_err'] = 'Please enter car year';
            } elseif ($data['year'] < 1900 || $data['year'] > date('Y') + 1) {
                $data['year_err'] = 'Please enter a valid year';
            }
            
            // Validate license plate
            if (empty($data['license_plate'])) {
                $data['license_plate_err'] = 'Please enter license plate';
            } else {
                // Check if license plate already exists
                if ($this->carModel->getSingleByField('license_plate', $data['license_plate'])) {
                    $data['license_plate_err'] = 'This license plate is already registered';
                }
            }
            
            // Validate color
            if (empty($data['color'])) {
                $data['color_err'] = 'Please enter car color';
            }
            
            // Validate seats
            if (empty($data['seats'])) {
                $data['seats_err'] = 'Please enter number of seats';
            } elseif ($data['seats'] < 2 || $data['seats'] > 50) {
                $data['seats_err'] = 'Please enter a valid number of seats (2-50)';
            }
            
            // Validate price per day
            if (empty($data['price_per_day'])) {
                $data['price_per_day_err'] = 'Please enter price per day';
            } elseif ($data['price_per_day'] <= 0) {
                $data['price_per_day_err'] = 'Price must be greater than zero';
            }
            
            // Check if all errors are empty
            if (empty($data['brand_err']) && empty($data['model_err']) && 
                empty($data['year_err']) && empty($data['license_plate_err']) && 
                empty($data['color_err']) && empty($data['seats_err']) && 
                empty($data['price_per_day_err'])) {
                
                // Add car
                if ($this->carModel->addCar($data)) {
                    flash('car_success', 'Car added successfully');
                    redirect('admin/cars');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $data['title'] = 'Add New Car';
                
                $this->view('admin/cars/add', $data);
            }
        } else {
            // Initialize empty data
            $data = [
                'title' => 'Add New Car',
                'brand' => '',
                'model' => '',
                'year' => date('Y'),
                'license_plate' => '',
                'color' => '',
                'seats' => '',
                'transmission' => 'auto',
                'fuel' => 'Gasoline',
                'price_per_day' => '',
                'image' => '',
                'description' => '',
                'status' => 'available',
                'brand_err' => '',
                'model_err' => '',
                'year_err' => '',
                'license_plate_err' => '',
                'color_err' => '',
                'seats_err' => '',
                'price_per_day_err' => ''
            ];
            
            // Load view
            $this->view('admin/cars/add', $data);
        }
    }
    
    /**
     * Edit car
     * 
     * @param int $id Car ID
     */
    public function editCar($id) {
        // Get car by ID
        $car = $this->carModel->getCarById($id);
        
        // Check if car exists
        if (!$car) {
            flash('car_error', 'Car not found', 'alert alert-danger');
            redirect('admin/cars');
        }
        
        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Handle file upload
            $carImage = $car['image'];
            if (!empty($_FILES['image']['name'])) {
                $carImage = $this->handleFileUpload($_FILES['image'], CAR_IMAGES_DIR);
                
                // Delete old image if a new one is uploaded
                if ($carImage && !empty($car['image']) && file_exists(CAR_IMAGES_DIR . '/' . $car['image'])) {
                    unlink(CAR_IMAGES_DIR . '/' . $car['image']);
                }
            }
            
            // Initialize data
            $data = [
                'id' => $id,
                'brand' => trim($_POST['brand']),
                'model' => trim($_POST['model']),
                'year' => (int)$_POST['year'],
                'license_plate' => trim($_POST['license_plate']),
                'color' => trim($_POST['color']),
                'seats' => (int)$_POST['seats'],
                'transmission' => trim($_POST['transmission']),
                'fuel' => trim($_POST['fuel']),
                'price_per_day' => (float)$_POST['price_per_day'],
                'image' => $carImage,
                'description' => trim($_POST['description']),
                'status' => trim($_POST['status']),
                'brand_err' => '',
                'model_err' => '',
                'year_err' => '',
                'license_plate_err' => '',
                'color_err' => '',
                'seats_err' => '',
                'price_per_day_err' => ''
            ];
            
            // Validate brand
            if (empty($data['brand'])) {
                $data['brand_err'] = 'Please enter car brand';
            }
            
            // Validate model
            if (empty($data['model'])) {
                $data['model_err'] = 'Please enter car model';
            }
            
            // Validate year
            if (empty($data['year'])) {
                $data['year_err'] = 'Please enter car year';
            } elseif ($data['year'] < 1900 || $data['year'] > date('Y') + 1) {
                $data['year_err'] = 'Please enter a valid year';
            }
            
            // Validate license plate
            if (empty($data['license_plate'])) {
                $data['license_plate_err'] = 'Please enter license plate';
            } else {
                // Check if license plate already exists (excluding current car)
                if ($data['license_plate'] !== $car['license_plate'] && 
                    $this->carModel->getSingleByField('license_plate', $data['license_plate'])) {
                    $data['license_plate_err'] = 'This license plate is already registered';
                }
            }
            
            // Validate color
            if (empty($data['color'])) {
                $data['color_err'] = 'Please enter car color';
            }
            
            // Validate seats
            if (empty($data['seats'])) {
                $data['seats_err'] = 'Please enter number of seats';
            } elseif ($data['seats'] < 2 || $data['seats'] > 50) {
                $data['seats_err'] = 'Please enter a valid number of seats (2-50)';
            }
            
            // Validate price per day
            if (empty($data['price_per_day'])) {
                $data['price_per_day_err'] = 'Please enter price per day';
            } elseif ($data['price_per_day'] <= 0) {
                $data['price_per_day_err'] = 'Price must be greater than zero';
            }
            
            // Check if all errors are empty
            if (empty($data['brand_err']) && empty($data['model_err']) && 
                empty($data['year_err']) && empty($data['license_plate_err']) && 
                empty($data['color_err']) && empty($data['seats_err']) && 
                empty($data['price_per_day_err'])) {
                
                // Update car
                if ($this->carModel->updateCar($id, $data)) {
                    flash('car_success', 'Car updated successfully');
                    redirect('admin/cars');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $data['title'] = 'Edit Car';
                $data['car'] = $car;
                
                $this->view('admin/cars/edit', $data);
            }
        } else {
            // Initialize data with car details
            $data = [
                'title' => 'Edit Car',
                'car' => $car,
                'id' => $car['id'],
                'brand' => $car['brand'],
                'model' => $car['model'],
                'year' => $car['year'],
                'license_plate' => $car['license_plate'],
                'color' => $car['color'],
                'seats' => $car['seats'],
                'transmission' => $car['transmission'],
                'fuel' => $car['fuel'],
                'price_per_day' => $car['price_per_day'],
                'image' => $car['image'],
                'description' => $car['description'],
                'status' => $car['status'],
                'brand_err' => '',
                'model_err' => '',
                'year_err' => '',
                'license_plate_err' => '',
                'color_err' => '',
                'seats_err' => '',
                'price_per_day_err' => ''
            ];
            
            // Load view
            $this->view('admin/cars/edit', $data);
        }
    }
    
    /**
     * Delete car
     * 
     * @param int $id Car ID
     */
    public function deleteCar($id) {
        // Get car by ID
        $car = $this->carModel->getCarById($id);
        
        // Check if car exists
        if (!$car) {
            flash('car_error', 'Car not found', 'alert alert-danger');
            redirect('admin/cars');
        }
        
        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Delete car
            if ($this->carModel->deleteCar($id)) {
                // Delete car image if exists
                if (!empty($car['image']) && file_exists(CAR_IMAGES_DIR . '/' . $car['image'])) {
                    unlink(CAR_IMAGES_DIR . '/' . $car['image']);
                }
                
                flash('car_success', 'Car deleted successfully');
                redirect('admin/cars');
            } else {
                flash('car_error', 'Failed to delete car', 'alert alert-danger');
                redirect('admin/cars');
            }
        } else {
            // Prepare data for view
            $data = [
                'title' => 'Delete Car',
                'car' => $car
            ];
            
            // Load view
            $this->view('admin/cars/delete', $data);
        }
    }
    
    /**
     * Booking management
     */
    public function bookings() {
        // Get current page for pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max(1, $page); // Ensure page is at least 1
        
        // Items per page
        $perPage = DEFAULT_RECORDS_PER_PAGE;
        
        // Get filter params from URL
        $filters = [
            'status' => isset($_GET['status']) ? trim($_GET['status']) : '',
            'payment_status' => isset($_GET['payment_status']) ? trim($_GET['payment_status']) : '',
            'search' => isset($_GET['search']) ? trim($_GET['search']) : '',
            'date_from' => isset($_GET['date_from']) ? trim($_GET['date_from']) : '',
            'date_to' => isset($_GET['date_to']) ? trim($_GET['date_to']) : ''
        ];
        
        // Calculate offset for pagination
        $offset = ($page - 1) * $perPage;
        
        // Get bookings with pagination
        $bookings = $this->bookingModel->getBookings($filters, 'created_at', 'DESC', $perPage, $offset);
        
        // Get total bookings count for pagination
        $totalBookings = count($this->bookingModel->getBookings($filters));
        
        // Calculate total pages
        $totalPages = ceil($totalBookings / $perPage);
        
        // Prepare data for view
        $data = [
            'title' => 'Booking Management',
            'bookings' => $bookings,
            'filters' => $filters,
            'pagination' => [
                'page' => $page,
                'per_page' => $perPage,
                'total_records' => $totalBookings,
                'total_pages' => $totalPages
            ]
        ];
        
        // Load view
        $this->view('admin/bookings/index', $data);
    }
    
    /**
     * View booking details
     * 
     * @param int $id Booking ID
     */
    public function viewBooking($id) {
        // Get booking details
        $booking = $this->bookingModel->getBookingById($id);
        
        // Check if booking exists
        if (!$booking) {
            flash('booking_error', 'Booking not found', 'alert alert-danger');
            redirect('admin/bookings');
        }
        
        // Prepare data for view
        $data = [
            'title' => 'Booking Details',
            'booking' => $booking
        ];
        
        // Load view
        $this->view('admin/bookings/view', $data);
    }
    
    /**
     * Edit booking
     * 
     * @param int $id Booking ID
     */
    public function editBooking($id) {
        // Get booking details
        $booking = $this->bookingModel->getBookingById($id);
        
        // Check if booking exists
        if (!$booking) {
            flash('booking_error', 'Booking not found', 'alert alert-danger');
            redirect('admin/bookings');
        }
        
        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Initialize data
            $data = [
                'id' => $id,
                'status' => trim($_POST['status']),
                'payment_status' => trim($_POST['payment_status']),
                'pickup_date' => trim($_POST['pickup_date']),
                'return_date' => trim($_POST['return_date']),
                'pickup_location' => trim($_POST['pickup_location']),
                'return_location' => trim($_POST['return_location']),
                'total_price' => (float)$_POST['total_price'],
                'admin_notes' => trim($_POST['admin_notes']),
                'pickup_date_err' => '',
                'return_date_err' => '',
                'pickup_location_err' => '',
                'return_location_err' => '',
                'total_price_err' => ''
            ];
            
            // Validate pickup date
            if (empty($data['pickup_date'])) {
                $data['pickup_date_err'] = 'Please select pickup date';
            }
            
            // Validate return date
            if (empty($data['return_date'])) {
                $data['return_date_err'] = 'Please select return date';
            } elseif (strtotime($data['return_date']) <= strtotime($data['pickup_date'])) {
                $data['return_date_err'] = 'Return date must be after pickup date';
            }
            
            // Validate pickup location
            if (empty($data['pickup_location'])) {
                $data['pickup_location_err'] = 'Please enter pickup location';
            }
            
            // Validate return location
            if (empty($data['return_location'])) {
                $data['return_location_err'] = 'Please enter return location';
            }
            
            // Validate total price
            if (empty($data['total_price'])) {
                $data['total_price_err'] = 'Please enter total price';
            } elseif ($data['total_price'] <= 0) {
                $data['total_price_err'] = 'Total price must be greater than zero';
            }
            
            // Check if all errors are empty
            if (empty($data['pickup_date_err']) && empty($data['return_date_err']) && 
                empty($data['pickup_location_err']) && empty($data['return_location_err']) && 
                empty($data['total_price_err'])) {
                
                // Update booking
                if ($this->bookingModel->updateBooking($id, $data)) {
                    flash('booking_success', 'Booking updated successfully');
                    redirect('admin/bookings');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $data['title'] = 'Edit Booking';
                $data['booking'] = $booking;
                
                $this->view('admin/bookings/edit', $data);
            }
        } else {
            // Initialize data with booking details
            $data = [
                'title' => 'Edit Booking',
                'booking' => $booking,
                'id' => $booking['id'],
                'status' => $booking['status'],
                'payment_status' => $booking['payment_status'],
                'pickup_date' => $booking['pickup_date'],
                'return_date' => $booking['return_date'],
                'pickup_location' => $booking['pickup_location'],
                'return_location' => $booking['return_location'],
                'total_price' => $booking['total_price'],
                'admin_notes' => $booking['admin_notes'] ?? '',
                'pickup_date_err' => '',
                'return_date_err' => '',
                'pickup_location_err' => '',
                'return_location_err' => '',
                'total_price_err' => ''
            ];
            
            // Load view
            $this->view('admin/bookings/edit', $data);
        }
    }
    
    /**
     * Delete booking
     * 
     * @param int $id Booking ID
     */
    public function deleteBooking($id) {
        // Get booking details
        $booking = $this->bookingModel->getBookingById($id);
        
        // Check if booking exists
        if (!$booking) {
            flash('booking_error', 'Booking not found', 'alert alert-danger');
            redirect('admin/bookings');
        }
        
        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Delete booking
            if ($this->bookingModel->deleteBooking($id)) {
                flash('booking_success', 'Booking deleted successfully');
                redirect('admin/bookings');
            } else {
                flash('booking_error', 'Failed to delete booking', 'alert alert-danger');
                redirect('admin/bookings');
            }
        } else {
            // Prepare data for view
            $data = [
                'title' => 'Delete Booking',
                'booking' => $booking
            ];
            
            // Load view
            $this->view('admin/bookings/delete', $data);
        }
    }
    
    /**
     * User management
     */
    public function users() {
        // Get current page for pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max(1, $page); // Ensure page is at least 1
        
        // Items per page
        $perPage = DEFAULT_RECORDS_PER_PAGE;
        
        // Get filter params from URL
        $filters = [
            'role' => isset($_GET['role']) ? trim($_GET['role']) : '',
            'search' => isset($_GET['search']) ? trim($_GET['search']) : ''
        ];
        
        // Calculate offset for pagination
        $offset = ($page - 1) * $perPage;
        
        // Get users with pagination
        $users = $this->userModel->getAll('id', 'DESC');
        
        // Apply filters
        if (!empty($filters['role'])) {
            $users = array_filter($users, function($user) use ($filters) {
                return $user['role'] == $filters['role'];
            });
        }
        
        if (!empty($filters['search'])) {
            $search = strtolower($filters['search']);
            $users = array_filter($users, function($user) use ($search) {
                return strpos(strtolower($user['username']), $search) !== false ||
                       strpos(strtolower($user['email']), $search) !== false ||
                       strpos(strtolower($user['full_name']), $search) !== false;
            });
        }
        
        // Get total users count for pagination
        $totalUsers = count($users);
        
        // Apply pagination
        $users = array_slice($users, $offset, $perPage);
        
        // Calculate total pages
        $totalPages = ceil($totalUsers / $perPage);
        
        // Prepare data for view
        $data = [
            'title' => 'User Management',
            'users' => $users,
            'filters' => $filters,
            'pagination' => [
                'page' => $page,
                'per_page' => $perPage,
                'total_records' => $totalUsers,
                'total_pages' => $totalPages
            ]
        ];
        
        // Load view
        $this->view('admin/users/index', $data);
    }
    
    /**
     * Add new user
     */
    public function addUser() {
        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Initialize data
            $data = [
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'full_name' => trim($_POST['full_name']),
                'phone' => trim($_POST['phone']),
                'address' => trim($_POST['address']),
                'role' => trim($_POST['role']),
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'full_name_err' => '',
                'phone_err' => '',
                'role_err' => ''
            ];
            
            // Validate username
            if (empty($data['username'])) {
                $data['username_err'] = 'Please enter username';
            } elseif (strlen($data['username']) < 3) {
                $data['username_err'] = 'Username must be at least 3 characters';
            } else {
                // Check if username exists
                if ($this->userModel->findUserByUsername($data['username'])) {
                    $data['username_err'] = 'Username is already taken';
                }
            }
            
            // Validate email
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['email_err'] = 'Please enter a valid email';
            } else {
                // Check if email exists
                if ($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'Email is already taken';
                }
            }
            
            // Validate password
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be at least 6 characters';
            }
            
            // Validate confirm password
            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm password';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passwords do not match';
                }
            }
            
            // Validate full name
            if (empty($data['full_name'])) {
                $data['full_name_err'] = 'Please enter full name';
            }
            
            // Validate phone
            if (empty($data['phone'])) {
                $data['phone_err'] = 'Please enter phone number';
            } elseif (!preg_match('/^[0-9]{10,11}$/', $data['phone'])) {
                $data['phone_err'] = 'Please enter a valid phone number (10-11 digits)';
            }
            
            // Validate role
            if (empty($data['role'])) {
                $data['role_err'] = 'Please select role';
            } elseif (!in_array($data['role'], ['user', 'admin'])) {
                $data['role_err'] = 'Invalid role';
            }
            
            // Check if all errors are empty
            if (empty($data['username_err']) && empty($data['email_err']) && 
                empty($data['password_err']) && empty($data['confirm_password_err']) && 
                empty($data['full_name_err']) && empty($data['phone_err']) && 
                empty($data['role_err'])) {
                
                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                
                // Register user
                if ($this->userModel->register($data)) {
                    flash('user_success', 'User added successfully');
                    redirect('admin/users');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $data['title'] = 'Add New User';
                
                $this->view('admin/users/add', $data);
            }
        } else {
            // Initialize empty data
            $data = [
                'title' => 'Add New User',
                'username' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'full_name' => '',
                'phone' => '',
                'address' => '',
                'role' => 'user',
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'full_name_err' => '',
                'phone_err' => '',
                'role_err' => ''
            ];
            
            // Load view
            $this->view('admin/users/add', $data);
        }
    }
    
    /**
     * Edit user
     * 
     * @param int $id User ID
     */
    public function editUser($id) {
        // Get user by ID
        $user = $this->userModel->getById($id);
        
        // Check if user exists
        if (!$user) {
            flash('user_error', 'User not found', 'alert alert-danger');
            redirect('admin/users');
        }
        
        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Initialize data
            $data = [
                'id' => $id,
                'username' => $user['username'], // Username cannot be changed
                'email' => trim($_POST['email']),
                'full_name' => trim($_POST['full_name']),
                'phone' => trim($_POST['phone']),
                'address' => trim($_POST['address']),
                'role' => trim($_POST['role']),
                'new_password' => trim($_POST['new_password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'email_err' => '',
                'full_name_err' => '',
                'phone_err' => '',
                'role_err' => '',
                'new_password_err' => '',
                'confirm_password_err' => ''
            ];
            
            // Validate email
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['email_err'] = 'Please enter a valid email';
            } else {
                // Check if email exists (excluding current user)
                if ($data['email'] != $user['email'] && $this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'Email is already taken';
                }
            }
            
            // Validate full name
            if (empty($data['full_name'])) {
                $data['full_name_err'] = 'Please enter full name';
            }
            
            // Validate phone
            if (empty($data['phone'])) {
                $data['phone_err'] = 'Please enter phone number';
            } elseif (!preg_match('/^[0-9]{10,11}$/', $data['phone'])) {
                $data['phone_err'] = 'Please enter a valid phone number (10-11 digits)';
            }
            
            // Validate role
            if (empty($data['role'])) {
                $data['role_err'] = 'Please select role';
            } elseif (!in_array($data['role'], ['user', 'admin'])) {
                $data['role_err'] = 'Invalid role';
            }
            
            // Check if password is being changed
            $changePassword = !empty($data['new_password']);
            
            if ($changePassword) {
                // Validate new password
                if (strlen($data['new_password']) < 6) {
                    $data['new_password_err'] = 'Password must be at least 6 characters';
                }
                
                // Validate confirm password
                if (empty($data['confirm_password'])) {
                    $data['confirm_password_err'] = 'Please confirm password';
                } else if ($data['new_password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passwords do not match';
                }
            }
            
            // Check if all errors are empty
            if (empty($data['email_err']) && empty($data['full_name_err']) && 
                empty($data['phone_err']) && empty($data['role_err']) && 
                (empty($data['new_password_err']) || !$changePassword) && 
                (empty($data['confirm_password_err']) || !$changePassword)) {
                
                // Update user
                $updateData = [
                    'email' => $data['email'],
                    'full_name' => $data['full_name'],
                    'phone' => $data['phone'],
                    'address' => $data['address'],
                    'role' => $data['role']
                ];
                
                if ($this->userModel->updateUser($id, $updateData)) {
                    // Update password if provided
                    if ($changePassword) {
                        $passwordHash = password_hash($data['new_password'], PASSWORD_DEFAULT);
                        $this->userModel->updatePassword($id, $passwordHash);
                    }
                    
                    flash('user_success', 'User updated successfully');
                    redirect('admin/users');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $data['title'] = 'Edit User';
                $data['user'] = $user;
                
                $this->view('admin/users/edit', $data);
            }
        } else {
            // Initialize data with user details
            $data = [
                'title' => 'Edit User',
                'user' => $user,
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'full_name' => $user['full_name'],
                'phone' => $user['phone'],
                'address' => $user['address'],
                'role' => $user['role'],
                'new_password' => '',
                'confirm_password' => '',
                'email_err' => '',
                'full_name_err' => '',
                'phone_err' => '',
                'role_err' => '',
                'new_password_err' => '',
                'confirm_password_err' => ''
            ];
            
            // Load view
            $this->view('admin/users/edit', $data);
        }
    }
    
    /**
     * Delete user
     * 
     * @param int $id User ID
     */
    public function deleteUser($id) {
        // Get user by ID
        $user = $this->userModel->getById($id);
        
        // Check if user exists
        if (!$user) {
            flash('user_error', 'User not found', 'alert alert-danger');
            redirect('admin/users');
        }
        
        // Prevent deleting yourself
        if ($user['id'] == $_SESSION['user_id']) {
            flash('user_error', 'You cannot delete your own account', 'alert alert-danger');
            redirect('admin/users');
        }
        
        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Delete user
            if ($this->userModel->delete($id)) {
                flash('user_success', 'User deleted successfully');
                redirect('admin/users');
            } else {
                flash('user_error', 'Failed to delete user', 'alert alert-danger');
                redirect('admin/users');
            }
        } else {
            // Prepare data for view
            $data = [
                'title' => 'Delete User',
                'user' => $user
            ];
            
            // Load view
            $this->view('admin/users/delete', $data);
        }
    }
    
    /**
     * System settings
     */
    public function settings() {
        // Load settings model
        $settingsModel = $this->model('Setting');
        
        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Initialize data
            $data = [
                'company_name' => trim($_POST['company_name']),
                'company_address' => trim($_POST['company_address']),
                'company_phone' => trim($_POST['company_phone']),
                'company_email' => trim($_POST['company_email']),
                'booking_limit' => (int)$_POST['booking_limit'],
                'maintenance_mode' => isset($_POST['maintenance_mode']) ? 1 : 0,
                'default_currency' => trim($_POST['default_currency']),
                'tax_rate' => (float)$_POST['tax_rate'],
                'min_rental_days' => (int)$_POST['min_rental_days']
            ];
            
            // Update settings
            $updated = true;
            foreach ($data as $key => $value) {
                if (!$settingsModel->updateSetting($key, $value)) {
                    $updated = false;
                }
            }
            
            if ($updated) {
                flash('settings_success', 'Settings updated successfully');
                redirect('admin/settings');
            } else {
                flash('settings_error', 'Failed to update settings', 'alert alert-danger');
                redirect('admin/settings');
            }
        } else {
            // Get all settings
            $settings = $settingsModel->getAllSettings();
            
            // Convert settings array to associative array
            $settingsData = [];
            foreach ($settings as $setting) {
                $settingsData[$setting['setting_key']] = $setting['setting_value'];
            }
            
            // Prepare data for view
            $data = [
                'title' => 'System Settings',
                'settings' => $settingsData
            ];
            
            // Load view
            $this->view('admin/settings', $data);
        }
    }
    
    /**
     * Handle file upload
     * 
     * @param array $file File from $_FILES
     * @param string $uploadDir Upload directory
     * @return string|bool Filename on success, false on failure
     */
    private function handleFileUpload($file, $uploadDir) {
        // Check if upload directory exists, create if not
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        // Check for upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }
        
        // Check file size (max 5MB)
        if ($file['size'] > 5242880) {
            return false;
        }
        
        // Check file type (allow only images)
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            return false;
        }
        
        // Generate a unique filename
        $filename = uniqid() . '_' . $file['name'];
        $destination = $uploadDir . '/' . $filename;
        
        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return $filename;
        }
        
        return false;
    }
}