<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<!-- Sidebar -->
<?php require_once VIEW_PATH . '/layouts/sidebar.php'; ?>

<!-- Main Content -->
<div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Khóa học của tôi</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?php echo BASE_URL; ?>/course" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Đăng ký khóa học mới
            </a>
        </div>
    </div>

    <?php if (!empty($myCourses)): ?>
        <div class="row">
            <?php foreach ($myCourses as $course): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <?php if (!empty($course['image'])): ?>
                            <img src="<?php echo BASE_URL; ?>/assets/uploads/courses/<?php echo $course['image']; ?>" 
                                 class="card-img-top" alt="<?php echo htmlspecialchars($course['title']); ?>" 
                                 style="height: 200px; object-fit: cover;">
                        <?php else: ?>
                            <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" 
                                 style="height: 200px;">
                                <i class="fas fa-book fa-3x text-white"></i>
                            </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($course['title']); ?></h5>
                            <p class="card-text text-muted">
                                <?php echo strlen($course['description']) > 100 ? 
                                    substr($course['description'], 0, 100) . '...' : 
                                    $course['description']; ?>
                            </p>
                            
                            <!-- Progress Bar -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <small>Tiến độ</small>
                                    <small><?php echo $course['progress'] ?? 0; ?>%</small>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-success" 
                                         style="width: <?php echo $course['progress'] ?? 0; ?>%"></div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-<?php echo ($course['status'] == 'active') ? 'success' : 'secondary'; ?>">
                                    <?php echo ($course['status'] == 'active') ? 'Đang học' : 'Đã hoàn thành'; ?>
                                </span>
                                <span class="badge bg-primary"><?php echo htmlspecialchars($course['level']); ?></span>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="d-grid gap-2">
                                <a href="<?php echo BASE_URL; ?>/lesson/courseMaterials?courseId=<?php echo $course['id']; ?>" 
                                   class="btn btn-primary btn-sm">
                                    <i class="fas fa-play-circle"></i> Tiếp tục học
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-5">
            <i class="fas fa-book fa-5x text-muted mb-4"></i>
            <h3>Bạn chưa đăng ký khóa học nào</h3>
            <p class="text-muted">Hãy khám phá và đăng ký các khóa học thú vị ngay hôm nay!</p>
            <a href="<?php echo BASE_URL; ?>/course" class="btn btn-primary btn-lg">
                <i class="fas fa-search"></i> Tìm khóa học
            </a>
        </div>
    <?php endif; ?>
</div>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>