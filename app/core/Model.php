<?php
/**
 * Base Model
 * Contains common model functionality
 */
class Model {
    protected $db;
    protected $table;
    protected $primaryKey = 'id';
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->db = new Database;
    }
    
    /**
     * Get all records
     *
     * @param string $orderBy Order by field
     * @param string $order Sort order (ASC/DESC)
     * @return array
     */
    public function getAll($orderBy = 'id', $order = 'DESC') {
        $this->db->query("SELECT * FROM {$this->table} ORDER BY {$orderBy} {$order}");
        return $this->db->resultSet();
    }
    
    /**
     * Get single record by ID
     *
     * @param int $id Record ID
     * @return array|bool
     */
    public function getById($id) {
        $this->db->query("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id");
        $this->db->bind(':id', $id);
        
        $row = $this->db->single();
        
        return $row ? $row : false;
    }
    
    /**
     * Delete record by ID
     *
     * @param int $id Record ID
     * @return bool
     */
    public function delete($id) {
        $this->db->query("DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id");
        $this->db->bind(':id', $id);
        
        return $this->db->execute();
    }
    
    /**
     * Count all records
     *
     * @return int
     */
    public function count() {
        $this->db->query("SELECT COUNT(*) as count FROM {$this->table}");
        $result = $this->db->single();
        
        return $result['count'] ?? 0;
    }
    
    /**
     * Count records by field value
     *
     * @param string $field Field name
     * @param mixed $value Field value
     * @return int
     */
    public function countByField($field, $value) {
        $this->db->query("SELECT COUNT(*) as count FROM {$this->table} WHERE {$field} = :{$field}");
        $this->db->bind(":{$field}", $value);
        $result = $this->db->single();
        
        return $result['count'] ?? 0;
    }
    
    /**
     * Get records by field value
     *
     * @param string $field Field name
     * @param mixed $value Field value
     * @param string $orderBy Order by field
     * @param string $order Sort order (ASC/DESC)
     * @return array
     */
    public function getByField($field, $value, $orderBy = 'id', $order = 'DESC') {
        $this->db->query("SELECT * FROM {$this->table} WHERE {$field} = :{$field} ORDER BY {$orderBy} {$order}");
        $this->db->bind(":{$field}", $value);
        
        return $this->db->resultSet();
    }
    
    /**
     * Get single record by field value
     *
     * @param string $field Field name
     * @param mixed $value Field value
     * @return array|bool
     */
    public function getSingleByField($field, $value) {
        $this->db->query("SELECT * FROM {$this->table} WHERE {$field} = :{$field}");
        $this->db->bind(":{$field}", $value);
        
        $row = $this->db->single();
        
        return $row ? $row : false;
    }
    
    /**
     * Check if record exists
     *
     * @param string $field Field name
     * @param mixed $value Field value
     * @param int $excludeId Exclude this ID (for updates)
     * @return bool
     */
    public function exists($field, $value, $excludeId = null) {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE {$field} = :{$field}";
        
        if ($excludeId !== null) {
            $sql .= " AND {$this->primaryKey} != :exclude_id";
        }
        
        $this->db->query($sql);
        $this->db->bind(":{$field}", $value);
        
        if ($excludeId !== null) {
            $this->db->bind(":exclude_id", $excludeId);
        }
        
        $result = $this->db->single();
        
        return ($result['count'] > 0);
    }
    
    /**
     * Get paginated records
     *
     * @param int $page Page number
     * @param int $perPage Records per page
     * @param string $orderBy Order by field
     * @param string $order Sort order (ASC/DESC)
     * @return array
     */
    public function paginate($page = 1, $perPage = 10, $orderBy = 'id', $order = 'DESC') {
        // Calculate offset
        $offset = ($page - 1) * $perPage;
        
        // Get records
        $this->db->query("SELECT * FROM {$this->table} ORDER BY {$orderBy} {$order} LIMIT :perPage OFFSET :offset");
        $this->db->bind(':perPage', $perPage, PDO::PARAM_INT);
        $this->db->bind(':offset', $offset, PDO::PARAM_INT);
        
        $records = $this->db->resultSet();
        
        // Get total records
        $total = $this->count();
        
        // Calculate total pages
        $totalPages = ceil($total / $perPage);
        
        return [
            'data' => $records,
            'meta' => [
                'page' => $page,
                'per_page' => $perPage,
                'total' => $total,
                'total_pages' => $totalPages
            ]
        ];
    }
    
    /**
     * Search records
     *
     * @param array $fields Fields to search in
     * @param string $query Search query
     * @param string $orderBy Order by field
     * @param string $order Sort order (ASC/DESC)
     * @return array
     */
    public function search($fields, $query, $orderBy = 'id', $order = 'DESC') {
        // Build WHERE clause
        $where = [];
        foreach ($fields as $field) {
            $where[] = "{$field} LIKE :query";
        }
        
        $whereString = implode(' OR ', $where);
        
        // Build query
        $this->db->query("SELECT * FROM {$this->table} WHERE {$whereString} ORDER BY {$orderBy} {$order}");
        $this->db->bind(':query', "%{$query}%");
        
        return $this->db->resultSet();
    }
    
    /**
     * Create record
     *
     * @param array $data Record data
     * @return bool|int
     */
    protected function create($data) {
        // Build query
        $fields = array_keys($data);
        $fieldString = implode(', ', $fields);
        $valueString = ':' . implode(', :', $fields);
        
        $this->db->query("INSERT INTO {$this->table} ({$fieldString}) VALUES ({$valueString})");
        
        // Bind values
        foreach ($data as $key => $value) {
            $this->db->bind(":{$key}", $value);
        }
        
        // Execute
        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }
    
    /**
     * Update record
     *
     * @param int $id Record ID
     * @param array $data Record data
     * @return bool
     */
    protected function update($id, $data) {
        // Build query
        $fields = array_keys($data);
        $fieldString = '';
        foreach ($fields as $field) {
            $fieldString .= "{$field} = :{$field}, ";
        }
        $fieldString = rtrim($fieldString, ', ');
        
        $this->db->query("UPDATE {$this->table} SET {$fieldString} WHERE {$this->primaryKey} = :id");
        
        // Bind values
        $this->db->bind(':id', $id);
        foreach ($data as $key => $value) {
            $this->db->bind(":{$key}", $value);
        }
        
        // Execute
        return $this->db->execute();
    }
}