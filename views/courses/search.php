<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<!-- Sidebar -->
<?php require_once VIEW_PATH . '/layouts/sidebar.php'; ?>

<!-- Main Content -->
<div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Tìm kiếm khóa học</h1>
    </div>

    <!-- Search Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="<?php echo BASE_URL; ?>/course/search" method="GET" class="row g-3">
                <div class="col-md-6">
                    <label for="q" class="form-label">Từ khóa tìm kiếm</label>
                    <input type="text" class="form-control" id="q" name="q" 
                           value="<?php echo htmlspecialchars($filters['q'] ?? ''); ?>" 
                           placeholder="Nhập tên khóa học...">
                </div>
                <div class="col-md-4">
                    <label for="category" class="form-label">Danh mục</label>
                    <select class="form-control" id="category" name="category">
                        <option value="">Tất cả danh mục</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['id']; ?>" 
                                <?php echo (($filters['category_id'] ?? '') == $category['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Tìm kiếm
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Results -->
    <h3 class="mb-3">Kết quả tìm kiếm 
        <?php if (!empty($filters['q']) || !empty($filters['category_id'])): ?>
            <span class="badge bg-primary"><?php echo count($courses); ?> kết quả</span>
        <?php endif; ?>
    </h3>

    <?php if (!empty($courses)): ?>
        <div class="row">
            <?php foreach ($courses as $course): ?>
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
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-primary"><?php echo htmlspecialchars($course['level']); ?></span>
                                <span class="text-success fw-bold">$<?php echo number_format($course['price'], 2); ?></span>
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
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> 
            <?php if (!empty($filters['q']) || !empty($filters['category_id'])): ?>
                Không tìm thấy khóa học nào phù hợp với tiêu chí tìm kiếm.
            <?php else: ?>
                Hiện chưa có khóa học nào. Vui lòng thử lại sau!
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>