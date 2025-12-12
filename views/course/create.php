<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<!-- Sidebar -->
<?php require_once VIEW_PATH . '/layouts/sidebar.php'; ?>

<!-- Main Content -->
<div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Tạo khóa học mới</h1>
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

    <!-- Create Course Form -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-plus-circle"></i> Thông tin khóa học</h5>
        </div>
        <div class="card-body">
            <form action="<?php echo BASE_URL; ?>/course/store" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-8">
                        <!-- Course Title -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Tiêu đề khóa học <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" required 
                                   placeholder="Nhập tiêu đề khóa học">
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả khóa học <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="description" name="description" rows="5" required 
                                      placeholder="Mô tả chi tiết về khóa học"></textarea>
                        </div>

                        <!-- Category -->
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                <option value="">-- Chọn danh mục --</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category['id']; ?>">
                                        <?php echo htmlspecialchars($category['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Level -->
                        <div class="mb-3">
                            <label for="level" class="form-label">Cấp độ <span class="text-danger">*</span></label>
                            <select class="form-control" id="level" name="level" required>
                                <option value="">-- Chọn cấp độ --</option>
                                <option value="Beginner">Beginner (Cơ bản)</option>
                                <option value="Intermediate">Intermediate (Trung cấp)</option>
                                <option value="Advanced">Advanced (Nâng cao)</option>
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
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                    <p class="text-muted mt-2 mb-0">Xem trước ảnh</p>
                                </div>
                            </div>
                            <input type="file" class="form-control" id="image" name="image" 
                                   accept="image/*" onchange="previewImage(event)">
                            <small class="text-muted">Định dạng: JPG, PNG, GIF, WebP. Tối đa 5MB.</small>
                        </div>

                        <!-- Price -->
                        <div class="mb-3">
                            <label for="price" class="form-label">Giá khóa học ($) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="price" name="price" 
                                   min="0" step="0.01" required placeholder="0.00">
                        </div>

                        <!-- Duration -->
                        <div class="mb-3">
                            <label for="duration_weeks" class="form-label">Thời lượng (tuần) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="duration_weeks" name="duration_weeks" 
                                   min="1" required placeholder="4">
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="<?php echo BASE_URL; ?>/course/my_courses" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Hủy bỏ
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Tạo khóa học
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

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const price = document.getElementById('price').value;
        const duration = document.getElementById('duration_weeks').value;
        
        if (price < 0) {
            e.preventDefault();
            alert('Giá khóa học không được âm!');
            return false;
        }
        
        if (duration < 1) {
            e.preventDefault();
            alert('Thời lượng phải lớn hơn 0!');
            return false;
        }
    });
</script>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>