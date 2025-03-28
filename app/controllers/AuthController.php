<?php
/**
 * Authentication Controller
 * Handles user authentication
 */
class AuthController extends Controller {
    private $userModel;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->userModel = $this->model('User');
    }
    
    /**
     * Login page
     */
    public function login() {
        // Check if user is already logged in
        if (isLoggedIn()) {
            redirect('home');
        }
        
        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Initialize data
            $data = [
                'username' => trim($_POST['username']),
                'password' => trim($_POST['password']),
                'username_err' => '',
                'password_err' => ''
            ];
            
            // Validate username
            if (empty($data['username'])) {
                $data['username_err'] = 'Please enter username';
            }
            
            // Validate password
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            }
            
            // Check if all errors are empty
            if (empty($data['username_err']) && empty($data['password_err'])) {
                // Attempt to log in user
                $loggedInUser = $this->userModel->login($data['username'], $data['password']);
                
                if ($loggedInUser) {
                    // Create session
                    $this->createUserSession($loggedInUser);
                    
                    // Redirect based on role
                    if ($loggedInUser['role'] == 'admin') {
                        redirect('admin');
                    } else {
                        redirect('home');
                    }
                } else {
                    $data['password_err'] = 'Password incorrect';
                    
                    // Load view with errors
                    $this->view('auth/login', $data);
                }
            } else {
                // Load view with errors
                $this->view('auth/login', $data);
            }
        } else {
            // Initialize empty data
            $data = [
                'username' => '',
                'password' => '',
                'username_err' => '',
                'password_err' => ''
            ];
            
            // Load view
            $this->view('auth/login', $data);
        }
    }
    
    /**
     * Register page
     */
    public function register() {
        // Check if user is already logged in
        if (isLoggedIn()) {
            redirect('home');
        }
        
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
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'full_name_err' => '',
                'phone_err' => ''
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
                $data['full_name_err'] = 'Please enter your full name';
            }
            
            // Validate phone
            if (empty($data['phone'])) {
                $data['phone_err'] = 'Please enter your phone number';
            } elseif (!preg_match('/^[0-9]{10,11}$/', $data['phone'])) {
                $data['phone_err'] = 'Please enter a valid phone number (10-11 digits)';
            }
            
            // Check if all errors are empty
            if (empty($data['username_err']) && empty($data['email_err']) && 
                empty($data['password_err']) && empty($data['confirm_password_err']) && 
                empty($data['full_name_err']) && empty($data['phone_err'])) {
                
                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                
                // Register user
                if ($this->userModel->register($data)) {
                    flash('register_success', 'You are registered and can now log in');
                    redirect('auth/login');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('auth/register', $data);
            }
        } else {
            // Initialize empty data
            $data = [
                'username' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'full_name' => '',
                'phone' => '',
                'address' => '',
                'username_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'full_name_err' => '',
                'phone_err' => ''
            ];
            
            // Load view
            $this->view('auth/register', $data);
        }
    }
    
    /**
     * Create user session
     *
     * @param array $user User data
     */
    public function createUserSession($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_username'] = $user['username'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['user_role'] = $user['role'];
    }
    
    /**
     * Logout user
     */
    public function logout() {
        // Unset session variables
        unset($_SESSION['user_id']);
        unset($_SESSION['user_username']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_role']);
        
        session_destroy();
        
        redirect('auth/login');
    }
    
    /**
     * Forgot password page
     */
    public function forgotPassword() {
        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Initialize data
            $data = [
                'email' => trim($_POST['email']),
                'email_err' => ''
            ];
            
            // Validate email
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['email_err'] = 'Please enter a valid email';
            } else {
                // Check if email exists
                if (!$this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'No account found with that email';
                }
            }
            
            // Check if all errors are empty
            if (empty($data['email_err'])) {
                // Generate token
                $token = bin2hex(random_bytes(32));
                
                // Store token in database
                if ($this->userModel->setResetToken($data['email'], $token)) {
                    // In a real application, you would send an email with the reset link
                    // For demonstration purposes, we'll just show a success message
                    
                    flash('forgot_password_success', 'Reset link has been sent to your email');
                    redirect('auth/login');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('auth/forgot_password', $data);
            }
        } else {
            // Initialize empty data
            $data = [
                'email' => '',
                'email_err' => ''
            ];
            
            // Load view
            $this->view('auth/forgot_password', $data);
        }
    }
    
    /**
     * Reset password page
     *
     * @param string $token Reset token
     */
    public function resetPassword($token = null) {
        // Check if token is valid
        if ($token === null || !$this->userModel->findUserByResetToken($token)) {
            flash('reset_error', 'Invalid or expired token', 'alert alert-danger');
            redirect('auth/login');
        }
        
        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            // Initialize data
            $data = [
                'token' => $token,
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            
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
            
            // Check if all errors are empty
            if (empty($data['password_err']) && empty($data['confirm_password_err'])) {
                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                
                // Update password
                if ($this->userModel->resetPassword($token, $data['password'])) {
                    flash('password_reset_success', 'Your password has been reset successfully');
                    redirect('auth/login');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('auth/reset_password', $data);
            }
        } else {
            // Initialize empty data
            $data = [
                'token' => $token,
                'password' => '',
                'confirm_password' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            
            // Load view
            $this->view('auth/reset_password', $data);
        }
    }
}