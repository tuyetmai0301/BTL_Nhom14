<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<!-- Sidebar -->
<?php require_once VIEW_PATH . '/layouts/sidebar.php'; ?>

<!-- Main Content -->
<div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Quản lý khóa học</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?php echo BASE_URL; ?>/course/create" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tạo khóa học mới
            </a>
        </div>
    </div>

    <!-- Courses List -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-list"></i> Tất cả khóa học của bạn</h5>
        </div>
        <div class="card-body">
            <?php if (!empty($courses)): ?>
                <div class="row">
                    <?php foreach ($courses as $course): ?>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="row g-0">
                                    <!-- Image Column -->
                                    <div class="col-md-4">
                                        <?php if (!empty($course['image'])): ?>
                                            <img src="<?php echo BASE_URL; ?>/assets/uploads/courses/<?php echo $course['image']; ?>" 
                                                 class="img-fluid rounded-start h-100 w-100" 
                                                 style="object-fit: cover; min-height: 200px;"
                                                 alt="<?php echo htmlspecialchars($course['title']); ?>">
                                        <?php else: ?>
                                            <div class="bg-secondary h-100 d-flex align-items-center justify-content-center">
                                                <i class="fas fa-book fa-3x text-white"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <!-- Content Column -->
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo htmlspecialchars($course['title']); ?></h5>
                                            <p class="card-text">
                                                <small class="text-muted">
                                                    <?php echo strlen($course['description']) > 100 ? 
                                                        substr($course['description'], 0, 100) . '...' : 
                                                        $course['description']; ?>
                                                </small>
                                            </p>
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="badge bg-primary"><?php echo htmlspecialchars($course['level']); ?></span>
                                                <span class="text-success fw-bold">$<?php echo number_format($course['price'], 2); ?></span>
                                            </div>
                                            <div class="btn-group btn-group-sm w-100">
                                                <a href="<?php echo BASE_URL; ?>/lesson/manage?course_id=<?php echo $course['id']; ?>" 
                                                   class="btn btn-outline-primary">
                                                    <i class="fas fa-book-open"></i> Bài học
                                                </a>
                                                <a href="<?php echo BASE_URL; ?>/enrollment/studentsProgress?course_id=<?php echo $course['id']; ?>" 
                                                   class="btn btn-outline-success">
                                                    <i class="fas fa-users"></i> Học viên
                                                </a>
                                                <a href="<?php echo BASE_URL; ?>/course/edit?id=<?php echo $course['id']; ?>" 
                                                   class="btn btn-outline-warning">
                                                    <i class="fas fa-edit"></i> Sửa
                                                </a>
                                                <a href="<?php echo BASE_URL; ?>/course/delete?id=<?php echo $course['id']; ?>" 
                                                   class="btn btn-outline-danger"
                                                   onclick="return confirm('Bạn có chắc chắn muốn xóa khóa học này?');">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-book fa-4x text-muted mb-4"></i>
                    <h3>Bạn chưa có khóa học nào</h3>
                    <p class="text-muted">Hãy tạo khóa học đầu tiên để bắt đầu!</p>
                    <a href="<?php echo BASE_URL; ?>/course/create" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tạo khóa học
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>