<?php
/**
 * Review Model
 * Handles reviews functionality
 */
class Review extends Model {
    protected $table = 'reviews';
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get reviews by car
     *
     * @param int $carId Car ID
     * @return array
     */
    public function getReviewsByCar($carId) {
        $this->db->query("SELECT r.*, u.username, u.full_name 
                         FROM {$this->table} r
                         JOIN users u ON r.user_id = u.id
                         WHERE r.car_id = :car_id
                         ORDER BY r.created_at DESC");
                         
        $this->db->bind(':car_id', $carId);
        
        return $this->db->resultSet();
    }
    
    /**
     * Get reviews by user
     *
     * @param int $userId User ID
     * @return array
     */
    public function getReviewsByUser($userId) {
        $this->db->query("SELECT r.*, c.brand, c.model, c.image 
                         FROM {$this->table} r
                         JOIN cars c ON r.car_id = c.id
                         WHERE r.user_id = :user_id
                         ORDER BY r.created_at DESC");
                         
        $this->db->bind(':user_id', $userId);
        
        return $this->db->resultSet();
    }
    
    /**
     * Get review by booking
     *
     * @param int $bookingId Booking ID
     * @return array|bool
     */
    public function getReviewByBooking($bookingId) {
        return $this->getSingleByField('booking_id', $bookingId);
    }
    
    /**
     * Add review
     *
     * @param array $data Review data
     * @return bool|int
     */
    public function addReview($data) {
        return $this->create([
            'user_id' => $data['user_id'],
            'car_id' => $data['car_id'],
            'booking_id' => $data['booking_id'],
            'rating' => $data['rating'],
            'comment' => $data['comment']
        ]);
    }
    
    /**
     * Update review
     *
     * @param int $id Review ID
     * @param array $data Review data
     * @return bool
     */
    public function updateReview($id, $data) {
        return $this->update($id, [
            'rating' => $data['rating'],
            'comment' => $data['comment']
        ]);
    }
    
    /**
     * Check if user can review a booking
     *
     * @param int $userId User ID
     * @param int $bookingId Booking ID
     * @return bool
     */
    public function canReviewBooking($userId, $bookingId) {
        // Get booking details
        $this->db->query("SELECT b.* FROM bookings b
                         WHERE b.id = :booking_id AND b.user_id = :user_id AND b.status = 'completed'");
                         
        $this->db->bind(':booking_id', $bookingId);
        $this->db->bind(':user_id', $userId);
        
        $booking = $this->db->single();
        
        // Check if booking exists and is completed
        if (!$booking) {
            return false;
        }
        
        // Check if review already exists
        $existingReview = $this->getReviewByBooking($bookingId);
        
        return !$existingReview;
    }
    
    /**
     * Get average rating for a car
     *
     * @param int $carId Car ID
     * @return float
     */
    public function getAverageRating($carId) {
        $this->db->query("SELECT AVG(rating) as avg_rating FROM {$this->table} WHERE car_id = :car_id");
        $this->db->bind(':car_id', $carId);
        
        $result = $this->db->single();
        
        return $result ? round($result['avg_rating'], 1) : 0;
    }
    
    /**
     * Get rating count for a car
     *
     * @param int $carId Car ID
     * @return array
     */
    public function getRatingCount($carId) {
        $this->db->query("SELECT rating, COUNT(*) as count FROM {$this->table} WHERE car_id = :car_id GROUP BY rating ORDER BY rating DESC");
        $this->db->bind(':car_id', $carId);
        
        $results = $this->db->resultSet();
        
        $counts = [
            5 => 0,
            4 => 0,
            3 => 0,
            2 => 0,
            1 => 0
        ];
        
        foreach ($results as $result) {
            $counts[$result['rating']] = $result['count'];
        }
        
        return $counts;
    }
    
    /**
     * Get recently added reviews
     *
     * @param int $limit Limit (default: 5)
     * @return array
     */
    public function getRecentReviews($limit = 5) {
        $this->db->query("SELECT r.*, u.username, u.full_name, c.brand, c.model, c.image 
                         FROM {$this->table} r
                         JOIN users u ON r.user_id = u.id
                         JOIN cars c ON r.car_id = c.id
                         ORDER BY r.created_at DESC
                         LIMIT :limit");
                         
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        
        return $this->db->resultSet();
    }
}