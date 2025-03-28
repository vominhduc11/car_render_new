<?php
/**
 * Database Class
 * PDO Database Class
 * Connects to database
 * Creates prepared statements
 * Binds values
 * Returns rows and results
 */
class Database {
    private $host = "localhost";
    private $user = "root";
    private $pass = "123456";
    private $dbname = "car_rental_new";
    
    private $dbh; // Database handler
    private $stmt; // Statement
    private $error;

    /**
     * Constructor - Establish database connection
     */
    public function __construct() {
        // Set DSN (Data Source Name)
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';charset=utf8mb4';
        
        // Set PDO options
        $options = array(
            PDO::ATTR_PERSISTENT => true, // Persistent connection
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Throw exceptions
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Return associative arrays
            PDO::ATTR_EMULATE_PREPARES => false // Use real prepared statements
        );
        
        // Create PDO instance
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            error_log('Database Error: ' . $this->error);
            die('Database connection failed: ' . $this->error);
        }
    }

    /**
     * Prepare the SQL statement
     *
     * @param string $sql SQL query
     * @return void
     */
    public function query($sql) {
        $this->stmt = $this->dbh->prepare($sql);
    }
    
    /**
     * Bind values to parameters
     *
     * @param string $param Parameter placeholder in query
     * @param mixed $value Actual value to be bound
     * @param mixed $type PDO param type (optional)
     * @return void
     */
    public function bind($param, $value, $type = null) {
        // If type is not specified, determine it based on the value
        if(is_null($type)) {
            switch(true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        
        $this->stmt->bindValue($param, $value, $type);
    }
    
    /**
     * Execute the prepared statement
     *
     * @return bool
     */
    public function execute() {
        try {
            return $this->stmt->execute();
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            error_log('Query Error: ' . $this->error);
            return false;
        }
    }
    
    /**
     * Get result set as array of objects
     *
     * @return array
     */
    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll();
    }
    
    /**
     * Get single record as object
     *
     * @return object
     */
    public function single() {
        $this->execute();
        return $this->stmt->fetch();
    }
    
    /**
     * Get row count
     *
     * @return int
     */
    public function rowCount() {
        return $this->stmt->rowCount();
    }
    
    /**
     * Get last inserted ID
     *
     * @return int
     */
    public function lastInsertId() {
        return $this->dbh->lastInsertId();
    }
    
    /**
     * Begin a transaction
     *
     * @return bool
     */
    public function beginTransaction() {
        return $this->dbh->beginTransaction();
    }
    
    /**
     * Commit a transaction
     *
     * @return bool
     */
    public function commit() {
        return $this->dbh->commit();
    }
    
    /**
     * Rollback a transaction
     *
     * @return bool
     */
    public function rollBack() {
        return $this->dbh->rollBack();
    }
    
    /**
     * Debug dump parameters
     *
     * @return void
     */
    public function debugDumpParams() {
        return $this->stmt->debugDumpParams();
    }
    
    /**
     * Get the error message
     *
     * @return string
     */
    public function getError() {
        return $this->error;
    }
}