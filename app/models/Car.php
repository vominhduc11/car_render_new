<?php
/**
 * Car Model
 * Manages all car data
 */
class Car {
    private $db;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->db = new Database;
    }
    
    /**
     * Get all cars
     *
     * @param array $filters Optional filters
     * @param string $orderBy Order by field
     * @param string $order Sort order (ASC/DESC)
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array
     */
    public function getCars($filters = [], $orderBy = 'id', $order = 'DESC', $limit = null, $offset = null) {
        // Start query
        $sql = "SELECT * FROM cars WHERE 1=1";
        
        // Add filters
        if (!empty($filters)) {
            if (isset($filters['brand']) && !empty($filters['brand'])) {
                $sql .= " AND brand = :brand";
            }
            
            if (isset($filters['status']) && !empty($filters['status'])) {
                $sql .= " AND status = :status";
            }
            
            if (isset($filters['search']) && !empty($filters['search'])) {
                $sql .= " AND (brand LIKE :search OR model LIKE :search OR license_plate LIKE :search)";
            }
            
            if (isset($filters['min_price']) && !empty($filters['min_price'])) {
                $sql .= " AND price_per_day >= :min_price";
            }
            
            if (isset($filters['max_price']) && !empty($filters['max_price'])) {
                $sql .= " AND price_per_day <= :max_price";
            }
            
            if (isset($filters['seats']) && !empty($filters['seats'])) {
                $sql .= " AND seats = :seats";
            }
            
            if (isset($filters['transmission']) && !empty($filters['transmission'])) {
                $sql .= " AND transmission = :transmission";
            }
            
            if (isset($filters['year']) && !empty($filters['year'])) {
                $sql .= " AND year = :year";
            }
        }
        
        // Add order by
        $sql .= " ORDER BY " . $orderBy . " " . $order;
        
        // Add limit and offset
        if (!is_null($limit)) {
            $sql .= " LIMIT :limit";
            
            if (!is_null($offset)) {
                $sql .= " OFFSET :offset";
            }
        }
        
        // Prepare statement
        $this->db->query($sql);
        
        // Bind values
        if (!empty($filters)) {
            if (isset($filters['brand']) && !empty($filters['brand'])) {
                $this->db->bind(':brand', $filters['brand']);
            }
            
            if (isset($filters['status']) && !empty($filters['status'])) {
                $this->db->bind(':status', $filters['status']);
            }
            
            if (isset($filters['search']) && !empty($filters['search'])) {
                $this->db->bind(':search', '%' . $filters['search'] . '%');
            }
            
            if (isset($filters['min_price']) && !empty($filters['min_price'])) {
                $this->db->bind(':min_price', $filters['min_price']);
            }
            
            if (isset($filters['max_price']) && !empty($filters['max_price'])) {
                $this->db->bind(':max_price', $filters['max_price']);
            }
            
            if (isset($filters['seats']) && !empty($filters['seats'])) {
                $this->db->bind(':seats', $filters['seats']);
            }
            
            if (isset($filters['transmission']) && !empty($filters['transmission'])) {
                $this->db->bind(':transmission', $filters['transmission']);
            }
            
            if (isset($filters['year']) && !empty($filters['year'])) {
                $this->db->bind(':year', $filters['year']);
            }
        }
        
        // Bind limit and offset
        if (!is_null($limit)) {
            $this->db->bind(':limit', $limit, PDO::PARAM_INT);
            
            if (!is_null($offset)) {
                $this->db->bind(':offset', $offset, PDO::PARAM_INT);
            }
        }
        
        // Execute
        return $this->db->resultSet();
    }
    
    /**
     * Get car by ID
     *
     * @param int $id Car ID
     * @return array|bool Car data or false if not found
     */
    public function getCarById($id) {
        $this->db->query("SELECT * FROM cars WHERE id = :id");
        $this->db->bind(':id', $id);
        
        $car = $this->db->single();
        
        return $car ? $car : false;
    }
    
    /**
     * Add new car
     *
     * @param array $data Car data
     * @return bool
     */
    public function addCar($data) {
        // Prepare query
        $this->db->query("INSERT INTO cars (brand, model, year, license_plate, color, seats, transmission, fuel, price_per_day, image, description, status) VALUES (:brand, :model, :year, :license_plate, :color, :seats, :transmission, :fuel, :price_per_day, :image, :description, :status)");
        
        // Bind values
        $this->db->bind(':brand', $data['brand']);
        $this->db->bind(':model', $data['model']);
        $this->db->bind(':year', $data['year']);
        $this->db->bind(':license_plate', $data['license_plate']);
        $this->db->bind(':color', $data['color']);
        $this->db->bind(':seats', $data['seats']);
        $this->db->bind(':transmission', $data['transmission']);
        $this->db->bind(':fuel', $data['fuel']);
        $this->db->bind(':price_per_day', $data['price_per_day']);
        $this->db->bind(':image', $data['image'] ?? null);
        $this->db->bind(':description', $data['description'] ?? null);
        $this->db->bind(':status', $data['status'] ?? 'available');
        
        // Execute
        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }
    
    /**
     * Update car
     *
     * @param int $id Car ID
     * @param array $data Car data
     * @return bool
     */
    public function updateCar($id, $data) {
        // Prepare query
        $this->db->query("UPDATE cars SET brand = :brand, model = :model, year = :year, license_plate = :license_plate, color = :color, seats = :seats, transmission = :transmission, fuel = :fuel, price_per_day = :price_per_day, description = :description, status = :status WHERE id = :id");
        
        // Bind values
        $this->db->bind(':brand', $data['brand']);
        $this->db->bind(':model', $data['model']);
        $this->db->bind(':year', $data['year']);
        $this->db->bind(':license_plate', $data['license_plate']);
        $this->db->bind(':color', $data['color']);
        $this->db->bind(':seats', $data['seats']);
        $this->db->bind(':transmission', $data['transmission']);
        $this->db->bind(':fuel', $data['fuel']);
        $this->db->bind(':price_per_day', $data['price_per_day']);
        $this->db->bind(':description', $data['description'] ?? null);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':id', $id);
        
        // Execute
        return $this->db->execute();
    }
    
    /**
     * Update car image
     *
     * @param int $id Car ID
     * @param string $image Image path
     * @return bool
     */
    public function updateCarImage($id, $image) {
        $this->db->query("UPDATE cars SET image = :image WHERE id = :id");
        $this->db->bind(':image', $image);
        $this->db->bind(':id', $id);
        
        return $this->db->execute();
    }
    
    /**
     * Delete car
     *
     * @param int $id Car ID
     * @return bool
     */
    public function deleteCar($id) {
        $this->db->query("DELETE FROM cars WHERE id = :id");
        $this->db->bind(':id', $id);
        
        return $this->db->execute();
    }
    
    /**
     * Update car status
     *
     * @param int $id Car ID
     * @param string $status New status
     * @return bool
     */
    public function updateCarStatus($id, $status) {
        $this->db->query("UPDATE cars SET status = :status WHERE id = :id");
        $this->db->bind(':status', $status);
        $this->db->bind(':id', $id);
        
        return $this->db->execute();
    }
    
    /**
     * Check if car is available for a specific date range
     *
     * @param int $carId Car ID
     * @param string $startDate Start date (Y-m-d)
     * @param string $endDate End date (Y-m-d)
     * @param int $excludeBookingId Exclude this booking ID (for updates)
     * @return bool
     */
    public function isCarAvailable($carId, $startDate, $endDate, $excludeBookingId = null) {
        // Get car
        $car = $this->getCarById($carId);
        
        // Check if car exists and is not in maintenance
        if (!$car || $car['status'] == 'maintenance') {
            return false;
        }
        
        // Check if there are any overlapping bookings
        $sql = "SELECT COUNT(*) as count FROM bookings 
                WHERE car_id = :car_id 
                AND status IN ('pending', 'confirmed') 
                AND ((pickup_date BETWEEN :start_date AND :end_date) 
                OR (return_date BETWEEN :start_date AND :end_date) 
                OR (pickup_date <= :start_date AND return_date >= :end_date))";
        
        // Exclude current booking if updating
        if ($excludeBookingId) {
            $sql .= " AND id != :exclude_id";
        }
        
        $this->db->query($sql);
        $this->db->bind(':car_id', $carId);
        $this->db->bind(':start_date', $startDate);
        $this->db->bind(':end_date', $endDate);
        
        if ($excludeBookingId) {
            $this->db->bind(':exclude_id', $excludeBookingId);
        }
        
        $result = $this->db->single();
        
        // If count is 0, car is available
        return $result['count'] == 0;
    }
    
    /**
     * Get all available cars for a specific date range
     *
     * @param string $startDate Start date (Y-m-d)
     * @param string $endDate End date (Y-m-d)
     * @param array $filters Optional filters
     * @return array
     */
    public function getAvailableCars($startDate, $endDate, $filters = []) {
        // Start with getting all cars that aren't in maintenance
        $cars = $this->getCars(array_merge(['status' => 'available'], $filters));
        $availableCars = [];
        
        // For each car, check if it's available for the specified date range
        foreach ($cars as $car) {
            if ($this->isCarAvailable($car['id'], $startDate, $endDate)) {
                $availableCars[] = $car;
            }
        }
        
        return $availableCars;
    }
    
    /**
     * Get distinct car brands
     *
     * @return array
     */
    public function getBrands() {
        $this->db->query("SELECT DISTINCT brand FROM cars ORDER BY brand");
        
        return $this->db->resultSet();
    }
    
    /**
     * Count cars by status
     *
     * @return array
     */
    public function countByStatus() {
        $this->db->query("SELECT status, COUNT(*) as count FROM cars GROUP BY status");
        
        $results = $this->db->resultSet();
        $counts = [
            'available' => 0,
            'maintenance' => 0,
            'rented' => 0,
            'total' => 0
        ];
        
        foreach ($results as $result) {
            $counts[$result['status']] = $result['count'];
            $counts['total'] += $result['count'];
        }
        
        return $counts;
    }
}