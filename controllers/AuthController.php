<?php

class AuthController {

    public function loginPage() {
        require_once VIEW_PATH . "/auth/login.php";
    }
    
    public function login() {
        require_once CONFIG_PATH . "/Database.php";
        require_once MODEL_PATH . "/User.php";

        $database = new Database();
        $db = $database->connect();
        $userModel = new User($db);

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $userModel->findByEmail($email);

        // Kiểm tra email có tồn tại không
        if (!$user) {
            $_SESSION['error'] = "Email không tồn tại!";
            header("Location: " . BASE_URL . "/auth/loginPage");
            exit;
        }

        //Kiểm tra tk bị khóa thì không cho đăng nhập
        if ((int)$user['role'] == -1) {
            $_SESSION['error'] = "Tài khoản của bạn đã bị khóa!";
            header("Location: " . BASE_URL . "/auth/loginPage");
            exit;
        }
        // Kiểm tra mật khẩu
        if ($password != $user['password']) {
            $_SESSION['error'] = "Sai mật khẩu!";
            header("Location: " . BASE_URL . "/auth/loginPage");
            exit;
        }

        // Lưu session đăng nhập
        $_SESSION['user'] = [
            "id" => $user['id'],
            "name" => $user['fullname'],
            "email" => $user['email'],
            "role" => (int)$user['role'] // 0=student, 1=teacher, 2=admin
        ];

        // Điều hướng theo vai trò
        switch ((int)$user['role']) {

            case 2:  
                header("Location: " . BASE_URL . "/admin/dashboard");
                break;

            case 1:  
                header("Location: " . BASE_URL . "/home/instructorDashboard");
                break;

            case 0:  
                header("Location: " . BASE_URL . "/home/studentDashboard");
                break;

            default:
                header("Location: " . BASE_URL);
                break;
        }
        exit;
    }

    public function registerPage() {
        require_once VIEW_PATH . "/auth/register.php";
    }

    public function register() {
        require_once CONFIG_PATH . "/Database.php";
        require_once MODEL_PATH . "/User.php";

        $database = new Database();
        $db = $database->connect();
        $userModel = new User($db);

        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $fullname = $_POST['fullname'];
        $role = intval($_POST['role']); // role dạng INT

        // kiểm tra email tồn tại chưa
        if ($userModel->findByEmail($email)) {
            $_SESSION['error'] = "Email đã tồn tại!";
            header("Location: " . BASE_URL . "/auth/registerPage");
            exit;
        }
        // Kiểm tra email tồn tại
        if ($userModel->findByEmail($email)) {
            $_SESSION['error'] = "Email đã tồn tại!";
            header("Location: " . BASE_URL . "/auth/registerPage");
            exit;
        }
        
        // Thêm user
        $success = $userModel->createUser($username, $email, $password, $fullname, $role);

        if ($success) {
            $_SESSION['message'] = "Đăng ký thành công! Hãy đăng nhập.";
            header("Location: " . BASE_URL . "/auth/loginPage");
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra!";
            header("Location: " . BASE_URL . "/auth/registerPage");
        }
        exit;
    }
    public function logout() {
        session_destroy();
        header("Location: " . BASE_URL);
        exit;
    }

}