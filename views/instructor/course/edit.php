<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<!-- Sidebar -->
<?php require_once VIEW_PATH . '/layouts/sidebar.php'; ?>

<!-- Main Content -->
<div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Chỉnh sửa khóa học</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?php echo BASE_URL; ?>/course/my_courses" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Edit Course Form -->
    <div class="card">
        <div class="card-header bg-warning text-white">
            <h5 class="mb-0"><i class="fas fa-edit"></i> Chỉnh sửa: <?php echo htmlspecialchars($course['title']); ?></h5>
        </div>
        <div class="card-body">
            <form action="<?php echo BASE_URL; ?>/course/update" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $course['id']; ?>">
                
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-8">
                        <!-- Course Title -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Tiêu đề khóa học <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" required 
                                   value="<?php echo htmlspecialchars($course['title']); ?>">
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả khóa học <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="description" name="description" rows="5" required>
                                <?php echo htmlspecialchars($course['description']); ?>
                            </textarea>
                        </div>

                        <!-- Category -->
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                <option value="">-- Chọn danh mục --</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category['id']; ?>" 
                                        <?php echo ($category['id'] == $course['category_id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($category['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Level -->
                        <div class="mb-3">
                            <label for="level" class="form-label">Cấp độ <span class="text-danger">*</span></label>
                            <select class="form-control" id="level" name="level" required>
                                <option value="Beginner" <?php echo ($course['level'] == 'Beginner') ? 'selected' : ''; ?>>
                                    Beginner (Cơ bản)
                                </option>
                                <option value="Intermediate" <?php echo ($course['level'] == 'Intermediate') ? 'selected' : ''; ?>>
                                    Intermediate (Trung cấp)
                                </option>
                                <option value="Advanced" <?php echo ($course['level'] == 'Advanced') ? 'selected' : ''; ?>>
                                    Advanced (Nâng cao)
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-4">
                        <!-- Course Image -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Hình ảnh khóa học</label>
                            <div class="border rounded p-3 text-center mb-2" 
                                 style="height: 200px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa;">
                                <div class="image-preview">
                                    <?php if (!empty($course['image'])): ?>
                                        <img src="<?php echo BASE_URL; ?>/assets/uploads/courses/<?php echo $course['image']; ?>" 
                                             class="img-fluid" style="max-height: 180px;">
                                    <?php else: ?>
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                        <p class="text-muted mt-2 mb-0">Chưa có ảnh</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <input type="file" class="form-control" id="image" name="image" 
                                   accept="image/*" onchange="previewImage(event)">
                            <small class="text-muted">Để trống nếu không muốn thay đổi ảnh.</small>
                        </div>

                        <!-- Price -->
                        <div class="mb-3">
                            <label for="price" class="form-label">Giá khóa học ($) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="price" name="price" 
                                   min="0" step="0.01" required 
                                   value="<?php echo number_format($course['price'], 2); ?>">
                        </div>

                        <!-- Duration -->
                        <div class="mb-3">
                            <label for="duration_weeks" class="form-label">Thời lượng (tuần) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="duration_weeks" name="duration_weeks" 
                                   min="1" required value="<?php echo $course['duration_weeks']; ?>">
                        </div>

                        <!-- Created Info -->
                        <div class="alert alert-info">
                            <small>
                                <i class="fas fa-calendar"></i> Tạo ngày: <?php echo date('d/m/Y', strtotime($course['created_at'])); ?><br>
                                <i class="fas fa-user"></i> ID Giảng viên: <?php echo $course['instructor_id']; ?>
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="<?php echo BASE_URL; ?>/course/my_courses" class="btn btn-secondary">
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

<script>
    // Image preview function
    function previewImage(event) {
        const reader = new FileReader();
        const preview = document.querySelector('.image-preview');
        
        reader.onload = function() {
            preview.innerHTML = `<img src="${reader.result}" class="img-fluid" style="max-height: 180px;">`;
        };
        
        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>