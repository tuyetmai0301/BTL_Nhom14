<?php
require_once MODEL_PATH.'/Enrollment.php';
require_once MODEL_PATH.'/Course.php';
class EnrollmentController {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // ---- Đăng ký khóa học ----
   public function register() 
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $courseId  = $_POST['course_id'] ?? null;
        $studentId = $_POST['user_id'] ?? null;

        if (!$courseId || !$studentId) {
            echo "<script>
                    alert('Thông tin đăng ký không hợp lệ!');
                    window.history.back();
                  </script>";
            exit;

        }

        $model = new Enrollment();
        $result = $model->registerCourse($courseId, $studentId);

        // Thành công → Hiển thị popup rồi chuyển trang
        if ($result) {
            echo "<script>
                    alert('Đăng ký khóa học thành công!');
                    window.location.href = '" . BASE_URL . "/enrollment/myCourses';
                </script>";
        } 
        else {
            echo "<script>
                    alert('Đăng ký thất bại. Vui lòng thử lại!');
                    window.history.back();
                  </script>";
        }
        exit; // Ngăn PHP chạy tiếp
        
    }
}


    // ---- Kiểm tra đã đăng ký chưa ----
    public function isEnrolled($studentId, $courseId) {
        $sql = "SELECT COUNT(*) FROM enrollments 
                WHERE student_id = ? AND course_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$studentId, $courseId]);
        return $stmt->fetchColumn() > 0;
    }

    // ---- Lấy khóa học đã đăng ký ----
    public function myCourses() {
        $studentId = $_SESSION['user']['id'];

        $enrollModel = new Enrollment();
        $myCourses = $enrollModel->getMyCourses($studentId);

        include VIEW_PATH."/student/my_courses.php";
    }

    // ---- Lấy tiến độ học ----
   public function getProgress($studentId)
{
    $sql = "SELECT 
                c.id AS course_id,
                c.title,
                e.progress
            FROM enrollments e
            JOIN courses c ON e.course_id = c.id
            WHERE e.student_id = ?";
    
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$studentId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    // ---- Cập nhật tiến độ (sau này dùng cho từng bài học) ----
    public function updateProgress($courseId, $studentId, $progress) {
        $sql = "UPDATE enrollments 
                SET progress = ? 
                WHERE course_id = ? AND student_id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$progress, $courseId, $studentId]);
    }
    // Lấy tiến trình các khóa học đã đăng kí của học viên
     public function progressList()
{
    $studentId = $_SESSION['user']['id'];

    $enrollModel = new Enrollment();

    // Lấy tất cả khóa học + tiến độ
    $myCourses = $enrollModel->getProgress($studentId);

    require VIEW_PATH."/student/course_progress.php";
}


    //Thêm action cho giảng viên xem tiến độ
    public function studentsProgress()
{
    // Chỉ giảng viên mới được xem
    if ($_SESSION['user']['role'] !== 1) {
        die("Bạn không có quyền truy cập!");
    }

    $courseId = $_GET['course_id'] ?? null;

    if (!$courseId) {
        die("Thiếu course_id");
    }

    $model = new Enrollment();
    $students = $model->getStudentsProgressByCourse($courseId);

    include VIEW_PATH . "/instructor/students/list.php";
}

    // AJAX cập nhật tiến độ, chỉ nhận request – xử lý – trả JSON – rồi kết thúc
    public function updateProgressAjax() {
    $data = json_decode(file_get_contents("php://input"), true);

    $lessonId  = $data['lesson_id'];
    $courseId  = $data['course_id'];
    $studentId = $_SESSION['user']['id'];

    // Tăng mỗi lần xem +10% (hoặc tùy bạn)
    $increase = 10;

    $model = new Enrollment();
    $current = $model->getProgressForUpdate($courseId, $studentId);

    $newProgress = min(100, $current + $increase);

    $model->updateProgress($courseId, $studentId, $newProgress);

    echo json_encode([
        "status" => "success",
        "progress" => $newProgress
    ]);

    exit;
}
/*public function updateProgressAjax()
là một API (controller action kiểu AJAX) dùng để:

Nhận dữ liệu do JavaScript gửi (lesson_id, course_id)

Tính tiến độ

Ghi vào database

Trả JSON về cho JS*/ 
}
?>