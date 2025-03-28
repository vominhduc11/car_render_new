<?php
/**
 * Base Controller
 * Loads models and views
 */
class Controller {
    /**
     * Load model
     *
     * @param string $model Model name
     * @return object Model instance
     */
    public function model($model) {
        // Require model file
        require_once '../app/models/' . $model . '.php';
        
        // Instantiate model
        return new $model();
    }
    
    /**
     * Load view
     *
     * @param string $view View name
     * @param array $data Data to be passed to the view
     * @return void
     */
    public function view($view, $data = []) {
        // Check for view file
        if (file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        } else {
            // View does not exist
            die('View does not exist');
        }
    }
    
    /**
     * Check if user is logged in
     *
     * @return bool
     */
    protected function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    /**
     * Check if user is admin
     *
     * @return bool
     */
    protected function isAdmin() {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin';
    }
    
    /**
     * Require login
     *
     * @return void
     */
    protected function requireLogin() {
        if (!$this->isLoggedIn()) {
            flash('login_message', 'Please log in to access this page', 'alert alert-danger');
            redirect('auth/login');
        }
    }
    
    /**
     * Require admin
     *
     * @return void
     */
    protected function requireAdmin() {
        if (!$this->isLoggedIn() || !$this->isAdmin()) {
            flash('login_message', 'You are not authorized to access this page', 'alert alert-danger');
            redirect('auth/login');
        }
    }
    
    /**
     * Validate CSRF token
     *
     * @param string $token CSRF token from form
     * @return bool
     */
    protected function validateCSRF($token) {
        if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Generate CSRF token
     *
     * @return string
     */
    protected function generateCSRF() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        
        return $_SESSION['csrf_token'];
    }
    
    /**
     * Validate request method
     *
     * @param string $method HTTP method
     * @return bool
     */
    protected function isMethod($method) {
        return $_SERVER['REQUEST_METHOD'] === strtoupper($method);
    }
    
    /**
     * Sanitize input data
     *
     * @param array $data Input data
     * @param bool $allowHtml Whether to allow HTML
     * @return array Sanitized data
     */
    protected function sanitizeInput($data, $allowHtml = false) {
        $sanitized = [];
        
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $sanitized[$key] = $this->sanitizeInput($value, $allowHtml);
            } else {
                if ($allowHtml) {
                    // Allow some HTML tags, but filter out dangerous ones
                    $sanitized[$key] = htmlspecialchars(strip_tags($value, '<p><a><br><b><i><strong><em><ul><ol><li><h1><h2><h3><h4><h5><h6>'));
                } else {
                    // Remove all HTML tags
                    $sanitized[$key] = htmlspecialchars(strip_tags($value));
                }
            }
        }
        
        return $sanitized;
    }
    
    /**
     * Get POST data
     *
     * @param bool $sanitize Whether to sanitize the data
     * @param bool $allowHtml Whether to allow HTML
     * @return array
     */
    protected function getPostData($sanitize = true, $allowHtml = false) {
        if ($sanitize) {
            return $this->sanitizeInput($_POST, $allowHtml);
        } else {
            return $_POST;
        }
    }
    
    /**
     * Get GET data
     *
     * @param bool $sanitize Whether to sanitize the data
     * @return array
     */
    protected function getGetData($sanitize = true) {
        if ($sanitize) {
            return $this->sanitizeInput($_GET);
        } else {
            return $_GET;
        }
    }
    
    /**
     * Validate data
     *
     * @param array $data Data to validate
     * @param array $rules Validation rules
     * @return array Errors
     */
    protected function validate($data, $rules) {
        $errors = [];
        
        foreach ($rules as $field => $rule) {
            // Split rules by '|'
            $ruleArray = explode('|', $rule);
            
            foreach ($ruleArray as $singleRule) {
                // Check if rule has a parameter
                if (strpos($singleRule, ':')) {
                    list($ruleName, $ruleParam) = explode(':', $singleRule);
                } else {
                    $ruleName = $singleRule;
                    $ruleParam = null;
                }
                
                // Apply rule
                switch ($ruleName) {
                    case 'required':
                        if (!isset($data[$field]) || $data[$field] === '') {
                            $errors[$field] = ucfirst($field) . ' is required';
                        }
                        break;
                    
                    case 'min':
                        if (isset($data[$field]) && strlen($data[$field]) < $ruleParam) {
                            $errors[$field] = ucfirst($field) . ' must be at least ' . $ruleParam . ' characters';
                        }
                        break;
                    
                    case 'max':
                        if (isset($data[$field]) && strlen($data[$field]) > $ruleParam) {
                            $errors[$field] = ucfirst($field) . ' must be at most ' . $ruleParam . ' characters';
                        }
                        break;
                    
                    case 'email':
                        if (isset($data[$field]) && !filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
                            $errors[$field] = ucfirst($field) . ' must be a valid email address';
                        }
                        break;
                    
                    case 'matches':
                        if (isset($data[$field]) && isset($data[$ruleParam]) && $data[$field] !== $data[$ruleParam]) {
                            $errors[$field] = ucfirst($field) . ' must match ' . $ruleParam;
                        }
                        break;
                    
                    case 'numeric':
                        if (isset($data[$field]) && !is_numeric($data[$field])) {
                            $errors[$field] = ucfirst($field) . ' must be a number';
                        }
                        break;
                    
                    case 'integer':
                        if (isset($data[$field]) && !filter_var($data[$field], FILTER_VALIDATE_INT)) {
                            $errors[$field] = ucfirst($field) . ' must be an integer';
                        }
                        break;
                    
                    case 'date':
                        if (isset($data[$field]) && !strtotime($data[$field])) {
                            $errors[$field] = ucfirst($field) . ' must be a valid date';
                        }
                        break;
                    
                    case 'future_date':
                        if (isset($data[$field]) && strtotime($data[$field]) < strtotime('today')) {
                            $errors[$field] = ucfirst($field) . ' must be a future date';
                        }
                        break;
                }
            }
        }
        
        return $errors;
    }
}