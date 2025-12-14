<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0"><i class="fas fa-sign-in-alt"></i> Đăng nhập</h4>
                </div>
                <div class="card-body">
                    <form action="<?php echo BASE_URL; ?>/auth/login" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt"></i> Đăng nhập
                            </button>
                        </div>
                        <div class="text-center mt-3">
                            <p>Chưa có tài khoản? 
                                <a href="<?php echo BASE_URL; ?>/auth/registerPage">Đăng ký</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>