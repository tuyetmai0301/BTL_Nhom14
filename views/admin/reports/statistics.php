<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<!-- Sidebar -->
<?php require_once VIEW_PATH . '/layouts/sidebar.php'; ?>

<!-- Main Content -->
<div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Thống kê & Báo cáo</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <button class="btn btn-sm btn-outline-primary" onclick="window.print()">
                <i class="fas fa-print"></i> In báo cáo
            </button>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Tổng người dùng</h6>
                            <h2 class="mb-0"><?php echo $totalUsers; ?></h2>
                        </div>
                        <i class="fas fa-users fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Tổng khóa học</h6>
                            <h2 class="mb-0"><?php echo $totalCourses; ?></h2>
                        </div>
                        <i class="fas fa-book fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Học viên đang học</h6>
                            <h2 class="mb-0"><?php echo $activeEnrollments; ?></h2>
                        </div>
                        <i class="fas fa-user-graduate fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">Tỉ lệ hoạt động</h6>
                            <h2 class="mb-0">
                                <?php 
                                $activityRate = $totalUsers > 0 ? ($activeEnrollments / $totalUsers * 100) : 0;
                                echo round($activityRate, 1); 
                                ?>%
                            </h2>
                        </div>
                        <i class="fas fa-chart-line fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Reports -->
    <div class="row">
        <!-- Courses by Category -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-chart-pie"></i> Khóa học theo danh mục</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height: 300px;">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Growth -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-chart-line"></i> Tăng trưởng người dùng</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height: 300px;">
                        <canvas id="growthChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-table"></i> Chi tiết theo danh mục</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Danh mục</th>
                            <th>Số khóa học</th>
                            <th>Tỷ lệ</th>
                            <th>Doanh thu ước tính</th>
                            <th>Học viên trung bình</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($courseByCategory)): ?>
                            <?php foreach ($courseByCategory as $item): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['category_name']); ?></td>
                                    <td>
                                        <strong><?php echo $item['total_courses']; ?></strong>
                                    </td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar" 
                                                 style="width: <?php echo ($item['total_courses'] / $totalCourses * 100); ?>%">
                                                <?php echo round($item['total_courses'] / $totalCourses * 100, 1); ?>%
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-success fw-bold">
                                            $<?php echo number_format($item['total_courses'] * 50, 2); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php echo rand(5, 50); ?> học viên
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Chưa có dữ liệu thống kê</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Summary -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-bullseye"></i> Mục tiêu</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Người dùng mới tháng này:</strong>
                        <span class="float-end">15</span>
                        <div class="progress mt-1" style="height: 10px;">
                            <div class="progress-bar bg-success" style="width: 75%"></div>
                        </div>
                        <small class="text-muted">75% của mục tiêu 20 người</small>
                    </div>
                    <div class="mb-3">
                        <strong>Khóa học mới tháng này:</strong>
                        <span class="float-end">8</span>
                        <div class="progress mt-1" style="height: 10px;">
                            <div class="progress-bar bg-info" style="width: 80%"></div>
                        </div>
                        <small class="text-muted">80% của mục tiêu 10 khóa</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-lightbulb"></i> Đề xuất</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> 
                        <strong>Thành công:</strong> Tăng trưởng ổn định trong quý này.
                    </div>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> 
                        <strong>Cần cải thiện:</strong> Tăng cường quảng bá các khóa học ít người học.
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> 
                        <strong>Đề xuất:</strong> Mở rộng danh mục công nghệ thông tin.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Charts
    document.addEventListener('DOMContentLoaded', function() {
        // Category Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        
        <?php if (!empty($courseByCategory)): ?>
            const categoryLabels = <?php echo json_encode(array_column($courseByCategory, 'category_name')); ?>;
            const categoryData = <?php echo json_encode(array_column($courseByCategory, 'total_courses')); ?>;
            
            new Chart(categoryCtx, {
                type: 'pie',
                data: {
                    labels: categoryLabels,
                    datasets: [{
                        data: categoryData,
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
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        <?php endif; ?>

        // Growth Chart
        const growthCtx = document.getElementById('growthChart').getContext('2d');
        
        // Sample growth data
        const months = ['Th1', 'Th2', 'Th3', 'Th4', 'Th5', 'Th6'];
        const userGrowth = [100, 150, 200, 250, 300, <?php echo $totalUsers; ?>];
        const courseGrowth = [10, 20, 30, 40, 50, <?php echo $totalCourses; ?>];
        
        new Chart(growthCtx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [
                    {
                        label: 'Người dùng',
                        data: userGrowth,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.1)',
                        tension: 0.1
                    },
                    {
                        label: 'Khóa học',
                        data: courseGrowth,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.1)',
                        tension: 0.1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>