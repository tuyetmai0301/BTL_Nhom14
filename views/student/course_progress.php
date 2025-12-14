<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<!-- Sidebar -->
<?php require_once VIEW_PATH . '/layouts/sidebar.php'; ?>

<!-- Main Content -->
<div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Tiến độ học tập</h1>
    </div>

    <?php if (!empty($myCourses)): ?>
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-line"></i> Tổng quan tiến độ</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Khóa học</th>
                                <th>Tiến độ</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($myCourses as $course): ?>
                                <tr>
                                    <td>
                                        <strong><?php echo htmlspecialchars($course['title']); ?></strong>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress flex-grow-1 me-2" style="height: 20px;">
                                                <div class="progress-bar 
                                                    <?php echo $course['progress'] >= 100 ? 'bg-success' : 
                                                           ($course['progress'] >= 50 ? 'bg-warning' : 'bg-info'); ?>" 
                                                     style="width: <?php echo $course['progress']; ?>%">
                                                    <?php echo $course['progress']; ?>%
                                                </div>
                                            </div>
                                            <span><?php echo $course['progress']; ?>%</span>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if ($course['progress'] >= 100): ?>
                                            <span class="badge bg-success">Hoàn thành</span>
                                        <?php elseif ($course['progress'] > 0): ?>
                                            <span class="badge bg-warning">Đang học</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Chưa bắt đầu</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo BASE_URL; ?>/lesson/courseMaterials?courseId=<?php echo $course['course_id']; ?>" 
                                           class="btn btn-sm btn-primary">
                                            <i class="fas fa-play"></i> Học tiếp
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Progress Chart -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-chart-pie"></i> Phân bổ tiến độ</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center py-4">
                            <canvas id="progressChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-trophy"></i> Thành tích</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Khóa học đã hoàn thành
                                <span class="badge bg-primary rounded-pill">0</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Tổng thời gian học
                                <span class="badge bg-success rounded-pill">0 giờ</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Điểm trung bình
                                <span class="badge bg-warning rounded-pill">--</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Chứng chỉ đạt được
                                <span class="badge bg-danger rounded-pill">0</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="text-center py-5">
            <i class="fas fa-chart-line fa-5x text-muted mb-4"></i>
            <h3>Chưa có dữ liệu tiến độ</h3>
            <p class="text-muted">Hãy bắt đầu học tập để theo dõi tiến độ của bạn!</p>
            <a href="<?php echo BASE_URL; ?>/enrollment/myCourses" class="btn btn-primary btn-lg">
                <i class="fas fa-book"></i> Xem khóa học của tôi
            </a>
        </div>
    <?php endif; ?>
</div>

<script>
    // Simple Chart for Progress
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('progressChart').getContext('2d');
        
        <?php if (!empty($myCourses)): ?>
            const courses = <?php echo json_encode(array_column($myCourses, 'title')); ?>;
            const progresses = <?php echo json_encode(array_column($myCourses, 'progress')); ?>;
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: courses,
                    datasets: [{
                        label: 'Tiến độ (%)',
                        data: progresses,
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(255, 205, 86, 0.6)',
                            'rgba(153, 102, 255, 0.6)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 205, 86, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            });
        <?php endif; ?>
    });
</script>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>