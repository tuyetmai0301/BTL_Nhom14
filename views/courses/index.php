<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<?php require_once VIEW_PATH . '/layouts/sidebar.php'; ?>

<div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Tất cả khóa học</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?php echo BASE_URL; ?>/course/search" class="btn btn-primary">
                <i class="fas fa-search"></i> Tìm kiếm nâng cao
            </a>
        </div>
    </div>

    <div class="mb-4">
        <h5>Lọc theo danh mục:</h5>
        <div class="d-flex flex-wrap gap-2">
            <?php 
                $current_category_id = isset($_GET['category']) ? $_GET['category'] : null;
                $all_button_class = (empty($current_category_id) || $current_category_id == 'all') ? 'btn-primary active' : 'btn-outline-primary';
            ?>
            <a href="<?php echo BASE_URL; ?>/course" class="btn <?php echo $all_button_class; ?>">Tất cả</a>

            <?php foreach ($categories as $category): ?>
                <?php 
                    // 2. Căn chỉnh lớp 'active' cho các danh mục
                    $category_button_class = ($current_category_id == $category['id']) ? 'btn-primary active' : 'btn-outline-secondary';
                ?>
                <a href="<?php echo BASE_URL; ?>/course?category=<?php echo $category['id']; ?>" 
                   class="btn <?php echo $category_button_class; ?>">
                    <?php echo htmlspecialchars($category['name']); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="row">
        <?php if (!empty($courses)): ?>
            <?php foreach ($courses as $course): ?>
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
                                <?php echo strlen($course['description']) > 100 ? 
                                    substr($course['description'], 0, 100) . '...' : 
                                    $course['description']; 
                                ?>
                            </p>
                            <div class="d-flex justify-content-between align-items-center mb-2">
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
                            <small class="text-muted">
                                <i class="fas fa-clock"></i> <?php echo $course['duration_weeks']; ?> tuần
                            </small>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="<?php echo BASE_URL; ?>/course/detail?id=<?php echo $course['id']; ?>" 
                               class="btn btn-primary btn-sm w-100">
                                <i class="fas fa-info-circle"></i> Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info d-flex align-items-center">
                    <i class="fas fa-info-circle me-2"></i> 
                    <strong>Không tìm thấy khóa học nào.</strong>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>