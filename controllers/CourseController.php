<?php

require_once CONFIG_PATH . '/Database.php';
require_once MODEL_PATH . '/Course.php';
require_once MODEL_PATH . '/Enrollment.php';
require_once MODEL_PATH . '/Category.php';

class CourseController {
    private $course;

    public function __construct()
    {
        $db = (new Database())->connect();
        $this->course = new Course($db);
    }

// -------CODE CHO HỌC VIÊN--------------
    public function search()
{
    $db = (new Database())->connect();

    // Model
    $courseObj = new Course($db);
    $categoryObj = new Category($db);

    // Lấy danh mục
    $categories = $categoryObj->readAll();

    // Lấy input GET (vì ta dùng form method="get")
    $keyword    = $_GET['q'] ?? '';
    $categoryId = $_GET['category'] ?? '';

    // Trường hợp 1: Chỉ tìm kiếm theo title
    // -------------------------------------------------------
    if (!empty($keyword) && empty($categoryId)) {
        $courses = $courseObj->searchByTitle($keyword);
    }
    // Trường hợp 2: Lọc theo danh mục
    // -------------------------------------------------------
    elseif (!empty($categoryId) && empty($keyword)) {
        $courses = $courseObj->getByCategory($categoryId);
    }
    // Trường hợp 3: Có cả keyword + category
    // -------------------------------------------------------
    elseif (!empty($keyword) && !empty($categoryId)) {
        $courses = $courseObj->searchByTitleAndCategory($keyword, $categoryId);
    }
    // Trường hợp 4: Không có search → lấy tất cả
    // -------------------------------------------------------
    else {
        $courses = $courseObj->getAll();
    }
    // Truyền lại dữ liệu cho View để giữ giá trị đã chọn
    $filters = [
        'q' => $keyword,
        'category_id' => $categoryId
    ];
    include VIEW_PATH . '/courses/search.php';
}


    // Danh sách khóa học chung
    public function index()
    {
        $courses = $this->course->getAll();
        // [lấy tất cả danh mục cho học viên]
        $db = (new Database())->connect();
        $categoryModel = new Category($db);
        $categories = $categoryModel->readAll();
        require_once VIEW_PATH . '/courses/index.php';
    }

    // Chi tiết khóa học
    public function detail()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo "Course ID missing!";
            return;
        }

        $course = $this->course->get($id);
        // Kiểm tra học viên đã đăng ký chưa 
        $enrollmentModel = new Enrollment();
        $isEnrolled = false;
        if (isset($_SESSION['user']) && isset($_SESSION['user']['id'])) {
            $isEnrolled = $enrollmentModel->isEnrolled($_SESSION['user']['id'], $id);
        }

        require_once VIEW_PATH . '/courses/detail.php';
    }
