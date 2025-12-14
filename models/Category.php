<?php
// models/Category.php

class Category {
    private $conn;
    private $table_name = "categories";
    
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Lấy tất cả danh mục
     * @return PDOStatement|bool
     */
    public function readAll() {
        // if ($this->conn === null) return false;

        // $query = "SELECT id, name, description FROM " . $this->table_name . " ORDER BY name ASC";

        // $stmt = $this->conn->prepare($query);
        // $stmt->execute();

        // return $stmt;
        $sql = "SELECT * FROM {$this->table_name}";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $sql = "SELECT * FROM {$this->table_name} WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name, $description) {
        $sql = "INSERT INTO {$this->table_name} (name, description)
                VALUES(?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$name, $description]);
    }

    public function update($id, $name, $description) {
        $sql = "UPDATE {$this->table_name} SET name=?, description=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$name, $description, $id]);
    }

    public function delete($id) {
        $sql = "DELETE FROM {$this->table_name} WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}