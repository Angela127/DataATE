<?php

class Model
{
    protected $db;

    public function __construct()
    {
        // Get the singleton database instance
        $database = Database::getInstance();
        $this->db = $database->getConnection();
    }

    // Execute query and return all results
    protected function query($sql, $params = [])
    {
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Query error: " . $e->getMessage());
            die("Query failed: " . $e->getMessage());
        }
    }

    // Fetch single result
    protected function querySingle($sql, $params = [])
    {
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Query error: " . $e->getMessage());
            die("Query failed: " . $e->getMessage());
        }
    }

    // Execute query without returning results (for INSERT, UPDATE, DELETE)
    protected function execute($sql, $params = [])
    {
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("Execute error: " . $e->getMessage());
            return false;
        }
    }

    // Get last insert ID
    protected function lastInsertId()
    {
        return $this->db->lastInsertId();
    }
}