<?php
/**
 * Authentication Helper Functions
 */

/**
 * Check if user is logged in
 *
 * @return bool
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Check if user is admin
 *
 * @return bool
 */
function isAdmin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin';
}

/**
 * Require login (redirect if not logged in)
 *
 * @param string $redirect URL to redirect to after login
 * @return void
 */
function requireLogin($redirect = '') {
    if (!isLoggedIn()) {
        flash('login_message', 'Please log in to access this page', 'alert alert-danger');
        
        if (!empty($redirect)) {
            $_SESSION['redirect_after_login'] = $redirect;
        }
        
        redirect('auth/login');
        exit;
    }
}

/**
 * Require admin (redirect if not admin)
 *
 * @return void
 */
function requireAdmin() {
    if (!isLoggedIn() || !isAdmin()) {
        flash('login_message', 'You are not authorized to access this page', 'alert alert-danger');
        
        if (isLoggedIn()) {
            redirect('home');
        } else {
            redirect('auth/login');
        }
        
        exit;
    }
}

/**
 * Generate CSRF token
 *
 * @return string
 */
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    
    return $_SESSION['csrf_token'];
}

/**
 * Check CSRF token
 *
 * @param string $token Token to check
 * @return bool
 */
function checkCSRFToken($token) {
    if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
        return false;
    }
    
    return true;
}

/**
 * Get CSRF token input field
 *
 * @return string HTML input field
 */
function csrfField() {
    $token = generateCSRFToken();
    return '<input type="hidden" name="csrf_token" value="' . $token . '">';
}