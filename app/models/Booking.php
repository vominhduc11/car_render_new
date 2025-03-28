<?php
/**
 * Booking Model
 * Manages all booking data
 */
class Booking {
    private $db;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->db = new Database;
    }
    
    /**
     * Get all bookings
     *
     * @param array $filters Optional filters
     * @param string $orderBy Order by field
     * @param string $order Sort order (ASC/DESC)
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array
     */
    public function getBookings($filters = [], $orderBy = 'created_at', $order = 'DESC', $limit = null, $offset = null) {
        // Start query with joins to get car and user details
        $sql = "SELECT b.*, u.username, u.full_name, u.phone, c.brand, c.model, c.license_plate 
                FROM bookings b
                JOIN users u ON b.user_id = u.id
                JOIN cars c ON b.car_id = c.id
                WHERE 1=1";
        
        // Add filters
        if (!empty($filters)) {
            if (isset($filters['user_id']) && !empty($filters['user_id'])) {
                $sql .= " AND b.user_id = :user_id";
            }
            
            if (isset($filters['car_id']) && !empty($filters['car_id'])) {
                $sql .= " AND b.car_id = :car_id";
            }
            
            if (isset($filters['status']) && !empty($filters['status'])) {
                $sql .= " AND b.status = :status";
            }
            
            if (isset($filters['payment_status']) && !empty($filters['payment_status'])) {
                $sql .= " AND b.payment_status = :payment_status";
            }
            
            if (isset($filters['search']) && !empty($filters['search'])) {
                $sql .= " AND (u.full_name LIKE :search OR u.username LIKE :search OR c.brand LIKE :search OR c.model LIKE :search OR c.license_plate LIKE :search)";
            }
            
            if (isset($filters['date_from']) && !empty($filters['date_from'])) {
                $sql .= " AND ((b.pickup_date >= :date_from) OR (b.return_date >= :date_from))";
            }
            
            if (isset($filters['date_to']) && !empty($filters['date_to'])) {
                $sql .= " AND ((b.pickup_date <= :date_to) OR (b.return_date <= :date_to))";
            }
        }
        
        // Add order by
        $sql .= " ORDER BY b." . $orderBy . " " . $order;
        
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
            if (isset($filters['user_id']) && !empty($filters['user_id'])) {
                $this->db->bind(':user_id', $filters['user_id']);
            }
            
            if (isset($filters['car_id']) && !empty($filters['car_id'])) {
                $this->db->bind(':car_id', $filters['car_id']);
            }
            
            if (isset($filters['status']) && !empty($filters['status'])) {
                $this->db->bind(':status', $filters['status']);
            }
            
            if (isset($filters['payment_status']) && !empty($filters['payment_status'])) {
                $this->db->bind(':payment_status', $filters['payment_status']);
            }
            
            if (isset($filters['search']) && !empty($filters['search'])) {
                $this->db->bind(':search', '%' . $filters['search'] . '%');
            }
            
            if (isset($filters['date_from']) && !empty($filters['date_from'])) {
                $this->db->bind(':date_from', $filters['date_from']);
            }
            
            if (isset($filters['date_to']) && !empty($filters['date_to'])) {
                $this->db->bind(':date_to', $filters['date_to']);
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
     * Get booking by ID
     *
     * @param int $id Booking ID
     * @return array|bool Booking data or false if not found
     */
    public function getBookingById($id) {
        $this->db->query("SELECT b.*, u.username, u.full_name, u.phone, u.email, c.brand, c.model, c.license_plate, c.price_per_day, c.image 
                         FROM bookings b
                         JOIN users u ON b.user_id = u.id
                         JOIN cars c ON b.car_id = c.id
                         WHERE b.id = :id");
        $this->db->bind(':id', $id);
        
        $booking = $this->db->single();
        
        return $booking ? $booking : false;
    }
    
    /**
     * Add new booking
     *
     * @param array $data Booking data
     * @return bool|int Booking ID or false if failed
     */
    public function addBooking($data) {
        // Start transaction
        $this->db->beginTransaction();
        
        try {
            // Insert booking
            $this->db->query("INSERT INTO bookings (user_id, car_id, pickup_date, return_date, pickup_location, return_location, total_price, status, payment_status) 
                            VALUES (:user_id, :car_id, :pickup_date, :return_date, :pickup_location, :return_location, :total_price, :status, :payment_status)");
            
            // Bind values
            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':car_id', $data['car_id']);
            $this->db->bind(':pickup_date', $data['pickup_date']);
            $this->db->bind(':return_date', $data['return_date']);
            $this->db->bind(':pickup_location', $data['pickup_location']);
            $this->db->bind(':return_location', $data['return_location']);
            $this->db->bind(':total_price', $data['total_price']);
            $this->db->bind(':status', $data['status'] ?? 'pending');
            $this->db->bind(':payment_status', $data['payment_status'] ?? 'pending');
            
            // Execute
            $this->db->execute();
            $bookingId = $this->db->lastInsertId();
            
            // If booking is confirmed, update car status
            if (($data['status'] ?? 'pending') == 'confirmed') {
                $this->db->query("UPDATE cars SET status = 'rented' WHERE id = :car_id");
                $this->db->bind(':car_id', $data['car_id']);
                $this->db->execute();
            }
            
            // Commit transaction
            $this->db->commit();
            
            return $bookingId;
        } catch (Exception $e) {
            // Rollback transaction on error
            $this->db->rollBack();
            error_log('Error adding booking: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Update booking
     *
     * @param int $id Booking ID
     * @param array $data Booking data
     * @return bool
     */
    public function updateBooking($id, $data) {
        // Get current booking
        $currentBooking = $this->getBookingById($id);
        
        if (!$currentBooking) {
            return false;
        }
        
        // Start transaction
        $this->db->beginTransaction();
        
        try {
            // Update booking
            $this->db->query("UPDATE bookings SET 
                            status = :status, 
                            payment_status = :payment_status, 
                            pickup_date = :pickup_date, 
                            return_date = :return_date, 
                            pickup_location = :pickup_location, 
                            return_location = :return_location, 
                            total_price = :total_price,
                            admin_notes = :admin_notes
                            WHERE id = :id");
            
            // Bind values
            $this->db->bind(':status', $data['status']);
            $this->db->bind(':payment_status', $data['payment_status']);
            $this->db->bind(':pickup_date', $data['pickup_date']);
            $this->db->bind(':return_date', $data['return_date']);
            $this->db->bind(':pickup_location', $data['pickup_location']);
            $this->db->bind(':return_location', $data['return_location']);
            $this->db->bind(':total_price', $data['total_price']);
            $this->db->bind(':admin_notes', $data['admin_notes'] ?? null);
            $this->db->bind(':id', $id);
            
            // Execute booking update
            $this->db->execute();
            
            // Handle car status changes based on booking status changes
            if ($data['status'] != $currentBooking['status']) {
                // If new status is 'confirmed', update car to 'rented'
                if ($data['status'] == 'confirmed' && $currentBooking['status'] != 'confirmed') {
                    $this->db->query("UPDATE cars SET status = 'rented' WHERE id = :car_id");
                    $this->db->bind(':car_id', $currentBooking['car_id']);
                    $this->db->execute();
                }
                
                // If new status is 'completed' or 'cancelled', update car to 'available'
                if (($data['status'] == 'completed' || $data['status'] == 'cancelled') && 
                    ($currentBooking['status'] == 'confirmed' || $currentBooking['status'] == 'pending')) {
                    $this->db->query("UPDATE cars SET status = 'available' WHERE id = :car_id");
                    $this->db->bind(':car_id', $currentBooking['car_id']);
                    $this->db->execute();
                }
            }
            
            // Commit transaction
            $this->db->commit();
            
            return true;
        } catch (Exception $e) {
            // Rollback transaction on error
            $this->db->rollBack();
            error_log('Error updating booking: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Update booking status
     *
     * @param int $id Booking ID
     * @param string $status New status
     * @return bool
     */
    public function updateBookingStatus($id, $status) {
        // Get current booking
        $currentBooking = $this->getBookingById($id);
        
        if (!$currentBooking) {
            return false;
        }
        
        // Start transaction
        $this->db->beginTransaction();
        
        try {
            // Update booking status
            $this->db->query("UPDATE bookings SET status = :status WHERE id = :id");
            $this->db->bind(':status', $status);
            $this->db->bind(':id', $id);
            $this->db->execute();
            
            // Handle car status changes based on booking status changes
            if ($status != $currentBooking['status']) {
                // If new status is 'confirmed', update car to 'rented'
                if ($status == 'confirmed' && $currentBooking['status'] != 'confirmed') {
                    $this->db->query("UPDATE cars SET status = 'rented' WHERE id = :car_id");
                    $this->db->bind(':car_id', $currentBooking['car_id']);
                    $this->db->execute();
                }
                
                // If new status is 'completed' or 'cancelled', update car to 'available'
                if (($status == 'completed' || $status == 'cancelled') && 
                    ($currentBooking['status'] == 'confirmed' || $currentBooking['status'] == 'pending')) {
                    $this->db->query("UPDATE cars SET status = 'available' WHERE id = :car_id");
                    $this->db->bind(':car_id', $currentBooking['car_id']);
                    $this->db->execute();
                }
            }
            
            // Commit transaction
            $this->db->commit();
            
            return true;
        } catch (Exception $e) {
            // Rollback transaction on error
            $this->db->rollBack();
            error_log('Error updating booking status: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Update booking payment status
     *
     * @param int $id Booking ID
     * @param string $paymentStatus New payment status
     * @return bool
     */
    public function updatePaymentStatus($id, $paymentStatus) {
        $this->db->query("UPDATE bookings SET payment_status = :payment_status WHERE id = :id");
        $this->db->bind(':payment_status', $paymentStatus);
        $this->db->bind(':id', $id);
        
        return $this->db->execute();
    }
    
    /**
     * Delete booking
     *
     * @param int $id Booking ID
     * @return bool
     */
    public function deleteBooking($id) {
        // Get current booking
        $currentBooking = $this->getBookingById($id);
        
        if (!$currentBooking) {
            return false;
        }
        
        // Start transaction
        $this->db->beginTransaction();
        
        try {
            // Delete booking
            $this->db->query("DELETE FROM bookings WHERE id = :id");
            $this->db->bind(':id', $id);
            $this->db->execute();
            
            // If booking was confirmed, update car status back to available
            if ($currentBooking['status'] == 'confirmed') {
                $this->db->query("UPDATE cars SET status = 'available' WHERE id = :car_id");
                $this->db->bind(':car_id', $currentBooking['car_id']);
                $this->db->execute();
            }
            
            // Commit transaction
            $this->db->commit();
            
            return true;
        } catch (Exception $e) {
            // Rollback transaction on error
            $this->db->rollBack();
            error_log('Error deleting booking: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Count bookings by status
     *
     * @return array
     */
    public function countByStatus() {
        $this->db->query("SELECT status, COUNT(*) as count FROM bookings GROUP BY status");
        
        $results = $this->db->resultSet();
        $counts = [
            'pending' => 0,
            'confirmed' => 0,
            'completed' => 0,
            'cancelled' => 0,
            'total' => 0
        ];
        
        foreach ($results as $result) {
            $counts[$result['status']] = $result['count'];
            $counts['total'] += $result['count'];
        }
        
        return $counts;
    }
    
    /**
     * Get total revenue
     *
     * @param string $period Period (all, year, month, week)
     * @return float
     */
    public function getTotalRevenue($period = 'all') {
        $sql = "SELECT SUM(total_price) as total FROM bookings WHERE status = 'completed'";
        
        switch ($period) {
            case 'year':
                $sql .= " AND YEAR(updated_at) = YEAR(CURRENT_DATE())";
                break;
            case 'month':
                $sql .= " AND YEAR(updated_at) = YEAR(CURRENT_DATE()) AND MONTH(updated_at) = MONTH(CURRENT_DATE())";
                break;
            case 'week':
                $sql .= " AND YEARWEEK(updated_at) = YEARWEEK(CURRENT_DATE())";
                break;
        }
        
        $this->db->query($sql);
        $result = $this->db->single();
        
        return $result['total'] ?? 0;
    }
    
    /**
     * Get revenue by month
     *
     * @param int $year Year (default: current year)
     * @return array
     */
    public function getRevenueByMonth($year = null) {
        $year = $year ?? date('Y');
        
        $this->db->query("SELECT MONTH(updated_at) as month, SUM(total_price) as revenue 
                         FROM bookings 
                         WHERE status = 'completed' AND YEAR(updated_at) = :year 
                         GROUP BY MONTH(updated_at)
                         ORDER BY MONTH(updated_at)");
        $this->db->bind(':year', $year);
        
        $results = $this->db->resultSet();
        $revenue = array_fill(1, 12, 0); // Initialize with zeros for all months
        
        foreach ($results as $result) {
            $revenue[$result['month']] = (float)$result['revenue'];
        }
        
        return $revenue;
    }
    
    /**
     * Get user active bookings count
     *
     * @param int $userId User ID
     * @return int
     */
    public function getUserActiveBookingsCount($userId) {
        $this->db->query("SELECT COUNT(*) as count FROM bookings WHERE user_id = :user_id AND status IN ('pending', 'confirmed')");
        $this->db->bind(':user_id', $userId);
        
        $result = $this->db->single();
        
        return $result['count'] ?? 0;
    }
}