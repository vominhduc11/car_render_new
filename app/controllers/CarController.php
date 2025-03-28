<?php
/**
 * Car Controller
 * Handles car listing, details, and search
 */
class CarController extends Controller {
    private $carModel;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->carModel = $this->model('Car');
    }
    
    /**
     * Car listing page
     */
    public function index() {
        // Get current page for pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max(1, $page); // Ensure page is at least 1
        
        // Items per page
        $perPage = DEFAULT_RECORDS_PER_PAGE;
        
        // Get filter params from URL
        $filters = [
            'brand' => isset($_GET['brand']) ? trim($_GET['brand']) : '',
            'search' => isset($_GET['search']) ? trim($_GET['search']) : '',
            'min_price' => isset($_GET['min_price']) ? (int)$_GET['min_price'] : '',
            'max_price' => isset($_GET['max_price']) ? (int)$_GET['max_price'] : '',
            'seats' => isset($_GET['seats']) ? trim($_GET['seats']) : '',
            'transmission' => isset($_GET['transmission']) ? trim($_GET['transmission']) : ''
        ];
        
        // Calculate offset for pagination
        $offset = ($page - 1) * $perPage;
        
        // Get date ranges for booking
        $pickupDate = isset($_GET['pickup_date']) ? $_GET['pickup_date'] : '';
        $returnDate = isset($_GET['return_date']) ? $_GET['return_date'] : '';
        
        // Get cars based on filters and available dates
        if (!empty($pickupDate) && !empty($returnDate) && validateDate($pickupDate) && validateDate($returnDate)) {
            // Get available cars for the date range
            $cars = $this->carModel->getAvailableCars($pickupDate, $returnDate, $filters);
            
            // Count total for pagination
            $totalCars = count($cars);
            
            // Slice the results for current page
            $cars = array_slice($cars, $offset, $perPage);
        } else {
            // Get all cars with filters
            $cars = $this->carModel->getCars($filters, 'id', 'DESC', $perPage, $offset);
            
            // Count total cars with these filters
            $totalCars = count($this->carModel->getCars($filters));
        }
        
        // Calculate total pages
        $totalPages = ceil($totalCars / $perPage);
        
        // Get distinct car brands for filter dropdown
        $brands = $this->carModel->getBrands();
        
        // Prepare data for view
        $data = [
            'title' => 'Our Cars',
            'cars' => $cars,
            'brands' => $brands,
            'filters' => $filters,
            'pickup_date' => $pickupDate,
            'return_date' => $returnDate,
            'pagination' => [
                'page' => $page,
                'per_page' => $perPage,
                'total_records' => $totalCars,
                'total_pages' => $totalPages
            ]
        ];
        
        // Load view
        $this->view('car/index', $data);
    }
    
    /**
     * Car details page
     *
     * @param int $id Car ID
     */
    public function details($id) {
        // Get car details
        $car = $this->carModel->getCarById($id);
        
        // Check if car exists
        if (!$car) {
            flash('car_error', 'Car not found', 'alert alert-danger');
            redirect('car');
        }
        
        // Get pickup and return dates from URL
        $pickupDate = isset($_GET['pickup_date']) ? $_GET['pickup_date'] : '';
        $returnDate = isset($_GET['return_date']) ? $_GET['return_date'] : '';
        
        // Check availability if dates are provided
        $isAvailable = true;
        $days = 0;
        $totalPrice = 0;
        
        if (!empty($pickupDate) && !empty($returnDate)) {
            $isAvailable = $this->carModel->isCarAvailable($id, $pickupDate, $returnDate);
            
            // Calculate rental days and total price
            $days = calculateDaysBetween($pickupDate, $returnDate);
            $totalPrice = $car['price_per_day'] * $days;
        }
        
        // Get similar cars
        $similarCars = $this->carModel->getCars([
            'brand' => $car['brand'],
            'status' => 'available'
        ], 'id', 'DESC', 3);
        
        // Remove the current car from similar cars
        foreach ($similarCars as $key => $similarCar) {
            if ($similarCar['id'] == $id) {
                unset($similarCars[$key]);
                break;
            }
        }
        
        // Load Review model if needed
        $reviewModel = $this->model('Review');
        $reviews = $reviewModel->getReviewsByCar($id);
        
        // Calculate average rating
        $avgRating = 0;
        if (!empty($reviews)) {
            $totalRating = 0;
            foreach ($reviews as $review) {
                $totalRating += $review['rating'];
            }
            $avgRating = round($totalRating / count($reviews), 1);
        }
        
        // Prepare data for view
        $data = [
            'title' => $car['brand'] . ' ' . $car['model'],
            'car' => $car,
            'similarCars' => $similarCars,
            'reviews' => $reviews,
            'avgRating' => $avgRating,
            'pickup_date' => $pickupDate,
            'return_date' => $returnDate,
            'isAvailable' => $isAvailable,
            'days' => $days,
            'totalPrice' => $totalPrice
        ];
        
        // Load view
        $this->view('car/details', $data);
    }
    
    /**
     * Search cars
     */
    public function search() {
        // Redirect to index with search parameters in GET
        $pickupDate = isset($_GET['pickup_date']) ? $_GET['pickup_date'] : '';
        $returnDate = isset($_GET['return_date']) ? $_GET['return_date'] : '';
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        
        redirect('car?pickup_date=' . $pickupDate . '&return_date=' . $returnDate . '&search=' . $search);
    }
}