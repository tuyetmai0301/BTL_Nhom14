<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="d-flex justify-content-center align-items-center" style="min-height: 90vh;">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header bg-success text-white text-center">
                    <h4 class="mb-0"><i class="fas fa-user-plus"></i> Đăng ký tài khoản</h4>
                </div>
                <div class="card-body">
                    <form action="<?php echo BASE_URL; ?>/auth/register" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">Tên đăng nhập</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="fullname" class="form-label">Họ và tên</label>
                                <input type="text" class="form-control" id="fullname" name="fullname" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Mật khẩu</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="confirm_password" class="form-label">Xác nhận mật khẩu</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="role" class="form-label">Bạn là?</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="0">Học viên</option>
                                <option value="1">Giảng viên</option>
                            </select>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-user-plus"></i> Đăng ký
                            </button>
                        </div>
                        
                        <div class="text-center mt-3">
                            <p>Đã có tài khoản? 
                                <a href="<?php echo BASE_URL; ?>/auth/loginPage">Đăng nhập</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>