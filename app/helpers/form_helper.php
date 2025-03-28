<?php
/**
 * Form Helper Functions
 */

/**
 * Display flash messages
 *
 * @return string HTML for flash messages
 */
function displayFlashMessage() {
    if (isset($_SESSION['flash_messages']) && !empty($_SESSION['flash_messages'])) {
        $output = '';
        
        foreach ($_SESSION['flash_messages'] as $message) {
            $class = !empty($message['class']) ? $message['class'] : 'alert alert-success';
            
            $output .= '<div class="' . $class . ' alert-dismissible fade show" role="alert">';
            $output .= $message['message'];
            $output .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            $output .= '</div>';
            
            // Remove message after displaying it
            if ($message['remove']) {
                unset($_SESSION['flash_messages'][$message['key']]);
            }
        }
        
        return $output;
    }
}

/**
 * Set flash message
 *
 * @param string $key Message key
 * @param string $message Message text
 * @param string $class CSS class (default: 'alert alert-success')
 * @param bool $remove Remove after display (default: true)
 * @return void
 */
function flash($key, $message, $class = 'alert alert-success', $remove = true) {
    // Initialize flash_messages array if it doesn't exist
    if (!isset($_SESSION['flash_messages'])) {
        $_SESSION['flash_messages'] = [];
    }
    
    // Add message to flash_messages
    $_SESSION['flash_messages'][$key] = [
        'key' => $key,
        'message' => $message,
        'class' => $class,
        'remove' => $remove
    ];
}

/**
 * Check if a form field has an error
 *
 * @param string $field Field name
 * @param array $errors Errors array
 * @return bool
 */
function hasError($field, $errors) {
    return !empty($errors[$field]);
}

/**
 * Get error class for a form field
 *
 * @param string $field Field name
 * @param array $errors Errors array
 * @param string $class CSS class for error (default: 'is-invalid')
 * @return string
 */
function getErrorClass($field, $errors, $class = 'is-invalid') {
    return hasError($field, $errors) ? $class : '';
}

/**
 * Display error message for a form field
 *
 * @param string $field Field name
 * @param array $errors Errors array
 * @param string $class CSS class for error message (default: 'invalid-feedback')
 * @return string
 */
function displayError($field, $errors, $class = 'invalid-feedback') {
    if (hasError($field, $errors)) {
        return '<div class="' . $class . '">' . $errors[$field] . '</div>';
    }
    
    return '';
}

/**
 * Generate select options
 *
 * @param array $options Options array [value => label]
 * @param mixed $selected Selected value(s)
 * @param bool $multiple Allow multiple selections
 * @return string
 */
function selectOptions($options, $selected = '', $multiple = false) {
    $output = '';
    
    // Convert selected to array if multiple
    if ($multiple && !is_array($selected)) {
        $selected = [$selected];
    }
    
    foreach ($options as $value => $label) {
        // Check if option is selected
        $isSelected = false;
        
        if ($multiple && is_array($selected)) {
            $isSelected = in_array($value, $selected);
        } else {
            $isSelected = ($value == $selected);
        }
        
        $output .= '<option value="' . htmlspecialchars($value) . '"';
        $output .= $isSelected ? ' selected' : '';
        $output .= '>' . htmlspecialchars($label) . '</option>';
    }
    
    return $output;
}

/**
 * Format price with currency
 *
 * @param float $price Price
 * @param string $currency Currency symbol (default: 'VND')
 * @param bool $showDecimal Show decimal part (default: false)
 * @return string
 */
function formatPrice($price, $currency = 'VND', $showDecimal = false) {
    if ($showDecimal) {
        $formattedPrice = number_format($price, 2, '.', ',');
    } else {
        $formattedPrice = number_format($price, 0, '.', ',');
    }
    
    if ($currency == 'VND') {
        return $formattedPrice . ' ' . $currency;
    } else {
        return $currency . ' ' . $formattedPrice;
    }
}

/**
 * Clean input data
 *
 * @param mixed $data Input data
 * @param bool $allowHtml Allow HTML tags (default: false)
 * @return mixed
 */
function cleanInput($data, $allowHtml = false) {
    if (is_array($data)) {
        $cleaned = [];
        
        foreach ($data as $key => $value) {
            $cleaned[$key] = cleanInput($value, $allowHtml);
        }
        
        return $cleaned;
    } else {
        // Trim whitespace
        $data = trim($data);
        
        if ($allowHtml) {
            // Allow specific HTML tags
            return htmlspecialchars(strip_tags($data, '<p><a><br><b><i><strong><em><ul><ol><li><h1><h2><h3><h4><h5><h6>'));
        } else {
            // Remove all HTML tags
            return htmlspecialchars(strip_tags($data));
        }
    }
}

/**
 * Generate a random string
 *
 * @param int $length String length (default: 10)
 * @param bool $includeSpecialChars Include special characters (default: true)
 * @return string
 */
function generateRandomString($length = 10, $includeSpecialChars = true) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    
    if ($includeSpecialChars) {
        $characters .= '!@#$%^&*()-_=+[]{}|;:,.<>?';
    }
    
    $charLength = strlen($characters);
    $randomString = '';
    
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charLength - 1)];
    }
    
    return $randomString;
}

/**
 * Redirect to a URL
 *
 * @param string $url URL to redirect to
 * @return void
 */
function redirect($url) {
    header('Location: ' . URLROOT . '/' . $url);
    exit;
}