<?php

require_once MODEL_PATH . '/Course.php';   // Chỉ gọi Model

class HomeController {
    private $course;

    public function __construct()
    {
        // Database đã được nạp trong index.php
        $database = new Database();
        $db = $database->connect();

        $this->course = new Course($db);
    }

    public function index()
    {
        $courses = $this->course->getAll();
        require_once VIEW_PATH . '/home/index.php';
    }

    public function studentDashboard()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 0) {
            die("Bạn không có quyền truy cập");
        }

        require_once VIEW_PATH . "/student/dashboard.php";
    }

    public function instructorDashboard()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 1) {
            die("Bạn không có quyền truy cập");
        }

        // Lấy ID giảng viên từ session
        $instructorId = $_SESSION['user']['id'] ?? 0;
    
    // Tạm thời lấy tất cả khóa học hoặc tạo mảng rỗng
    // (Sau này thay bằng method lấy theo instructor)
        $courses = $this->course->getAll() ?? [];
    
    // Hoặc tạo mảng rỗng nếu chưa có dữ liệu
    // $courses = [];

        require_once VIEW_PATH . "/instructor/dashboard.php";
    }
}
