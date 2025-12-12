<?php 
class User {
    private $conn;
    private $table = "users";
    public $id;
    public $username;
    public $email;
    public $password;
    public $fullname;
    public $role;
    public $created_at;
    public function __construct($db) {
        $this->conn = $db;
    }
    // Lấy user theo email
    public function findByEmail($email) {
        $query = "SELECT * FROM " . $this->table . " WHERE email = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Tạo tài khoản mới
   public function createUser($username, $email, $password, $fullname, $role) {
    $query = "INSERT INTO " . $this->table . " (username, email, password, fullname, role)
              VALUES (:username, :email, :password, :fullname, :role)";

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password", $password); // Không hash
    $stmt->bindParam(":fullname", $fullname);
    $stmt->bindParam(":role", $role);

    return $stmt->execute();
    }
    // Lấy tất cả user
    public function getAllUsers() {
        $query = "SELECT id, username, email, fullname, role, created_at 
                  FROM " . $this->table . " 
                  ORDER BY id DESC";
       $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tìm user theo ID (nếu admin cần xem chi tiết)
    public function findById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Khóa / mở khóa
    public function updateRole($id, $role) {
        $query = "UPDATE " . $this->table . " SET role = :role WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Kiểm tra tài khoản có bị khóa không
    public function isLocked($id) {
        $query = "SELECT role FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($row['role'] == -1);
    }
}