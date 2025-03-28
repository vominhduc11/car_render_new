<?php
/**
 * Home Controller
 * Handles home page and other static pages
 */
class HomeController extends Controller {
    private $carModel;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->carModel = $this->model('Car');
    }
    
    /**
     * Home page
     */
    public function index() {
        // Get available cars for featured section (limit to 6)
        $featuredCars = $this->carModel->getCars(['status' => 'available'], 'id', 'DESC', 6);
        
        // Get distinct car brands for filter dropdown
        $brands = $this->carModel->getBrands();
        
        // Prepare data for view
        $data = [
            'title' => 'Home',
            'featuredCars' => $featuredCars,
            'brands' => $brands
        ];
        
        // Load view
        $this->view('home/index', $data);
    }
    
    /**
     * About page
     */
    public function about() {
        // Prepare data for view
        $data = [
            'title' => 'About Us'
        ];
        
        // Load view
        $this->view('home/about', $data);
    }
    
    /**
     * Contact page
     */
    public function contact() {
        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Get form data
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $subject = trim($_POST['subject']);
            $message = trim($_POST['message']);
            
            // Validate data
            $errors = [];
            
            if (empty($name)) {
                $errors['name'] = 'Please enter your name';
            }
            
            if (empty($email)) {
                $errors['email'] = 'Please enter your email';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Please enter a valid email';
            }
            
            if (empty($subject)) {
                $errors['subject'] = 'Please enter a subject';
            }
            
            if (empty($message)) {
                $errors['message'] = 'Please enter your message';
            }
            
            // If no errors, send email
            if (empty($errors)) {
                // In a real application, you would send an email here
                // For demonstration, we'll just show a success message
                
                flash('contact_success', 'Your message has been sent successfully!');
                redirect('home/contact');
            } else {
                // Prepare data for view with errors
                $data = [
                    'title' => 'Contact Us',
                    'name' => $name,
                    'email' => $email,
                    'subject' => $subject,
                    'message' => $message,
                    'errors' => $errors
                ];
                
                // Load view with errors
                $this->view('home/contact', $data);
            }
        } else {
            // Prepare data for view
            $data = [
                'title' => 'Contact Us',
                'name' => '',
                'email' => '',
                'subject' => '',
                'message' => '',
                'errors' => []
            ];
            
            // Load view
            $this->view('home/contact', $data);
        }
    }
    
    /**
     * Terms and conditions page
     */
    public function terms() {
        // Prepare data for view
        $data = [
            'title' => 'Terms and Conditions'
        ];
        
        // Load view
        $this->view('home/terms', $data);
    }
    
    /**
     * Privacy policy page
     */
    public function privacy() {
        // Prepare data for view
        $data = [
            'title' => 'Privacy Policy'
        ];
        
        // Load view
        $this->view('home/privacy', $data);
    }
    
    /**
     * FAQ page
     */
    public function faq() {
        // Prepare data for view
        $data = [
            'title' => 'Frequently Asked Questions'
        ];
        
        // Load view
        $this->view('home/faq', $data);
    }
    
    /**
     * 404 page
     */
    public function notFound() {
        // Prepare data for view
        $data = [
            'title' => 'Page Not Found'
        ];
        
        // Set 404 header
        http_response_code(404);
        
        // Load view
        $this->view('errors/404', $data);
    }
}