<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<!-- Sidebar -->
<?php require_once VIEW_PATH . '/layouts/sidebar.php'; ?>

<!-- Main Content -->
<div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard Học viên</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="<?php echo BASE_URL; ?>/course" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-search"></i> Tìm khóa học mới
                </a>
            </div>
        </div>
    </div>

    <!-- Welcome Message -->
    <div class="alert alert-primary">
        <h4><i class="fas fa-user-graduate"></i> Chào mừng, <?php echo htmlspecialchars($_SESSION['user']['name']); ?>!</h4>
        <p class="mb-0">Đây là trang tổng quan của bạn. Bạn có thể theo dõi tiến độ học tập và quản lý các khóa học đã đăng ký.</p>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Khóa học đã đăng ký</h6>
                            <h2 class="mb-0">0</h2>
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
                            <h6 class="card-title">Khóa học đang học</h6>
                            <h2 class="mb-0">0</h2>
                        </div>
                        <i class="fas fa-play-circle fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Khóa học hoàn thành</h6>
                            <h2 class="mb-0">0</h2>
                        </div>
                        <i class="fas fa-check-circle fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Tổng thời gian học</h6>
                            <h2 class="mb-0">0h</h2>
                        </div>
                        <i class="fas fa-clock fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-history"></i> Hoạt động gần đây</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Chưa có hoạt động nào</h6>
                                <small>Vừa xong</small>
                            </div>
                            <p class="mb-1">Hãy bắt đầu học tập ngay hôm nay!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-bullhorn"></i> Thông báo</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Chào mừng đến với hệ thống E-Learning!
                    </div>
                    <div class="alert alert-success">
                        <i class="fas fa-gift"></i> Đăng ký khóa học đầu tiên để nhận ưu đãi!
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="row mt-4">
        <div class="col-12">
            <h5 class="mb-3">Truy cập nhanh</h5>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <a href="<?php echo BASE_URL; ?>/enrollment/myCourses" class="card text-center text-decoration-none">
                        <div class="card-body">
                            <i class="fas fa-book fa-3x text-primary mb-3"></i>
                            <h6>Khóa học của tôi</h6>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="<?php echo BASE_URL; ?>/enrollment/progressList" class="card text-center text-decoration-none">
                        <div class="card-body">
                            <i class="fas fa-chart-line fa-3x text-success mb-3"></i>
                            <h6>Tiến độ học tập</h6>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="<?php echo BASE_URL; ?>/course" class="card text-center text-decoration-none">
                        <div class="card-body">
                            <i class="fas fa-search fa-3x text-info mb-3"></i>
                            <h6>Tìm khóa học mới</h6>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 mb-3">
                    <a href="#" class="card text-center text-decoration-none">
                        <div class="card-body">
                            <i class="fas fa-certificate fa-3x text-warning mb-3"></i>
                            <h6>Chứng chỉ của tôi</h6>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>