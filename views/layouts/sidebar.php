<!-- Sidebar -->
<div class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <?php if (isset($_SESSION['user'])): ?>
                <?php if ($_SESSION['user']['role'] == 0): // Student ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], '/home/studentDashboard') !== false) ? 'active' : ''; ?>" 
                           href="<?php echo BASE_URL; ?>/home/studentDashboard">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], '/enrollment/myCourses') !== false) ? 'active' : ''; ?>" 
                           href="<?php echo BASE_URL; ?>/enrollment/myCourses">
                            <i class="fas fa-book me-2"></i>Khóa học của tôi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], '/enrollment/progressList') !== false) ? 'active' : ''; ?>" 
                           href="<?php echo BASE_URL; ?>/enrollment/progressList">
                            <i class="fas fa-chart-line me-2"></i>Tiến độ học tập
                        </a>
                    </li>
                    
                <?php elseif ($_SESSION['user']['role'] == 1): // Instructor ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], '/course/dashboard') !== false) ? 'active' : ''; ?>" 
                           href="<?php echo BASE_URL; ?>/course/dashboard">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], '/course/my_courses') !== false) ? 'active' : ''; ?>" 
                           href="<?php echo BASE_URL; ?>/course/my_courses">
                            <i class="fas fa-list me-2"></i>Danh sách khóa học
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], '/course/create') !== false) ? 'active' : ''; ?>" 
                           href="<?php echo BASE_URL; ?>/course/create">
                            <i class="fas fa-plus-circle me-2"></i>Tạo khóa học mới
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], '/course/manage') !== false) ? 'active' : ''; ?>" 
                           href="<?php echo BASE_URL; ?>/course/manage">
                            <i class="fas fa-cogs me-2"></i>Quản lý khóa học
                        </a>
                    </li>
                    
                <?php elseif ($_SESSION['user']['role'] == 2): // Admin ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/dashboard') !== false) ? 'active' : ''; ?>" 
                           href="<?php echo BASE_URL; ?>/admin/dashboard">
                            <i class="fas fa-tachometer-alt me-2"></i>Tổng quan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/manageUsers') !== false) ? 'active' : ''; ?>" 
                           href="<?php echo BASE_URL; ?>/admin/manageUsers">
                            <i class="fas fa-users me-2"></i>Quản lý người dùng
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/categories') !== false) ? 'active' : ''; ?>" 
                           href="<?php echo BASE_URL; ?>/admin/categories">
                            <i class="fas fa-tags me-2"></i>Danh mục
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], '/admin/reports') !== false) ? 'active' : ''; ?>" 
                           href="<?php echo BASE_URL; ?>/admin/reports">
                            <i class="fas fa-chart-bar me-2"></i>Thống kê
                        </a>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
            
            <!-- Common Links -->
            <li class="nav-item">
                <a class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], '/course') !== false && !isset($_SESSION['user'])) ? 'active' : ''; ?>" 
                   href="<?php echo BASE_URL; ?>/course">
                    <i class="fas fa-search me-2"></i>Tìm khóa học
                </a>
            </li>
        </ul>
    </div>
</div>