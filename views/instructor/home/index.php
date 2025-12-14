<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<div class="container-fluid px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Khóa học trực tuyến</h1>
    </div>

    <div class="jumbotron bg-primary text-white p-5 rounded mb-5 shadow">
        <h1 class="display-4">Chào mừng đến với E-Learning!</h1>
        <a class="btn btn-light btn-lg mt-3" href="<?php echo BASE_URL; ?>/course" role="button">
            <i class="fas fa-search"></i> Tìm khóa học 
        </a>
    </div>

    <h3 class="mb-4 border-bottom pb-2">Khóa học nổi bật</h3>
    <div class="row">
        <?php if (!empty($courses)): ?>
            <?php foreach (array_slice($courses, 0, 6) as $course): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
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
                            <p class="card-text text-muted" style="min-height: 4.5em;">
                                <?php 
                                    $description = htmlspecialchars($course['description']);
                                    echo strlen($description) > 100 ? 
                                        substr($description, 0, 100) . '...' : 
                                        $description; 
                                ?>
                            </p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="badge bg-primary rounded-pill"><?php echo htmlspecialchars($course['level']); ?></span>
                                <span class="text-success fw-bold">
                                    <?php 
                                        $price = floatval($course['price']);
                                        echo ($price > 0) ? 
                                            number_format($price, 0, ',', '.') . ' VNĐ' : 
                                            'Miễn phí';
                                    ?>
                                </span>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top-0">
                            <a href="<?php echo BASE_URL; ?>/course/detail?id=<?php echo $course['id']; ?>" 
                               class="btn btn-outline-primary btn-sm w-100">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info">
                    Hiện chưa có khóa học nào. Hãy quay lại sau!
                </div>
            </div>
        <?php endif; ?>
    </div>

    <h3 class="mb-4 border-bottom pb-2 mt-5">Tại sao nên chọn chúng tôi?</h3>
    <div class="row mb-5">
        <div class="col-md-4 mb-3">
            <div class="card text-center h-100 shadow-sm border-0">
                <div class="card-body">
                    <i class="fas fa-laptop fa-3x text-primary mb-3"></i>
                    <h5>Học online</h5>
                    <p>Học mọi lúc, mọi nơi chỉ cần có kết nối internet</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center h-100 shadow-sm border-0">
                <div class="card-body">
                    <i class="fas fa-chalkboard-teacher fa-3x text-primary mb-3"></i>
                    <h5>Giảng viên chất lượng</h5>
                    <p>Đội ngũ giảng viên giàu kinh nghiệm, chuyên môn cao</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center h-100 shadow-sm border-0">
                <div class="card-body">
                    <i class="fas fa-certificate fa-3x text-primary mb-3"></i>
                    <h5>Chứng chỉ</h5>
                    <p>Nhận chứng chỉ uy tín sau khi hoàn thành khóa học</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="pb-5"></div>
</div>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>