<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<!-- Sidebar -->
<?php require_once VIEW_PATH . '/layouts/sidebar.php'; ?>

<!-- Main Content -->
<div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Thêm bài học mới</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?php echo BASE_URL; ?>/lesson/manage?course_id=<?php echo $course_id; ?>" 
               class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <!-- Create Lesson Form -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-plus-circle"></i> Thông tin bài học</h5>
        </div>
        <div class="card-body">
            <form action="<?php echo BASE_URL; ?>/lesson/store" method="POST">
                <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
                
                <!-- Title -->
                <div class="mb-3">
                    <label for="title" class="form-label">Tiêu đề bài học <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="title" name="title" required 
                           placeholder="Nhập tiêu đề bài học">
                </div>

                <!-- Content -->
                <div class="mb-3">
                    <label for="content" class="form-label">Nội dung bài học <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="content" name="content" rows="10" required 
                              placeholder="Nhập nội dung chi tiết của bài học..."></textarea>
                </div>

                <div class="row">
                    <!-- Video URL -->
                    <div class="col-md-8 mb-3">
                        <label for="video_url" class="form-label">URL Video bài giảng (tùy chọn)</label>
                        <input type="url" class="form-control" id="video_url" name="video_url" 
                               placeholder="https://www.youtube.com/watch?v=...">
                        <small class="text-muted">Hỗ trợ YouTube, Vimeo, và các nền tảng video khác.</small>
                    </div>

                    <!-- Order -->
                    <div class="col-md-4 mb-3">
                        <label for="order" class="form-label">Thứ tự bài học <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="order" name="order" 
                               min="1" value="1" required>
                        <small class="text-muted">Bài học sẽ được sắp xếp theo thứ tự này.</small>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="<?php echo BASE_URL; ?>/lesson/manage?course_id=<?php echo $course_id; ?>" 
                       class="btn btn-secondary">
                        <i class="fas fa-times"></i> Hủy bỏ
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Lưu bài học
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>