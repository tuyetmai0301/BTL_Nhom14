<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<!-- Sidebar -->
<?php require_once VIEW_PATH . '/layouts/sidebar.php'; ?>

<!-- Main Content -->
<div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Quản lý bài học</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?php echo BASE_URL; ?>/lesson/create?course_id=<?php echo $course_id; ?>" 
               class="btn btn-primary">
                <i class="fas fa-plus"></i> Thêm bài học mới
            </a>
            <a href="<?php echo BASE_URL; ?>/course/my_courses" 
               class="btn btn-outline-secondary ms-2">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Lessons List -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-list-ol"></i> Danh sách bài học</h5>
        </div>
        <div class="card-body">
            <?php if (!empty($lessons)): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>STT</th>
                                <th>Tên bài học</th>
                                <th>Tài liệu</th>
                                <th>Video</th>
                                <th>Thứ tự</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lessons as $lesson): ?>
                                <tr>
                                    <td><?php echo $lesson['order']; ?></td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($lesson['title']); ?></strong><br>
                                        <small class="text-muted">
                                            <?php echo strlen($lesson['content']) > 50 ? 
                                                substr($lesson['content'], 0, 50) . '...' : 
                                                $lesson['content']; ?>
                                        </small>
                                    </td>
                                    <td>
                                        <?php if (!empty($lesson['materials'])): ?>
                                            <span class="badge bg-info">
                                                <i class="fas fa-file"></i> <?php echo count($lesson['materials']); ?>
                                            </span>
                                            <?php foreach ($lesson['materials'] as $material): ?>
                                                <small class="d-block">
                                                    <i class="fas fa-file-<?php echo $material['file_type']; ?>"></i>
                                                    <?php echo htmlspecialchars($material['filename']); ?>
                                                </small>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Không có</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($lesson['video_url'])): ?>
                                            <span class="badge bg-success">Có video</span><br>
                                            <small><?php echo parse_url($lesson['video_url'], PHP_URL_HOST); ?></small>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Không có</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary"><?php echo $lesson['order']; ?></span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?php echo BASE_URL; ?>/material/upload?lesson_id=<?php echo $lesson['id']; ?>&course_id=<?php echo $course_id; ?>" 
                                               class="btn btn-outline-info" title="Thêm tài liệu">
                                                <i class="fas fa-file-upload"></i>
                                            </a>
                                            <a href="<?php echo BASE_URL; ?>/lesson/edit?id=<?php echo $lesson['id']; ?>" 
                                               class="btn btn-outline-warning" title="Sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?php echo BASE_URL; ?>/lesson/delete?id=<?php echo $lesson['id']; ?>&course_id=<?php echo $course_id; ?>" 
                                               class="btn btn-outline-danger" 
                                               onclick="return confirm('Bạn có chắc chắn muốn xóa bài học này?');" 
                                               title="Xóa">
                                                <i class="fas fa-trash"></i>
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
                    <i class="fas fa-book-open fa-4x text-muted mb-4"></i>
                    <h3>Khóa học này chưa có bài học nào</h3>
                    <p class="text-muted mb-4">Hãy thêm bài học đầu tiên để bắt đầu!</p>
                    <a href="<?php echo BASE_URL; ?>/lesson/create?course_id=<?php echo $course_id; ?>" 
                       class="btn btn-primary">
                        <i class="fas fa-plus"></i> Thêm bài học đầu tiên
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>