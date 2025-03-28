<?php
/**
 * Booking Controller
 * Handles all booking functionality
 */
class BookingController extends Controller {
    private $bookingModel;
    private $carModel;
    private $userModel;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->requireLogin();
        
        $this->bookingModel = $this->model('Booking');
        $this->carModel = $this->model('Car');
        $this->userModel = $this->model('User');
    }
    
    /**
     * Create new booking
     * 
     * @param int $carId Car ID
     */
    public function create($carId) {
        // Get car details
        $car = $this->carModel->getCarById($carId);
        
        // Check if car exists
        if (!$car) {
            flash('booking_error', 'Car not found', 'alert alert-danger');
            redirect('car');
        }
        
        // Check if car is available
        if ($car['status'] != 'available') {
            flash('booking_error', 'This car is not available for booking', 'alert alert-danger');
            redirect('car/details/' . $carId);
        }
        
        // Get pickup and return dates from URL
        $pickupDate = isset($_GET['pickup_date']) ? $_GET['pickup_date'] : '';
        $returnDate = isset($_GET['return_date']) ? $_GET['return_date'] : '';
        
        // Validate dates
        if (empty($pickupDate) || empty($returnDate) || !validateDate($pickupDate) || !validateDate($returnDate)) {
            flash('booking_error', 'Please select valid pickup and return dates', 'alert alert-danger');
            redirect('car/details/' . $carId);
        }
        
        // Check if return date is after pickup date
        if (strtotime($returnDate) <= strtotime($pickupDate)) {
            flash('booking_error', 'Return date must be after pickup date', 'alert alert-danger');
            redirect('car/details/' . $carId);
        }
        
        // Check car availability for selected dates
        if (!$this->carModel->isCarAvailable($carId, $pickupDate, $returnDate)) {
            flash('booking_error', 'This car is not available for the selected dates', 'alert alert-danger');
            redirect('car/details/' . $carId . '?pickup_date=' . $pickupDate . '&return_date=' . $returnDate);
        }
        
        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Initialize data
            $data = [
                'car_id' => $carId,
                'user_id' => $_SESSION['user_id'],
                'pickup_date' => trim($_POST['pickup_date']),
                'return_date' => trim($_POST['return_date']),
                'pickup_location' => trim($_POST['pickup_location']),
                'return_location' => trim($_POST['return_location']),
                'total_price' => floatval($_POST['total_price']),
                'status' => 'pending',
                'payment_status' => 'pending',
                'pickup_date_err' => '',
                'return_date_err' => '',
                'pickup_location_err' => '',
                'return_location_err' => ''
            ];
            
            // Validate pickup date
            if (empty($data['pickup_date'])) {
                $data['pickup_date_err'] = 'Please select pickup date';
            } elseif (strtotime($data['pickup_date']) < strtotime(date('Y-m-d'))) {
                $data['pickup_date_err'] = 'Pickup date cannot be in the past';
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
            
            // Check if all errors are empty
            if (empty($data['pickup_date_err']) && empty($data['return_date_err']) && 
                empty($data['pickup_location_err']) && empty($data['return_location_err'])) {
                
                // Create booking
                $bookingId = $this->bookingModel->addBooking($data);
                
                if ($bookingId) {
                    flash('booking_success', 'Your booking has been created successfully');
                    redirect('booking/confirm/' . $bookingId);
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $data['car'] = $car;
                $data['title'] = 'New Booking';
                
                $this->view('booking/create', $data);
            }
        } else {
            // Calculate rental days and total price
            $days = calculateDaysBetween($pickupDate, $returnDate);
            $totalPrice = $car['price_per_day'] * $days;
            
            // Prepare data for view
            $data = [
                'title' => 'New Booking',
                'car' => $car,
                'pickup_date' => $pickupDate,
                'return_date' => $returnDate,
                'pickup_location' => '',
                'return_location' => '',
                'total_price' => $totalPrice,
                'days' => $days,
                'pickup_date_err' => '',
                'return_date_err' => '',
                'pickup_location_err' => '',
                'return_location_err' => ''
            ];
            
            // Load view
            $this->view('booking/create', $data);
        }
    }
    
    /**
     * Booking confirmation page
     * 
     * @param int $id Booking ID
     */
    public function confirm($id) {
        // Get booking details
        $booking = $this->bookingModel->getBookingById($id);
        
        // Check if booking exists
        if (!$booking) {
            flash('booking_error', 'Booking not found', 'alert alert-danger');
            redirect('user/bookings');
        }
        
        // Check if booking belongs to current user
        if ($booking['user_id'] != $_SESSION['user_id'] && $_SESSION['user_role'] != 'admin') {
            flash('booking_error', 'You are not authorized to view this booking', 'alert alert-danger');
            redirect('user/bookings');
        }
        
        // Prepare data for view
        $data = [
            'title' => 'Booking Confirmation',
            'booking' => $booking
        ];
        
        // Load view
        $this->view('booking/confirm', $data);
    }
    
    /**
     * Booking checkout/payment page
     * 
     * @param int $id Booking ID
     */
    public function checkout($id) {
        // Get booking details
        $booking = $this->bookingModel->getBookingById($id);
        
        // Check if booking exists
        if (!$booking) {
            flash('booking_error', 'Booking not found', 'alert alert-danger');
            redirect('user/bookings');
        }
        
        // Check if booking belongs to current user
        if ($booking['user_id'] != $_SESSION['user_id']) {
            flash('booking_error', 'You are not authorized to access this booking', 'alert alert-danger');
            redirect('user/bookings');
        }
        
        // Check if booking is already paid
        if ($booking['payment_status'] == 'paid') {
            flash('booking_message', 'This booking has already been paid', 'alert alert-info');
            redirect('booking/confirm/' . $id);
        }
        
        // Check if form is submitted (payment processed)
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // In a real application, you would process payment here
            // For this demo, we'll just mark the booking as paid
            
            // Update payment status
            if ($this->bookingModel->updatePaymentStatus($id, 'paid')) {
                flash('payment_success', 'Payment processed successfully');
                redirect('booking/complete/' . $id);
            } else {
                flash('payment_error', 'Payment processing failed', 'alert alert-danger');
                redirect('booking/checkout/' . $id);
            }
        } else {
            // Prepare data for view
            $data = [
                'title' => 'Checkout',
                'booking' => $booking
            ];
            
            // Load view
            $this->view('booking/checkout', $data);
        }
    }
    
    /**
     * Booking completion page (after payment)
     * 
     * @param int $id Booking ID
     */
    public function complete($id) {
        // Get booking details
        $booking = $this->bookingModel->getBookingById($id);
        
        // Check if booking exists
        if (!$booking) {
            flash('booking_error', 'Booking not found', 'alert alert-danger');
            redirect('user/bookings');
        }
        
        // Check if booking belongs to current user
        if ($booking['user_id'] != $_SESSION['user_id'] && $_SESSION['user_role'] != 'admin') {
            flash('booking_error', 'You are not authorized to view this booking', 'alert alert-danger');
            redirect('user/bookings');
        }
        
        // Prepare data for view
        $data = [
            'title' => 'Booking Completed',
            'booking' => $booking
        ];
        
        // Load view
        $this->view('booking/complete', $data);
    }
    
    /**
     * Cancel booking
     * 
     * @param int $id Booking ID
     */
    public function cancel($id) {
        // Get booking details
        $booking = $this->bookingModel->getBookingById($id);
        
        // Check if booking exists
        if (!$booking) {
            flash('booking_error', 'Booking not found', 'alert alert-danger');
            redirect('user/bookings');
        }
        
        // Check if booking belongs to current user or user is admin
        if ($booking['user_id'] != $_SESSION['user_id'] && $_SESSION['user_role'] != 'admin') {
            flash('booking_error', 'You are not authorized to cancel this booking', 'alert alert-danger');
            redirect('user/bookings');
        }
        
        // Check if booking can be cancelled (pending or confirmed status)
        if ($booking['status'] != 'pending' && $booking['status'] != 'confirmed') {
            flash('booking_error', 'This booking cannot be cancelled', 'alert alert-danger');
            redirect('user/bookings');
        }
        
        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Update booking status to cancelled
            if ($this->bookingModel->updateBookingStatus($id, 'cancelled')) {
                flash('booking_success', 'Booking cancelled successfully');
                redirect('user/bookings');
            } else {
                flash('booking_error', 'Failed to cancel booking', 'alert alert-danger');
                redirect('user/bookings');
            }
        } else {
            // Prepare data for view
            $data = [
                'title' => 'Cancel Booking',
                'booking' => $booking
            ];
            
            // Load view
            $this->view('booking/cancel', $data);
        }
    }
}