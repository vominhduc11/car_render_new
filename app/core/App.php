<?php
/**
 * Application Core Class
 * Creates URL & loads core controller
 * URL FORMAT - /controller/method/params
 */
class App {
    protected $router;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->initializeErrorHandling();
        $this->loadHelpers();
        $this->router = new Router();
    }
    
    /**
     * Initialize error handling
     */
    private function initializeErrorHandling() {
        // Set custom error handler
        set_error_handler(function($errno, $errstr, $errfile, $errline) {
            if (!(error_reporting() & $errno)) {
                // This error code is not included in error_reporting
                return;
            }
            
            $error = [
                'type' => $errno,
                'message' => $errstr,
                'file' => $errfile,
                'line' => $errline
            ];
            
            $this->logError($error);
            
            if (DISPLAY_ERRORS) {
                $this->displayError($error);
            } else {
                $this->displayFriendlyError();
            }
            
            return true;
        });
        
        // Set custom exception handler
        set_exception_handler(function($exception) {
            $error = [
                'type' => get_class($exception),
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => $exception->getTraceAsString()
            ];
            
            $this->logError($error);
            
            if (DISPLAY_ERRORS) {
                $this->displayException($error);
            } else {
                $this->displayFriendlyError();
            }
        });
    }
    
    /**
     * Log error to file
     * 
     * @param array $error Error details
     */
    private function logError($error) {
        $logPath = APPROOT . '/logs';
        
        // Create logs directory if it doesn't exist
        if (!is_dir($logPath)) {
            mkdir($logPath, 0777, true);
        }
        
        $logFile = $logPath . '/error_' . date('Y-m-d') . '.log';
        $timestamp = date('Y-m-d H:i:s');
        
        // Format error message
        $logMessage = "[{$timestamp}] ";
        $logMessage .= isset($error['type']) ? "[{$error['type']}] " : '';
        $logMessage .= isset($error['message']) ? "{$error['message']} " : '';
        $logMessage .= isset($error['file']) ? "in {$error['file']} " : '';
        $logMessage .= isset($error['line']) ? "on line {$error['line']} " : '';
        $logMessage .= isset($error['trace']) ? "\nStack trace:\n{$error['trace']}" : '';
        $logMessage .= "\n";
        
        // Write to log file
        file_put_contents($logFile, $logMessage, FILE_APPEND);
    }
    
    /**
     * Display error
     * 
     * @param array $error Error details
     */
    private function displayError($error) {
        $errorTypes = [
            E_ERROR => 'Error',
            E_WARNING => 'Warning',
            E_PARSE => 'Parse Error',
            E_NOTICE => 'Notice',
            E_CORE_ERROR => 'Core Error',
            E_CORE_WARNING => 'Core Warning',
            E_COMPILE_ERROR => 'Compile Error',
            E_COMPILE_WARNING => 'Compile Warning',
            E_USER_ERROR => 'User Error',
            E_USER_WARNING => 'User Warning',
            E_USER_NOTICE => 'User Notice',
            E_STRICT => 'Strict Standards',
            E_RECOVERABLE_ERROR => 'Recoverable Error',
            E_DEPRECATED => 'Deprecated',
            E_USER_DEPRECATED => 'User Deprecated'
        ];
        
        $errorType = isset($errorTypes[$error['type']]) ? $errorTypes[$error['type']] : 'Unknown Error';
        
        echo "<div style='background-color: #f8d7da; color: #721c24; padding: 10px; margin: 10px 0; border: 1px solid #f5c6cb; border-radius: 5px;'>";
        echo "<h2>{$errorType}</h2>";
        echo "<p><strong>Message:</strong> {$error['message']}</p>";
        echo "<p><strong>File:</strong> {$error['file']}</p>";
        echo "<p><strong>Line:</strong> {$error['line']}</p>";
        echo "</div>";
    }
    
    /**
     * Display exception
     * 
     * @param array $error Exception details
     */
    private function displayException($error) {
        echo "<div style='background-color: #f8d7da; color: #721c24; padding: 10px; margin: 10px 0; border: 1px solid #f5c6cb; border-radius: 5px;'>";
        echo "<h2>{$error['type']}</h2>";
        echo "<p><strong>Message:</strong> {$error['message']}</p>";
        echo "<p><strong>File:</strong> {$error['file']}</p>";
        echo "<p><strong>Line:</strong> {$error['line']}</p>";
        echo "<p><strong>Stack Trace:</strong></p>";
        echo "<pre>{$error['trace']}</pre>";
        echo "</div>";
    }
    
    /**
     * Display friendly error message
     */
    private function displayFriendlyError() {
        http_response_code(500);
        
        // Check if error view exists
        if (file_exists('../app/views/errors/500.php')) {
            require_once '../app/views/errors/500.php';
        } else {
            echo "<div style='text-align: center; padding: 50px;'>";
            echo "<h1>Something went wrong!</h1>";
            echo "<p>We're sorry, but there was an error processing your request.</p>";
            echo "<p>Please try again later or contact support if the problem persists.</p>";
            echo "</div>";
        }
    }
    
    /**
     * Load helper functions
     */
    private function loadHelpers() {
        // Load all helpers
        $helperPath = APPROOT . '/helpers';
        $helpers = glob($helperPath . '/*.php');
        
        foreach ($helpers as $helper) {
            require_once $helper;
        }
    }
}