<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<!-- Sidebar -->
<?php require_once VIEW_PATH . '/layouts/sidebar.php'; ?>

<!-- Main Content -->
<div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Danh sách khóa học của tôi</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?php echo BASE_URL; ?>/course/create" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tạo khóa học mới
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Courses Table -->
    <div class="card">
        <div class="card-body">
            <?php if (!empty($courses)): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Hình ảnh</th>
                                <th>Tên khóa học</th>
                                <th>Danh mục</th>
                                <th>Cấp độ</th>
                                <th>Giá</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($courses as $course): ?>
                                <tr>
                                    <td><?php echo $course['id']; ?></td>
                                    <td>
                                        <?php if (!empty($course['image'])): ?>
                                            <img src="<?php echo BASE_URL; ?>/assets/uploads/courses/<?php echo $course['image']; ?>" 
                                                 alt="<?php echo htmlspecialchars($course['title']); ?>" 
                                                 style="width: 60px; height: 40px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center" 
                                                 style="width: 60px; height: 40px;">
                                                <i class="fas fa-book"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($course['title']); ?></strong><br>
                                        <small class="text-muted">
                                            <?php echo strlen($course['description']) > 50 ? 
                                                substr($course['description'], 0, 50) . '...' : 
                                                $course['description']; ?>
                                        </small>
                                    </td>
                                    <td>
                                        <?php 
                                        // You would typically get category name from database
                                        echo "Danh mục #" . $course['category_id']; 
                                        ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary"><?php echo htmlspecialchars($course['level']); ?></span>
                                    </td>
                                    <td>
                                        <span class="text-success fw-bold">$<?php echo number_format($course['price'], 2); ?></span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">Đang hoạt động</span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?php echo BASE_URL; ?>/course/edit?id=<?php echo $course['id']; ?>" 
                                               class="btn btn-outline-primary" title="Sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?php echo BASE_URL; ?>/lesson/manage?course_id=<?php echo $course['id']; ?>" 
                                               class="btn btn-outline-success" title="Bài học">
                                                <i class="fas fa-book-open"></i>
                                            </a>
                                            <a href="<?php echo BASE_URL; ?>/enrollment/studentsProgress?course_id=<?php echo $course['id']; ?>" 
                                               class="btn btn-outline-info" title="Học viên">
                                                <i class="fas fa-users"></i>
                                            </a>
                                            <a href="<?php echo BASE_URL; ?>/course/delete?id=<?php echo $course['id']; ?>" 
                                               class="btn btn-outline-danger" 
                                               onclick="return confirm('Bạn có chắc chắn muốn xóa khóa học này?');" 
                                               title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-book fa-4x text-muted mb-4"></i>
                    <h3>Bạn chưa có khóa học nào</h3>
                    <p class="text-muted mb-4">Hãy tạo khóa học đầu tiên của bạn và bắt đầu giảng dạy!</p>
                    <a href="<?php echo BASE_URL; ?>/course/create" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus"></i> Tạo khóa học đầu tiên
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>