//--------------HẾT PHẦN HỌC VIÊN-----------

    // Dashboard giảng viên
    public function dashboard()
    {
        if (!isset($_SESSION['user']) || (int)$_SESSION['user']['role'] !== 1) {
            header("Location: " . BASE_URL);
            exit;
        }

        $instructorId = $_SESSION['user']['id'];
        $courses = $this->course->getByInstructor($instructorId);
        
        // Debug
        error_log("Dashboard - Instructor ID: " . $instructorId);
        error_log("Dashboard - Courses count: " . count($courses));
        error_log("Dashboard - Courses: " . print_r($courses, true));

        require_once VIEW_PATH . '/instructor/dashboard.php';
    }

    // Danh sách khóa học của giảng viên
    public function my_courses()
    {
        if (!isset($_SESSION['user']) || (int)$_SESSION['user']['role'] !== 1) {
            header("Location: " . BASE_URL);
            exit;
        }

        $instructorId = $_SESSION['user']['id'];
        $courses = $this->course->getByInstructor($instructorId);

        require_once VIEW_PATH . '/instructor/my_courses.php';
    }

    // Giảng viên – Danh sách khóa học
    public function manage()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: " . BASE_URL . "/auth/loginPage");
            exit;
        }

        $instructorId = $_SESSION['user']['id'];

        $courses = $this->course->getByInstructor($instructorId);

        require_once VIEW_PATH . '/instructor/course/manage.php';
    }

    // Form tạo khóa học
    public function create()
    {
        if (!isset($_SESSION['user']) || (int)$_SESSION['user']['role'] !== 1) {
            header("Location: " . BASE_URL . "/auth/loginPage");
            exit;
        }

        // Lấy danh sách categories để hiển thị trong form
        require_once MODEL_PATH . '/Category.php';
        $db = (new Database())->connect();
        $categoryModel = new Category($db);
        $categories = $categoryModel->readAll(); // readAll() đã trả về array rồi

        require_once VIEW_PATH . '/instructor/course/create.php';
    }

    // Submit tạo khóa học
    public function store()
    {
        if (!isset($_SESSION['user']) || (int)$_SESSION['user']['role'] !== 1) {
            header("Location: " . BASE_URL . "/auth/loginPage");
            exit;
        }

        // Validate input
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $category_id = intval($_POST['category_id'] ?? 0);
        $price = floatval($_POST['price'] ?? 0);
        $duration_weeks = intval($_POST['duration_weeks'] ?? 0);
        $level = trim($_POST['level'] ?? '');

        // Kiểm tra các trường bắt buộc
        if (empty($title)) {
            $_SESSION['error'] = "Tiêu đề khóa học không được để trống!";
            header("Location: " . BASE_URL . "/course/create");
            exit;
        }

        if (empty($description)) {
            $_SESSION['error'] = "Mô tả khóa học không được để trống!";
            header("Location: " . BASE_URL . "/course/create");
            exit;
        }

        if ($category_id <= 0) {
            $_SESSION['error'] = "Vui lòng chọn danh mục!";
            header("Location: " . BASE_URL . "/course/create");
            exit;
        }

        if ($price < 0) {
            $_SESSION['error'] = "Giá khóa học không hợp lệ!";
            header("Location: " . BASE_URL . "/course/create");
            exit;
        }

        if ($duration_weeks <= 0) {
            $_SESSION['error'] = "Thời lượng khóa học phải lớn hơn 0!";
            header("Location: " . BASE_URL . "/course/create");
            exit;
        }

        $allowed_levels = ['Beginner', 'Intermediate', 'Advanced'];
        if (!in_array($level, $allowed_levels)) {
            $_SESSION['error'] = "Cấp độ khóa học không hợp lệ!";
            header("Location: " . BASE_URL . "/course/create");
            exit;
        }

        $data = [
            "title" => $title,
            "description" => $description,
            "instructor_id" => $_SESSION['user']['id'],
            "category_id" => $category_id,
            "price" => $price,
            "duration_weeks" => $duration_weeks,
            "level" => $level,
            "image" => ""
        ];

        // Upload file ảnh
        if (!empty($_FILES['image']['name'])) {
            $allowed_image_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $image_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

            if (!in_array($image_ext, $allowed_image_types)) {
                $_SESSION['error'] = "File ảnh không hợp lệ! Chỉ chấp nhận: " . implode(', ', $allowed_image_types);
                header("Location: " . BASE_URL . "/course/create");
                exit;
            }

            // Validate file size (max 5MB)
            $max_size = 5 * 1024 * 1024;
            if ($_FILES['image']['size'] > $max_size) {
                $_SESSION['error'] = "File ảnh quá lớn! Kích thước tối đa là 5MB.";
                header("Location: " . BASE_URL . "/course/create");
                exit;
            }

            $fileName = time() . "_" . basename($_FILES["image"]["name"]);
            $upload_dir = ROOT_PATH . "/assets/uploads/courses/";
            
            // Tạo thư mục nếu chưa có
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $target = $upload_dir . $fileName;

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target)) {
                $data["image"] = $fileName;
            } else {
                $_SESSION['error'] = "Có lỗi khi upload ảnh!";
                header("Location: " . BASE_URL . "/course/create");
                exit;
            }
        }

        if ($this->course->create($data)) {
            $_SESSION['success'] = "Tạo khóa học thành công!";
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra khi tạo khóa học!";
        }

        header("Location: " . BASE_URL . "/course/my_courses");
    }

    // Form sửa khóa học
    public function edit()
    {
        if (!isset($_SESSION['user']) || (int)$_SESSION['user']['role'] !== 1) {
            header("Location: " . BASE_URL . "/auth/loginPage");
            exit;
        }

        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo "Course ID missing!";
            return;
        }

        $course = $this->course->get($id);

        if (!$course) {
            echo "Khóa học không tồn tại!";
            return;
        }

        // Kiểm tra quyền sở hữu
        if ($course['instructor_id'] != $_SESSION['user']['id']) {
            echo "Bạn không có quyền chỉnh sửa khóa học này!";
            return;
        }

        // Lấy danh sách categories
        require_once MODEL_PATH . '/Category.php';
        $db = (new Database())->connect();
        $categoryModel = new Category($db);
        $categories = $categoryModel->readAll(); // readAll() đã trả về array rồi

        require_once VIEW_PATH . '/instructor/course/edit.php';
    }

    // Submit cập nhật
    public function update()
    {
        if (!isset($_SESSION['user']) || (int)$_SESSION['user']['role'] !== 1) {
            header("Location: " . BASE_URL . "/auth/loginPage");
            exit;
        }

        $id = intval($_POST['id'] ?? 0);

        if ($id <= 0) {
            $_SESSION['error'] = "ID khóa học không hợp lệ!";
            header("Location: " . BASE_URL . "/course/my_courses");
            exit;
        }

        $course = $this->course->get($id);

        if (!$course) {
            $_SESSION['error'] = "Khóa học không tồn tại!";
            header("Location: " . BASE_URL . "/course/my_courses");
            exit;
        }

        // Kiểm tra quyền
        if ($course['instructor_id'] != $_SESSION['user']['id']) {
            $_SESSION['error'] = "Bạn không có quyền chỉnh sửa khóa học này!";
            header("Location: " . BASE_URL . "/course/my_courses");
            exit;
        }

        // Validate input
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $category_id = intval($_POST['category_id'] ?? 0);
        $price = floatval($_POST['price'] ?? 0);
        $duration_weeks = intval($_POST['duration_weeks'] ?? 0);
        $level = trim($_POST['level'] ?? '');

        if (empty($title)) {
            $_SESSION['error'] = "Tiêu đề khóa học không được để trống!";
            header("Location: " . BASE_URL . "/course/edit?id=" . $id);
            exit;
        }

        if (empty($description)) {
            $_SESSION['error'] = "Mô tả khóa học không được để trống!";
            header("Location: " . BASE_URL . "/course/edit?id=" . $id);
            exit;
        }

        if ($category_id <= 0) {
            $_SESSION['error'] = "Vui lòng chọn danh mục!";
            header("Location: " . BASE_URL . "/course/edit?id=" . $id);
            exit;
        }

        if ($price < 0) {
            $_SESSION['error'] = "Giá khóa học không hợp lệ!";
            header("Location: " . BASE_URL . "/course/edit?id=" . $id);
            exit;
        }

        if ($duration_weeks <= 0) {
            $_SESSION['error'] = "Thời lượng khóa học phải lớn hơn 0!";
            header("Location: " . BASE_URL . "/course/edit?id=" . $id);
            exit;
        }

        $allowed_levels = ['Beginner', 'Intermediate', 'Advanced'];
        if (!in_array($level, $allowed_levels)) {
            $_SESSION['error'] = "Cấp độ khóa học không hợp lệ!";
            header("Location: " . BASE_URL . "/course/edit?id=" . $id);
            exit;
        }

        $data = [
            "id" => $id,
            "title" => $title,
            "description" => $description,
            "category_id" => $category_id,
            "price" => $price,
            "duration_weeks" => $duration_weeks,
            "level" => $level,
            "image" => $course['image']
        ];

        // Nếu có upload ảnh mới
        if (!empty($_FILES["image"]["name"])) {
            $allowed_image_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $image_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

            if (!in_array($image_ext, $allowed_image_types)) {
                $_SESSION['error'] = "File ảnh không hợp lệ! Chỉ chấp nhận: " . implode(', ', $allowed_image_types);
                header("Location: " . BASE_URL . "/course/edit?id=" . $id);
                exit;
            }

            // Validate file size
            $max_size = 5 * 1024 * 1024;
            if ($_FILES['image']['size'] > $max_size) {
                $_SESSION['error'] = "File ảnh quá lớn! Kích thước tối đa là 5MB.";
                header("Location: " . BASE_URL . "/course/edit?id=" . $id);
                exit;
            }

            $fileName = time() . "_" . basename($_FILES["image"]["name"]);
            $upload_dir = ROOT_PATH . "/assets/uploads/courses/";
            
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $target = $upload_dir . $fileName;

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target)) {
                // Xóa ảnh cũ nếu có
                if (!empty($course['image'])) {
                    $old_image = $upload_dir . $course['image'];
                    if (file_exists($old_image)) {
                        unlink($old_image);
                    }
                }
                $data["image"] = $fileName;
            }
        }

        if ($this->course->update($data)) {
            $_SESSION['success'] = "Cập nhật khóa học thành công!";
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra khi cập nhật khóa học!";
        }

        header("Location: " . BASE_URL . "/course/my_courses");
    }

    // Xóa khóa học
    public function delete()
    {
        if (!isset($_SESSION['user']) || (int)$_SESSION['user']['role'] !== 1) {
            header("Location: " . BASE_URL . "/auth/loginPage");
            exit;
        }

        $id = $_GET['id'] ?? null;

        if (!$id) {
            $_SESSION['error'] = "ID khóa học không hợp lệ!";
            header("Location: " . BASE_URL . "/course/my_courses");
            exit;
        }

        $course = $this->course->get($id);

        if (!$course) {
            $_SESSION['error'] = "Khóa học không tồn tại!";
            header("Location: " . BASE_URL . "/course/my_courses");
            exit;
        }

        // Kiểm tra quyền
        if ($course['instructor_id'] != $_SESSION['user']['id']) {
            $_SESSION['error'] = "Bạn không có quyền xóa khóa học này!";
            header("Location: " . BASE_URL . "/course/my_courses");
            exit;
        }

        // Xóa ảnh khóa học nếu có
        if (!empty($course['image'])) {
            $image_path = ROOT_PATH . "/assets/uploads/courses/" . $course['image'];
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }

        if ($this->course->delete($id)) {
            $_SESSION['success'] = "Xóa khóa học thành công!";
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra khi xóa khóa học!";
        }

        header("Location: " . BASE_URL . "/course/my_courses");
    }
}