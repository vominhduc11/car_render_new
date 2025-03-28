<?php
/**
 * User Controller
 * Handles user profile and bookings
 */
class UserController extends Controller {
    private $userModel;
    private $bookingModel;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->requireLogin();
        
        $this->userModel = $this->model('User');
        $this->bookingModel = $this->model('Booking');
    }
    
    /**
     * User profile page
     */
    public function profile() {
        // Get user details
        $user = $this->userModel->getById($_SESSION['user_id']);
        
        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Initialize data
            $data = [
                'id' => $_SESSION['user_id'],
                'full_name' => trim($_POST['full_name']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'address' => trim($_POST['address']),
                'current_password' => trim($_POST['current_password']),
                'new_password' => trim($_POST['new_password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'full_name_err' => '',
                'email_err' => '',
                'phone_err' => '',
                'current_password_err' => '',
                'new_password_err' => '',
                'confirm_password_err' => ''
            ];
            
            // Validate full name
            if (empty($data['full_name'])) {
                $data['full_name_err'] = 'Please enter your full name';
            }
            
            // Validate email
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['email_err'] = 'Please enter a valid email';
            } else {
                // Check if email exists (but not the current user's email)
                if ($data['email'] != $user['email'] && $this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'Email is already taken';
                }
            }
            
            // Validate phone
            if (empty($data['phone'])) {
                $data['phone_err'] = 'Please enter your phone number';
            } elseif (!preg_match('/^[0-9]{10,11}$/', $data['phone'])) {
                $data['phone_err'] = 'Please enter a valid phone number (10-11 digits)';
            }
            
            // Check if user wants to change password
            $changePassword = false;
            if (!empty($data['current_password']) || !empty($data['new_password']) || !empty($data['confirm_password'])) {
                $changePassword = true;
                
                // Validate current password
                if (empty($data['current_password'])) {
                    $data['current_password_err'] = 'Please enter current password';
                } elseif (!$this->userModel->verifyPassword($_SESSION['user_id'], $data['current_password'])) {
                    $data['current_password_err'] = 'Current password is incorrect';
                }
                
                // Validate new password
                if (empty($data['new_password'])) {
                    $data['new_password_err'] = 'Please enter new password';
                } elseif (strlen($data['new_password']) < 6) {
                    $data['new_password_err'] = 'Password must be at least 6 characters';
                }
                
                // Validate confirm password
                if (empty($data['confirm_password'])) {
                    $data['confirm_password_err'] = 'Please confirm new password';
                } else {
                    if ($data['new_password'] != $data['confirm_password']) {
                        $data['confirm_password_err'] = 'Passwords do not match';
                    }
                }
            }
            
            // Check if all profile errors are empty
            $profileValid = empty($data['full_name_err']) && empty($data['email_err']) && empty($data['phone_err']);
            
            // Check if all password errors are empty (if changing password)
            $passwordValid = !$changePassword || (empty($data['current_password_err']) && 
                                                  empty($data['new_password_err']) && 
                                                  empty($data['confirm_password_err']));
            
            // If all validations pass
            if ($profileValid && $passwordValid) {
                // Update user profile
                $profileData = [
                    'full_name' => $data['full_name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'address' => $data['address']
                ];
                
                if ($this->userModel->updateUser($_SESSION['user_id'], $profileData)) {
                    // Update session data
                    $_SESSION['user_name'] = $data['full_name'];
                    $_SESSION['user_email'] = $data['email'];
                    
                    // Update password if requested
                    if ($changePassword) {
                        $newPasswordHash = password_hash($data['new_password'], PASSWORD_DEFAULT);
                        
                        if ($this->userModel->updatePassword($_SESSION['user_id'], $newPasswordHash)) {
                            flash('profile_success', 'Your profile and password have been updated successfully');
                        } else {
                            flash('profile_error', 'Your profile was updated but there was an error updating your password', 'alert alert-warning');
                        }
                    } else {
                        flash('profile_success', 'Your profile has been updated successfully');
                    }
                    
                    redirect('user/profile');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $data['user'] = $user;
                $data['title'] = 'My Profile';
                
                $this->view('user/profile', $data);
            }
        } else {
            // Initialize data with user details
            $data = [
                'title' => 'My Profile',
                'user' => $user,
                'full_name' => $user['full_name'],
                'email' => $user['email'],
                'phone' => $user['phone'],
                'address' => $user['address'],
                'current_password' => '',
                'new_password' => '',
                'confirm_password' => '',
                'full_name_err' => '',
                'email_err' => '',
                'phone_err' => '',
                'current_password_err' => '',
                'new_password_err' => '',
                'confirm_password_err' => ''
            ];
            
            // Load view
            $this->view('user/profile', $data);
        }
    }
    
    /**
     * User bookings page
     */
    public function bookings() {
        // Get user bookings
        $bookings = $this->userModel->getUserBookings($_SESSION['user_id']);
        
        // Group bookings by status
        $pendingBookings = [];
        $confirmedBookings = [];
        $completedBookings = [];
        $cancelledBookings = [];
        
        foreach ($bookings as $booking) {
            switch ($booking['status']) {
                case 'pending':
                    $pendingBookings[] = $booking;
                    break;
                case 'confirmed':
                    $confirmedBookings[] = $booking;
                    break;
                case 'completed':
                    $completedBookings[] = $booking;
                    break;
                case 'cancelled':
                    $cancelledBookings[] = $booking;
                    break;
            }
        }
        
        // Prepare data for view
        $data = [
            'title' => 'My Bookings',
            'bookings' => $bookings,
            'pendingBookings' => $pendingBookings,
            'confirmedBookings' => $confirmedBookings,
            'completedBookings' => $completedBookings,
            'cancelledBookings' => $cancelledBookings
        ];
        
        // Load view
        $this->view('user/bookings', $data);
    }
    
    /**
     * User settings page
     */
    public function settings() {
        // Get user details
        $user = $this->userModel->getById($_SESSION['user_id']);
        
        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Initialize data
            $data = [
                'id' => $_SESSION['user_id'],
                'notification_email' => isset($_POST['notification_email']) ? 1 : 0,
                'notification_sms' => isset($_POST['notification_sms']) ? 1 : 0,
                'newsletter' => isset($_POST['newsletter']) ? 1 : 0,
                'language' => $_POST['language'],
                'currency' => $_POST['currency']
            ];
            
            // Update user settings
            if ($this->userModel->updateSettings($_SESSION['user_id'], $data)) {
                flash('settings_success', 'Your settings have been updated successfully');
                redirect('user/settings');
            } else {
                die('Something went wrong');
            }
        } else {
            // Get user settings
            $settings = $this->userModel->getUserSettings($_SESSION['user_id']);
            
            // Prepare data for view
            $data = [
                'title' => 'Account Settings',
                'user' => $user,
                'settings' => $settings
            ];
            
            // Load view
            $this->view('user/settings', $data);
        }
    }
}