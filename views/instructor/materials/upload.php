<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<!-- Sidebar -->
<?php require_once VIEW_PATH . '/layouts/sidebar.php'; ?>

<!-- Main Content -->
<div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Upload tài liệu</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?php echo BASE_URL; ?>/lesson/manage?course_id=<?php echo $course_id; ?>" 
               class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <!-- Upload Form -->
    <div class="card">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0"><i class="fas fa-file-upload"></i> Upload tài liệu mới</h5>
        </div>
        <div class="card-body">
            <form action="<?php echo BASE_URL; ?>/material/store" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="lesson_id" value="<?php echo $lesson_id; ?>">
                <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
                
                <!-- File Upload -->
                <div class="mb-4">
                    <label for="file" class="form-label">Chọn tài liệu <span class="text-danger">*</span></label>
                    <div class="border rounded p-5 text-center mb-3" 
                         style="background-color: #f8f9fa; border-style: dashed !important;">
                        <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                        <h5>Kéo thả file vào đây hoặc click để chọn</h5>
                        <p class="text-muted">Hỗ trợ: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX</p>
                        <p class="text-muted">Kích thước tối đa: 10MB</p>
                    </div>
                    <input type="file" class="form-control" id="file" name="file" required>
                </div>

                <!-- File Info -->
                <div class="alert alert-warning">
                    <h6><i class="fas fa-exclamation-triangle"></i> Lưu ý:</h6>
                    <ul class="mb-0">
                        <li>Tên file sẽ được tự động làm sạch (thay thế ký tự đặc biệt bằng dấu _)</li>
                        <li>Timestamp sẽ được thêm vào tên file để tránh trùng lặp</li>
                        <li>Chỉ upload tài liệu liên quan đến bài học</li>
                    </ul>
                </div>

                <!-- Submit Buttons -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="<?php echo BASE_URL; ?>/lesson/manage?course_id=<?php echo $course_id; ?>" 
                       class="btn btn-secondary">
                        <i class="fas fa-times"></i> Hủy bỏ
                    </a>
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-upload"></i> Upload tài liệu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Drag and drop functionality
    const dropArea = document.querySelector('.border.rounded');
    const fileInput = document.getElementById('file');
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, unhighlight, false);
    });
    
    function highlight() {
        dropArea.style.backgroundColor = '#e9ecef';
    }
    
    function unhighlight() {
        dropArea.style.backgroundColor = '#f8f9fa';
    }
    
    dropArea.addEventListener('drop', handleDrop, false);
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        fileInput.files = files;
        
        // Show file name
        if (files.length > 0) {
            dropArea.innerHTML = `
                <i class="fas fa-file fa-3x text-success mb-3"></i>
                <h5>${files[0].name}</h5>
                <p class="text-muted">${(files[0].size / 1024 / 1024).toFixed(2)} MB</p>
                <p class="text-muted">Click để chọn file khác</p>
            `;
        }
    }
    
    // Click to upload
    dropArea.addEventListener('click', () => {
        fileInput.click();
    });
    
    // Change file input
    fileInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            dropArea.innerHTML = `
                <i class="fas fa-file fa-3x text-success mb-3"></i>
                <h5>${this.files[0].name}</h5>
                <p class="text-muted">${(this.files[0].size / 1024 / 1024).toFixed(2)} MB</p>
                <p class="text-muted">Click để chọn file khác</p>
            `;
        }
    });
</script>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>