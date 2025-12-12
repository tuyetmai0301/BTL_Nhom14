<?php

require_once CONFIG_PATH . '/Database.php';
require_once MODEL_PATH . '/Lesson.php';
require_once MODEL_PATH . '/Course.php';
require_once MODEL_PATH . '/Material.php';

class LessonController {
    private $lesson;
    private $course;
    private $material;

    public function __construct()
    {
        $db = (new Database())->connect();
        $this->lesson = new Lesson($db);
        $this->course = new Course($db);
        $this->material = new Material($db);
    }

    // -----------------DÀNH CHO HỌC VIÊN-----------
    public function courseMaterials()
{
    $courseId = $_GET['courseId'];
    $db = (new Database())->connect();

    $lessonModel = new Lesson($db);
    $materialModel = new Material($db);

    // 1️⃣ Lấy danh sách bài học của khóa
    $lessons = $lessonModel->getByCourse($courseId);

    // 2️⃣ Với mỗi bài → gắn thêm danh sách tài liệu vào mảng
    foreach ($lessons as $key => $lesson) {
        $materials = $materialModel->getByLesson($lesson['id']);
        $lessons[$key]['materials'] = $materials;   // thêm key mới
    }

    // 3️⃣ Truyền sang view
    require_once VIEW_PATH . "/student/course_materials.php";
}

    //------------------HẾT PHẦN HỌC VIÊN-----------
    // Quản lý bài học theo khóa học
    public function manage()
    {
        if (!isset($_SESSION['user']) || (int)$_SESSION['user']['role'] !== 1) {
            header("Location: " . BASE_URL . "/auth/loginPage");
            exit;
        }

        $course_id = $_GET['course_id'] ?? null;

        if (!$course_id) {
            echo "Course ID missing!";
            return;
        }

        // Kiểm tra quyền sở hữu khóa học
        $course = $this->course->get($course_id);
        if (!$course || $course['instructor_id'] != $_SESSION['user']['id']) {
            echo "Bạn không có quyền quản lý khóa học này!";
            return;
        }

        $lessons = $this->lesson->getByCourse($course_id);

        // Lấy materials cho từng lesson
        foreach ($lessons as &$lesson) {
            $lesson['materials'] = $this->material->getByLesson($lesson['id']);
        }
        unset($lesson); // QUAN TRỌNG: Hủy reference để tránh bug
        require_once VIEW_PATH . '/instructor/lessons/manage.php';
    }

    // Form tạo bài học
    public function create()
    {
        if (!isset($_SESSION['user']) || (int)$_SESSION['user']['role'] !== 1) {
            header("Location: " . BASE_URL . "/auth/loginPage");
            exit;
        }

        $course_id = $_GET['course_id'] ?? null;

        if (!$course_id) {
            echo "Course ID missing!";
            return;
        }

        // Kiểm tra quyền
        $course = $this->course->get($course_id);
        if (!$course || $course['instructor_id'] != $_SESSION['user']['id']) {
            echo "Bạn không có quyền thêm bài học cho khóa học này!";
            return;
        }

        require_once VIEW_PATH . '/instructor/lessons/create.php';
    }

    // Lưu bài học mới
    public function store()
    {
        if (!isset($_SESSION['user']) || (int)$_SESSION['user']['role'] !== 1) {
            header("Location: " . BASE_URL . "/auth/loginPage");
            exit;
        }

        $course_id = $_POST['course_id'] ?? null;
        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $video_url = trim($_POST['video_url'] ?? '');
        $order = intval($_POST['order'] ?? 1);

        // Validate input
        if (empty($title)) {
            $_SESSION['error'] = "Tiêu đề bài học không được để trống!";
            header("Location: " . BASE_URL . "/lesson/create?course_id=" . $course_id);
            exit;
        }

        if (empty($content)) {
            $_SESSION['error'] = "Nội dung bài học không được để trống!";
            header("Location: " . BASE_URL . "/lesson/create?course_id=" . $course_id);
            exit;
        }

        // Validate video URL (nếu có)
        if (!empty($video_url)) {
            if (!filter_var($video_url, FILTER_VALIDATE_URL)) {
                $_SESSION['error'] = "URL video không hợp lệ!";
                header("Location: " . BASE_URL . "/lesson/create?course_id=" . $course_id);
                exit;
            }
        }

        $data = [
            'course_id' => $course_id,
            'title' => $title,
            'content' => $content,
            'video_url' => $video_url,
            'order' => $order
        ];

        if ($this->lesson->create($data)) {
            $_SESSION['success'] = "Thêm bài học thành công!";
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra khi thêm bài học!";
        }

        header("Location: " . BASE_URL . "/lesson/manage?course_id=" . $course_id);
    }

