<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<!-- Sidebar -->
<?php require_once VIEW_PATH . '/layouts/sidebar.php'; ?>

<!-- Main Content -->
<div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Quản lý người dùng</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <button class="btn btn-sm btn-outline-primary" onclick="refreshUsers()">
                <i class="fas fa-sync-alt"></i> Làm mới
            </button>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-users"></i> Danh sách người dùng</h5>
        </div>
        <div class="card-body">
            <?php if (!empty($users)): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Tên đăng nhập</th>
                                <th>Họ tên</th>
                                <th>Email</th>
                                <th>Vai trò</th>
                                <th>Ngày tạo</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo $user['id']; ?></td>
                                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                                    <td><?php echo htmlspecialchars($user['fullname']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td>
                                        <?php 
                                        $roleText = '';
                                        $roleClass = '';
                                        switch($user['role']) {
                                            case -1: 
                                                $roleText = 'Bị khóa';
                                                $roleClass = 'danger';
                                                break;
                                            case 0: 
                                                $roleText = 'Học viên';
                                                $roleClass = 'info';
                                                break;
                                            case 1: 
                                                $roleText = 'Giảng viên';
                                                $roleClass = 'warning';
                                                break;
                                            case 2: 
                                                $roleText = 'Admin';
                                                $roleClass = 'success';
                                                break;
                                            default: 
                                                $roleText = 'Không xác định';
                                                $roleClass = 'secondary';
                                        }
                                        ?>
                                        <span class="badge bg-<?php echo $roleClass; ?>">
                                            <?php echo $roleText; ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('d/m/Y', strtotime($user['created_at'])); ?></td>
                                    <td>
                                        <?php if ($user['role'] == -1): ?>
                                            <span class="badge bg-danger">Bị khóa</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Hoạt động</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($user['role'] == -1): ?>
                                            <!-- Unlock button for locked accounts -->
                                            <form action="<?php echo BASE_URL; ?>/admin/updateUser" method="POST" class="d-inline">
                                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                                <input type="hidden" name="action" value="unlock">
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="fas fa-unlock"></i> Mở khóa
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <!-- Lock button for active accounts (not for admin) -->
                                            <?php if ($user['role'] != 2): ?>
                                                <form action="<?php echo BASE_URL; ?>/admin/updateUser" method="POST" class="d-inline">
                                                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                                    <input type="hidden" name="action" value="lock">
                                                    <button type="submit" class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('Bạn có chắc chắn muốn khóa tài khoản này?');">
                                                        <i class="fas fa-lock"></i> Khóa
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <span class="text-muted">Admin</span>
                                            <?php endif; ?>
                                        <?php endif; ?>
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
                            <div class="card-body text-center">
                                <h6 class="card-title">Tổng người dùng</h6>
                                <h2 class="mb-0"><?php echo count($users); ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-success">
                            <div class="card-body text-center">
                                <h6 class="card-title">Học viên</h6>
                                <h2 class="mb-0">
                                    <?php 
                                    $students = array_filter($users, function($u) {
                                        return $u['role'] == 0;
                                    });
                                    echo count($students);
                                    ?>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-warning">
                            <div class="card-body text-center">
                                <h6 class="card-title">Giảng viên</h6>
                                <h2 class="mb-0">
                                    <?php 
                                    $instructors = array_filter($users, function($u) {
                                        return $u['role'] == 1;
                                    });
                                    echo count($instructors);
                                    ?>
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-danger">
                            <div class="card-body text-center">
                                <h6 class="card-title">Bị khóa</h6>
                                <h2 class="mb-0">
                                    <?php 
                                    $locked = array_filter($users, function($u) {
                                        return $u['role'] == -1;
                                    });
                                    echo count($locked);
                                    ?>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-users fa-4x text-muted mb-4"></i>
                    <h3>Không có người dùng nào</h3>
                    <p class="text-muted">Chưa có người dùng nào trong hệ thống.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    function refreshUsers() {
        location.reload();
    }
</script>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>