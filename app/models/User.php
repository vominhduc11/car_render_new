<?php
/**
 * User Model
 * Handles all user data and authentication
 */
class User extends Model {
    protected $table = 'users';
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Register user
     *
     * @param array $data User data
     * @return bool|int
     */
    public function register($data) {
        return $this->create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
            'full_name' => $data['full_name'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'role' => 'user'
        ]);
    }
    
    /**
     * Login user
     *
     * @param string $username Username
     * @param string $password Password
     * @return bool|array
     */
    public function login($username, $password) {
        // Find user by username
        $user = $this->findUserByUsername($username);
        
        // If user found, verify password
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }
    
    /**
     * Find user by username
     *
     * @param string $username Username
     * @return bool|array
     */
    public function findUserByUsername($username) {
        return $this->getSingleByField('username', $username);
    }
    
    /**
     * Find user by email
     *
     * @param string $email Email
     * @return bool|array
     */
    public function findUserByEmail($email) {
        return $this->getSingleByField('email', $email);
    }
    
    /**
     * Find user by reset token
     *
     * @param string $token Reset token
     * @return bool|array
     */
    public function findUserByResetToken($token) {
        $this->db->query("SELECT * FROM users WHERE reset_token = :token AND reset_expires > NOW()");
        $this->db->bind(':token', $token);
        
        $user = $this->db->single();
        
        return $user ? $user : false;
    }
    
    /**
     * Set reset token
     *
     * @param string $email User email
     * @param string $token Reset token
     * @return bool
     */
    public function setResetToken($email, $token) {
        // Set token expiration (24 hours from now)
        $expires = date('Y-m-d H:i:s', time() + 86400);
        
        $this->db->query("UPDATE users SET reset_token = :token, reset_expires = :expires WHERE email = :email");
        $this->db->bind(':token', $token);
        $this->db->bind(':expires', $expires);
        $this->db->bind(':email', $email);
        
        return $this->db->execute();
    }
    
    /**
     * Reset password
     *
     * @param string $token Reset token
     * @param string $password New password
     * @return bool
     */
    public function resetPassword($token, $password) {
        $this->db->query("UPDATE users SET password = :password, reset_token = NULL, reset_expires = NULL WHERE reset_token = :token AND reset_expires > NOW()");
        $this->db->bind(':password', $password);
        $this->db->bind(':token', $token);
        
        return $this->db->execute();
    }
    
    /**
     * Update user
     *
     * @param int $id User ID
     * @param array $data User data
     * @return bool
     */
    public function updateUser($id, $data) {
        $updateData = [];
        
        // Only update provided fields
        if (isset($data['email'])) $updateData['email'] = $data['email'];
        if (isset($data['full_name'])) $updateData['full_name'] = $data['full_name'];
        if (isset($data['phone'])) $updateData['phone'] = $data['phone'];
        if (isset($data['address'])) $updateData['address'] = $data['address'];
        
        return $this->update($id, $updateData);
    }
    
    /**
     * Update password
     *
     * @param int $id User ID
     * @param string $password New password
     * @return bool
     */
    public function updatePassword($id, $password) {
        return $this->update($id, ['password' => $password]);
    }
    
    /**
     * Verify current password
     *
     * @param int $id User ID
     * @param string $password Current password
     * @return bool
     */
    public function verifyPassword($id, $password) {
        $user = $this->getById($id);
        
        return $user && password_verify($password, $user['password']);
    }
    
    /**
     * Get user bookings
     *
     * @param int $userId User ID
     * @param string $status Booking status (optional)
     * @return array
     */
    public function getUserBookings($userId, $status = null) {
        $sql = "SELECT b.*, c.brand, c.model, c.license_plate, c.image 
                FROM bookings b
                JOIN cars c ON b.car_id = c.id
                WHERE b.user_id = :user_id";
        
        if ($status) {
            $sql .= " AND b.status = :status";
        }
        
        $sql .= " ORDER BY b.created_at DESC";
        
        $this->db->query($sql);
        $this->db->bind(':user_id', $userId);
        
        if ($status) {
            $this->db->bind(':status', $status);
        }
        
        return $this->db->resultSet();
    }
    
    /**
     * Count users by role
     *
     * @return array
     */
    public function countByRole() {
        $this->db->query("SELECT role, COUNT(*) as count FROM users GROUP BY role");
        
        $results = $this->db->resultSet();
        $counts = [
            'admin' => 0,
            'user' => 0,
            'total' => 0
        ];
        
        foreach ($results as $result) {
            $counts[$result['role']] = $result['count'];
            $counts['total'] += $result['count'];
        }
        
        return $counts;
    }
    
    /**
     * Get new users count
     *
     * @param int $days Number of days
     * @return int
     */
    public function getNewUsersCount($days = 30) {
        $this->db->query("SELECT COUNT(*) as count FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL :days DAY)");
        $this->db->bind(':days', $days);
        
        $result = $this->db->single();
        
        return $result['count'] ?? 0;
    }
    
    /**
     * Set user role
     *
     * @param int $id User ID
     * @param string $role New role
     * @return bool
     */
    public function setRole($id, $role) {
        return $this->update($id, ['role' => $role]);
    }
}