    // Form sửa bài học
    public function edit()
    {
        if (!isset($_SESSION['user']) || (int)$_SESSION['user']['role'] !== 1) {
            header("Location: " . BASE_URL . "/auth/loginPage");
            exit;
        }

        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo "Lesson ID missing!";
            return;
        }

        $lesson = $this->lesson->get($id);

        if (!$lesson) {
            echo "Bài học không tồn tại!";
            return;
        }

        // Kiểm tra quyền
        $course = $this->course->get($lesson['course_id']);
        if (!$course || $course['instructor_id'] != $_SESSION['user']['id']) {
            echo "Bạn không có quyền chỉnh sửa bài học này!";
            return;
        }

        require_once VIEW_PATH . '/instructor/lessons/edit.php';
    }

    // Cập nhật bài học
    public function update()
    {
        if (!isset($_SESSION['user']) || (int)$_SESSION['user']['role'] !== 1) {
            header("Location: " . BASE_URL . "/auth/loginPage");
            exit;
        }

        $id = $_POST['id'] ?? null;
        $course_id = $_POST['course_id'] ?? null;
        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $video_url = trim($_POST['video_url'] ?? '');
        $order = intval($_POST['order'] ?? 1);

        // Validate input
        if (empty($title)) {
            $_SESSION['error'] = "Tiêu đề bài học không được để trống!";
            header("Location: " . BASE_URL . "/lesson/edit?id=" . $id);
            exit;
        }

        if (empty($content)) {
            $_SESSION['error'] = "Nội dung bài học không được để trống!";
            header("Location: " . BASE_URL . "/lesson/edit?id=" . $id);
            exit;
        }

        // Validate video URL (nếu có)
        if (!empty($video_url)) {
            if (!filter_var($video_url, FILTER_VALIDATE_URL)) {
                $_SESSION['error'] = "URL video không hợp lệ!";
                header("Location: " . BASE_URL . "/lesson/edit?id=" . $id);
                exit;
            }
        }

        $data = [
            'id' => $id,
            'title' => $title,
            'content' => $content,
            'video_url' => $video_url,
            'order' => $order
        ];

        if ($this->lesson->update($data)) {
            $_SESSION['success'] = "Cập nhật bài học thành công!";
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra khi cập nhật bài học!";
        }

        header("Location: " . BASE_URL . "/lesson/manage?course_id=" . $course_id);
    }

    // Xóa bài học
    public function delete()
    {
        if (!isset($_SESSION['user']) || (int)$_SESSION['user']['role'] !== 1) {
            header("Location: " . BASE_URL . "/auth/loginPage");
            exit;
        }

        $id = $_GET['id'] ?? null;
        $course_id = $_GET['course_id'] ?? null;

        if (!$id || !$course_id) {
            echo "Thiếu thông tin!";
            return;
        }

        // Kiểm tra quyền
        $lesson = $this->lesson->get($id);
        if ($lesson) {
            $course = $this->course->get($lesson['course_id']);
            if ($course && $course['instructor_id'] == $_SESSION['user']['id']) {
                if ($this->lesson->delete($id)) {
                    $_SESSION['success'] = "Xóa bài học thành công!";
                } else {
                    $_SESSION['error'] = "Có lỗi xảy ra khi xóa bài học!";
                }
            }
        }

        header("Location: " . BASE_URL . "/lesson/manage?course_id=" . $course_id);
    }
}