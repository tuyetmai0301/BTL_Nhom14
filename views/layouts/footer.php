            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>E-Learning System</h5>
                    <p>Hệ thống học trực tuyến chất lượng cao</p>
                </div>
                <div class="col-md-4">
                    <h5>Liên kết</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Về chúng tôi</a></li>
                        <li><a href="#" class="text-white">Chính sách bảo mật</a></li>
                        <li><a href="#" class="text-white">Điều khoản sử dụng</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Liên hệ</h5>
                    <p>Email: support@elearning.com</p>
                    <p>Điện thoại: 0123-456-789</p>
                </div>
            </div>
            <hr class="bg-white">
            <p class="text-center mb-0">© 2025 E-Learning System. All rights reserved.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Hiển thị thông báo từ session
        <?php if (isset($_SESSION['success'])): ?>
            alert('<?php echo $_SESSION['success']; ?>');
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            alert('<?php echo $_SESSION['error']; ?>');
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['message'])): ?>
            alert('<?php echo $_SESSION['message']; ?>');
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
    </script>
</body>
</html>