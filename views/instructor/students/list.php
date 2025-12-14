<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<!-- Sidebar -->
<?php require_once VIEW_PATH . '/layouts/sidebar.php'; ?>

<!-- Main Content -->
<div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Danh sách học viên</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?php echo BASE_URL; ?>/course/my_courses" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <!-- Students Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-users"></i> Học viên đăng ký khóa học</h5>
        </div>
        <div class="card-body">
            <?php if (!empty($students)): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>STT</th>
                                <th>Họ tên</th>
                                <th>Email</th>
                                <th>Tiến độ</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($students as $index => $student): ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($student['fullname']); ?></strong>
                                    </td>
                                    <td><?php echo htmlspecialchars($student['email']); ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress flex-grow-1 me-2" style="height: 20px;">
                                                <div class="progress-bar 
                                                    <?php echo $student['progress'] >= 100 ? 'bg-success' : 
                                                           ($student['progress'] >= 50 ? 'bg-warning' : 'bg-info'); ?>" 
                                                     style="width: <?php echo $student['progress']; ?>%">
                                                    <?php echo $student['progress']; ?>%
                                                </div>
                                            </div>
                                            <span><?php echo $student['progress']; ?>%</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?php echo ($student['status'] == 'active') ? 'success' : 'secondary'; ?>">
                                            <?php echo ($student['status'] == 'active') ? 'Đang học' : 'Ngừng học'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" 
                                                onclick="sendMessage('<?php echo $student['email']; ?>')">
                                            <i class="fas fa-envelope"></i> Gửi tin
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Statistics -->
                <div class="row mt-4">
                    <div class="col-md-3">
                        <div class="card text-white bg-primary">
                            <div class="card-body">
                                <h6 class="card-title">Tổng học viên</h6>
                                <h2 class="mb-0"><?php echo count($students); ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-success">
                            <div class="card-body">
                                <h6 class="card-title">Đang học</h6>
                                <h2 class="mb-0">
                                    <?php 
                                    $active = array_filter($students, function($s) {
                                        return $s['status'] == 'active';
                                    });
                                    echo count($active);
                                    ?>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-warning">
                            <div class="card-body">
                                <h6 class="card-title">Tiến độ TB</h6>
                                <h2 class="mb-0">
                                    <?php 
                                    $avg = array_sum(array_column($students, 'progress')) / count($students);
                                    echo round($avg, 1); 
                                    ?>%
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-info">
                            <div class="card-body">
                                <h6 class="card-title">Hoàn thành</h6>
                                <h2 class="mb-0">
                                    <?php 
                                    $completed = array_filter($students, function($s) {
                                        return $s['progress'] >= 100;
                                    });
                                    echo count($completed);
                                    ?>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-users fa-4x text-muted mb-4"></i>
                    <h3>Chưa có học viên nào đăng ký</h3>
                    <p class="text-muted">Học viên sẽ xuất hiện ở đây khi đăng ký khóa học của bạn.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    function sendMessage(email) {
        const message = prompt(`Nhập tin nhắn cho học viên (${email}):`);
        if (message) {
            alert(`Tin nhắn đã được gửi đến ${email}: ${message}`);
            // In a real application, you would send this via AJAX
        }
    }
</script>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>