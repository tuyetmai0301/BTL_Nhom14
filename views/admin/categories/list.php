<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<!-- Sidebar -->
<?php require_once VIEW_PATH . '/layouts/sidebar.php'; ?>

<!-- Main Content -->
<div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Quản lý danh mục</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?php echo BASE_URL; ?>/admin/categoryCreate" class="btn btn-primary">
                <i class="fas fa-plus"></i> Thêm danh mục
            </a>
        </div>
    </div>

    <!-- Categories Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-tags"></i> Danh sách danh mục</h5>
        </div>
        <div class="card-body">
            <?php if (!empty($categories)): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Tên danh mục</th>
                                <th>Mô tả</th>
                                <th>Số khóa học</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td><?php echo $category['id']; ?></td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($category['name']); ?></strong>
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($category['description'] ?? 'Không có mô tả'); ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">0</span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?php echo BASE_URL; ?>/admin/categoryEdit?id=<?php echo $category['id']; ?>" 
                                               class="btn btn-outline-warning">
                                                <i class="fas fa-edit"></i> Sửa
                                            </a>
                                            <a href="<?php echo BASE_URL; ?>/admin/categoryDelete?id=<?php echo $category['id']; ?>" 
                                               class="btn btn-outline-danger"
                                               onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
                                                <i class="fas fa-trash"></i> Xóa
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
                    <i class="fas fa-tags fa-4x text-muted mb-4"></i>
                    <h3>Chưa có danh mục nào</h3>
                    <p class="text-muted">Hãy thêm danh mục đầu tiên để bắt đầu!</p>
                    <a href="<?php echo BASE_URL; ?>/admin/categoryCreate" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Thêm danh mục
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>