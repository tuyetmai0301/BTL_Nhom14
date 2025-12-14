<?php
require_once MODEL_PATH . '/Category.php';
require_once CONFIG_PATH . '/Database.php';
class AdminController {

    // Trang dashboard admin
    public function dashboard() {
        if (!isset($_SESSION['user']) || (int)$_SESSION['user']['role'] !== 2) {
            header("Location: " . BASE_URL);
            exit;
        }

        require_once VIEW_PATH . '/admin/dashboard.php';
    }

    // Quản lý người dùng
    public function manageUsers() {
        if (!isset($_SESSION['user']) || (int)$_SESSION['user']['role'] !== 2) {
            header("Location: " . BASE_URL);
            exit;
        }

        require_once CONFIG_PATH . "/Database.php";
        require_once MODEL_PATH . "/User.php";

        $db = (new Database())->connect();
        $userModel = new User($db);

        $users = $userModel->getAllUsers();

        require_once VIEW_PATH . "/admin/users/manage.php";
    }
    // KHÓA / MỞ KHÓA TÀI KHOẢN
    // =============================
    public function updateUser() {
        if (!isset($_SESSION['user']) || (int)$_SESSION['user']['role'] !== 2) {
            header("Location: " . BASE_URL);
            exit;
        }

        if (!isset($_POST['id']) || !isset($_POST['action'])) {
            die("Thiếu dữ liệu gửi lên");
        }

        $id = $_POST['id'];
        $action = $_POST['action'];

        require_once CONFIG_PATH . "/Database.php";
        require_once MODEL_PATH . "/User.php";

        $db = (new Database())->connect();
        $userModel = new User($db);

        if ($action === "lock") {
            // Khóa tài khoản → role = -1
            $userModel->updateRole($id, -1);
        } elseif ($action === "unlock") {
            // Mở khóa → role mặc định = 0
            $userModel->updateRole($id, 0);
        }

        header("Location: " . BASE_URL . "/admin/manageUsers");
        exit;
    }

    // ------------CODE CHO ADMIN-----------

    // ===================== Danh mục =====================
    public function categories() {
        $db = (new Database())->connect();
        $categoryModel = new Category($db);
        $categories = $categoryModel->readAll();
        require_once VIEW_PATH . '/admin/categories/list.php';
    }

    // THÊM DANH MỤC
    public function categoryCreate() {
    // Kiểm tra quyền admin
    if (!isset($_SESSION['user']) || (int)$_SESSION['user']['role'] !== 2) {
        header("Location: " . BASE_URL);
        exit;
    }

    $error = '';

    // Nếu form được submit
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';

        if (!empty($name)) {
            // Khởi tạo model với Database
            $db = (new Database())->connect();
            $categoryModel = new Category($db);

            $success = $categoryModel->create($name, $description);

            if ($success) {
                // Chuyển hướng về danh sách categories
                header("Location: " . BASE_URL . "/admin/categories/list.php");
                exit;
            } else {
                $error = "Thêm danh mục thất bại!";
            }
        } else {
            $error = "Tên danh mục không được để trống!";
        }
    }

    // Hiện form thêm danh mục (GET hoặc sau khi POST thất bại)
    require_once VIEW_PATH . '/admin/categories/create.php';
}

    // QUẢN LÝ DANH MỤC

    // SỬA DANH MỤC
    // Form sửa danh mục
    public function categoryEdit() {
        $id = $_GET['id'];
        $db = (new Database())->connect();
        $categoryModel = new Category($db);
        $category = $categoryModel->find($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];

            $categoryModel->update($id, $name, $description);
            header("Location: " . BASE_URL . "/admin/categories");
            exit;
        }

        require_once VIEW_PATH . '/admin/categories/edit.php';
    }

    // Xóa danh mục
    public function categoryDelete() {
        $id = $_GET['id'];
        $db = (new Database())->connect();
        $categoryModel = new Category($db);
        $categoryModel->delete($id);
        header("Location: " . BASE_URL . "/admin/categories");
        exit;
    }

// ===================== Thống kê =====================
    public function statistics() {

    $db = (new Database())->connect();

    // Tổng người dùng
    $totalUsers = $db->query("SELECT COUNT(*)  FROM users")->fetchColumn();

    // Tổng khóa học
    $totalCourses = $db->query("SELECT COUNT(*) FROM courses")->fetchColumn();

    // Học viên đang học (giả sử enrollments table với status = 1 là đang học)
    $activeEnrollments = $db->query("SELECT COUNT(*) FROM enrollments WHERE status = 'active'")->fetchColumn();

    // Thống kê khóa học theo danh mục
    $stmt = $db->query("
        SELECT c.name as category_name, COUNT(co.id) as total_courses
        FROM categories c
        LEFT JOIN courses co ON co.category_id = c.id
        GROUP BY c.name
    ");
    $courseByCategory = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Gọi view
    require_once VIEW_PATH . '/admin/reports/statistics.php';
}

    public function reports() {
        $this->statistics();
}
}