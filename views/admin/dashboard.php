<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<!-- Sidebar -->
<?php require_once VIEW_PATH . '/layouts/sidebar.php'; ?>

<!-- Main Content -->
<div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard Admin</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?php echo BASE_URL; ?>/admin/reports" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-chart-bar"></i> Xem báo cáo
                </a>
            </div>
        </div>
    </div>

    <!-- Welcome Message -->
    <div class="alert alert-primary">
        <h4><i class="fas fa-user-shield"></i> Chào mừng, <?php echo htmlspecialchars($_SESSION['user']['name']); ?>!</h4>
        <p class="mb-0">Bạn đang ở trang quản trị hệ thống. Từ đây bạn có thể quản lý người dùng, danh mục và xem thống kê.</p>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Tổng người dùng</h6>
                            <h2 class="mb-0">0</h2>
                        </div>
                        <i class="fas fa-users fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Tổng khóa học</h6>
                            <h2 class="mb-0">0</h2>
                        </div>
                        <i class="fas fa-book fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
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
        <div class="col-md-3">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">TK bị khóa</h6>
                            <h2 class="mb-0">0</h2>
                        </div>
                        <i class="fas fa-lock fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-tasks"></i> Thao tác nhanh</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <a href="<?php echo BASE_URL; ?>/admin/manageUsers" class="card text-center text-decoration-none h-100">
                                <div class="card-body">
                                    <i class="fas fa-user-cog fa-3x text-primary mb-3"></i>
                                    <h6>Quản lý người dùng</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="<?php echo BASE_URL; ?>/admin/categories" class="card text-center text-decoration-none h-100">
                                <div class="card-body">
                                    <i class="fas fa-tags fa-3x text-success mb-3"></i>
                                    <h6>Quản lý danh mục</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="<?php echo BASE_URL; ?>/admin/reports" class="card text-center text-decoration-none h-100">
                                <div class="card-body">
                                    <i class="fas fa-chart-bar fa-3x text-warning mb-3"></i>
                                    <h6>Báo cáo & Thống kê</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="#" class="card text-center text-decoration-none h-100">
                                <div class="card-body">
                                    <i class="fas fa-cog fa-3x text-info mb-3"></i>
                                    <h6>Cài đặt hệ thống</h6>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <!-- System Info -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Thông tin hệ thống</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-server text-primary me-2"></i>
                            <strong>Phiên bản:</strong> 1.0.0
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-calendar text-primary me-2"></i>
                            <strong>Ngày cài đặt:</strong> <?php echo date('d/m/Y'); ?>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-database text-primary me-2"></i>
                            <strong>Database:</strong> MySQL
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-code text-primary me-2"></i>
                            <strong>PHP Version:</strong> <?php echo phpversion(); ?>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-history"></i> Hoạt động gần đây</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Chào mừng Admin</h6>
                                <small>Vừa xong</small>
                            </div>
                            <p class="mb-1">Bạn đã đăng nhập vào hệ thống quản trị</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>