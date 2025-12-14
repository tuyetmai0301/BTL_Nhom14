<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<!-- Sidebar -->
<?php require_once VIEW_PATH . '/layouts/sidebar.php'; ?>

<!-- Main Content -->
<div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="pt-3 pb-2 mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/course">Khóa học</a></li>
                <li class="breadcrumb-item active"><?php echo htmlspecialchars($course['title']); ?></li>
            </ol>
        </nav>
        
        <div class="row">
            <!-- Course Info -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <?php if (!empty($course['image'])): ?>
                        <img src="<?php echo BASE_URL; ?>/assets/uploads/courses/<?php echo $course['image']; ?>" 
                             class="card-img-top" alt="<?php echo htmlspecialchars($course['title']); ?>" 
                             style="height: 400px; object-fit: cover;">
                    <?php endif; ?>
                    <div class="card-body">
                        <h1 class="card-title"><?php echo htmlspecialchars($course['title']); ?></h1>
                        <div class="d-flex gap-3 mb-3">
                            <span class="badge bg-primary"><?php echo htmlspecialchars($course['level']); ?></span>
                            <span class="badge bg-secondary">
                                <i class="fas fa-clock"></i> <?php echo $course['duration_weeks']; ?> tuần
                            </span>
                            <span class="badge bg-success">
                                <i class="fas fa-dollar-sign"></i> <?php echo number_format($course['price'], 2); ?>
                            </span>
                        </div>
                        <p class="card-text"><?php echo nl2br(htmlspecialchars($course['description'])); ?></p>
                        
                        <!-- Enrollment Button -->
                        <?php if (isset($_SESSION['user'])): ?>
                            <?php if ($_SESSION['user']['role'] == 0): // Student ?>
                                <?php if ($isEnrolled): ?>
                                    <div class="alert alert-success">
                                        <i class="fas fa-check-circle"></i> Bạn đã đăng ký khóa học này!
                                        <a href="<?php echo BASE_URL; ?>/lesson/courseMaterials?courseId=<?php echo $course['id']; ?>" 
                                           class="btn btn-sm btn-outline-primary ms-3">
                                            <i class="fas fa-play-circle"></i> Vào học ngay
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <form action="<?php echo BASE_URL; ?>/enrollment/register" method="POST">
                                        <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                                        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user']['id']; ?>">
                                        <button type="submit" class="btn btn-success btn-lg">
                                            <i class="fas fa-shopping-cart"></i> Đăng ký ngay
                                        </button>
                                    </form>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i> Vui lòng 
                                <a href="<?php echo BASE_URL; ?>/auth/loginPage">đăng nhập</a> 
                                để đăng ký khóa học này!
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Course Requirements -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-clipboard-list"></i> Yêu cầu khóa học</h5>
                    </div>
                    <div class="card-body">
                        <ul>
                            <li>Máy tính có kết nối internet</li>
                            <li>Kiến thức cơ bản về máy tính</li>
                            <li>Tinh thần học tập nghiêm túc</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Instructor Info -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-chalkboard-teacher"></i> Giảng viên</h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <div class="instructor-avatar mx-auto" 
                                 style="width: 100px; height: 100px; border-radius: 50%; background-color: #007bff; 
                                        color: white; display: flex; align-items: center; justify-content: center; 
                                        font-size: 2rem; font-weight: bold;">
                                GV
                            </div>
                        </div>
                        <h6>Giảng viên khóa học</h6>
                        <p class="text-muted">Giảng viên có nhiều năm kinh nghiệm trong lĩnh vực</p>
                    </div>
                </div>
                
                <!-- Course Stats -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-chart-bar"></i> Thông tin khóa học</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-users text-primary me-2"></i>
                                <strong>Số học viên:</strong> 100+
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-video text-primary me-2"></i>
                                <strong>Bài giảng:</strong> 50+ video
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-file-alt text-primary me-2"></i>
                                <strong>Tài liệu:</strong> Có sẵn
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-certificate text-primary me-2"></i>
                                <strong>Chứng chỉ:</strong> Có
                            </li>
                        </ul>
                    </div>
                </div>
                
                <!-- Share -->
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-share-alt"></i> Chia sẻ</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-center gap-3">
                            <button class="btn btn-outline-primary">
                                <i class="fab fa-facebook"></i>
                            </button>
                            <button class="btn btn-outline-info">
                                <i class="fab fa-twitter"></i>
                            </button>
                            <button class="btn btn-outline-danger">
                                <i class="fab fa-google"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>