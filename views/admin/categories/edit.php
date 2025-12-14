<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<!-- Sidebar -->
<?php require_once VIEW_PATH . '/layouts/sidebar.php'; ?>

<!-- Main Content -->
<div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Chỉnh sửa danh mục</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?php echo BASE_URL; ?>/admin/categories" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <!-- Edit Category Form -->
    <div class="card">
        <div class="card-header bg-warning text-white">
            <h5 class="mb-0"><i class="fas fa-edit"></i> Chỉnh sửa: <?php echo htmlspecialchars($category['name']); ?></h5>
        </div>
        <div class="card-body">
            <form action="<?php echo BASE_URL; ?>/admin/categoryEdit?id=<?php echo $category['id']; ?>" method="POST">
                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" required 
                           value="<?php echo htmlspecialchars($category['name']); ?>">
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label">Mô tả</label>
                    <textarea class="form-control" id="description" name="description" rows="4">
                        <?php echo htmlspecialchars($category['description'] ?? ''); ?>
                    </textarea>
                </div>

                <!-- Category Info -->
                <div class="alert alert-info">
                    <small>
                        <i class="fas fa-info-circle"></i> 
                        Danh mục ID: <?php echo $category['id']; ?>
                    </small>
                </div>

                <!-- Submit Buttons -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="<?php echo BASE_URL; ?>/admin/categories" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Hủy bỏ
                    </a>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>