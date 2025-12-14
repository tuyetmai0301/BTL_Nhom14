<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<!-- Sidebar -->
<?php require_once VIEW_PATH . '/layouts/sidebar.php'; ?>

<!-- Main Content -->
<div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard Giảng viên</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?php echo BASE_URL; ?>/course/create" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Tạo khóa học mới
                </a>
            </div>
        </div>
    </div>

    <!-- Welcome Message -->
    <div class="alert alert-primary">
        <h4><i class="fas fa-chalkboard-teacher"></i> Chào mừng, <?php echo htmlspecialchars($_SESSION['user']['name']); ?>!</h4>
        <p class="mb-0">Đây là trang quản lý dành cho giảng viên. Bạn có thể tạo và quản lý khóa học, bài giảng, và theo dõi học viên.</p>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Tổng khóa học</h6>
                            <h2 class="mb-0"><?php echo count($courses); ?></h2>
                        </div>
                        <i class="fas fa-book fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Tổng học viên</h6>
                            <h2 class="mb-0">0</h2>
                        </div>
                        <i class="fas fa-users fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Bài giảng</h6>
                            <h2 class="mb-0">0</h2>
                        </div>
                        <i class="fas fa-video fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Doanh thu</h6>
                            <h2 class="mb-0">$0</h2>
                        </div>
                        <i class="fas fa-dollar-sign fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Courses -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-book"></i> Khóa học gần đây</h5>
                    <a href="<?php echo BASE_URL; ?>/course/my_courses" class="btn btn-sm btn-primary">Xem tất cả</a>
                </div>
                <div class="card-body">
                    <?php if (!empty($courses)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Khóa học</th>
                                        <th>Trạng thái</th>
                                        <th>Học viên</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach (array_slice($courses, 0, 5) as $course): ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo htmlspecialchars($course['title']); ?></strong>
                                                <br>
                                                <small class="text-muted">
                                                    <?php echo strlen($course['description']) > 50 ? 
                                                        substr($course['description'], 0, 50) . '...' : 
                                                        $course['description']; ?>
                                                </small>
                                            </td>
                                            <td>
                                                <span class="badge bg-success">Đang hoạt động</span>
                                            </td>
                                            <td>0</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="<?php echo BASE_URL; ?>/lesson/manage?course_id=<?php echo $course['id']; ?>" 
                                                       class="btn btn-outline-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="<?php echo BASE_URL; ?>/enrollment/studentsProgress?course_id=<?php echo $course['id']; ?>" 
                                                       class="btn btn-outline-success">
                                                        <i class="fas fa-users"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-book fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Bạn chưa có khóa học nào</p>
                            <a href="<?php echo BASE_URL; ?>/course/create" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tạo khóa học đầu tiên
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Quick Actions -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-bolt"></i> Thao tác nhanh</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?php echo BASE_URL; ?>/course/create" class="btn btn-primary">
                            <i class="fas fa-plus-circle"></i> Tạo khóa học mới
                        </a>
                        <a href="<?php echo BASE_URL; ?>/course/my_courses" class="btn btn-outline-primary">
                            <i class="fas fa-list"></i> Quản lý khóa học
                        </a>
                        <a href="#" class="btn btn-outline-success">
                            <i class="fas fa-chart-line"></i> Xem báo cáo
                        </a>
                    </div>
                </div>
            </div>

            <!-- Notifications -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-bell"></i> Thông báo</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Chào mừng đến với hệ thống!
                    </div>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> Tài khoản đã được kích hoạt
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>