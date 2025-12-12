<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

/*
|--------------------------------------------------------------------------
| 1. CONFIGURATION
|--------------------------------------------------------------------------
*/
// Error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Define paths
define('ROOT_PATH', __DIR__);
define('CONFIG_PATH', ROOT_PATH . '/config');
define('CONTROLLER_PATH', ROOT_PATH . '/controllers');
define('MODEL_PATH', ROOT_PATH . '/models');
define('VIEW_PATH', ROOT_PATH . '/views');

// Define base URL
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$script_name = $_SERVER['SCRIPT_NAME'];
$base_dir = str_replace(basename($script_name), '', $script_name);
$base_dir = rtrim($base_dir, '/');

define('BASE_URL', $protocol . "://" . $host . $base_dir);

/*
|--------------------------------------------------------------------------
| 2. INCLUDE DATABASE CONFIG
|--------------------------------------------------------------------------
*/
require_once CONFIG_PATH . '/Database.php';

/*
|--------------------------------------------------------------------------
| 3. SIMPLE ROUTER
|--------------------------------------------------------------------------
*/
class Router {
    private $routes = [];
    
    public function __construct() {
        // Define routes
        $this->routes = [
            '/' => ['HomeController', 'index'],
            '/home' => ['HomeController', 'index'],
            '/home/index' => ['HomeController', 'index'],
            
            // Auth routes
            '/auth/loginPage' => ['AuthController', 'loginPage'],
            '/auth/login' => ['AuthController', 'login'],
            '/auth/registerPage' => ['AuthController', 'registerPage'],
            '/auth/register' => ['AuthController', 'register'],
            '/auth/logout' => ['AuthController', 'logout'],
            
            // Course routes
            '/course' => ['CourseController', 'index'],
            '/course/index' => ['CourseController', 'index'],
            '/course/detail' => ['CourseController', 'detail'],
            '/course/search' => ['CourseController', 'search'],
            '/course/dashboard' => ['CourseController', 'dashboard'],
            '/course/my_courses' => ['CourseController', 'my_courses'],
            '/course/manage' => ['CourseController', 'manage'],
            '/course/create' => ['CourseController', 'create'],
            '/course/store' => ['CourseController', 'store'],
            '/course/edit' => ['CourseController', 'edit'],
            '/course/update' => ['CourseController', 'update'],
            '/course/delete' => ['CourseController', 'delete'],
            
            // Lesson routes
            '/lesson/manage' => ['LessonController', 'manage'],
            '/lesson/create' => ['LessonController', 'create'],
            '/lesson/store' => ['LessonController', 'store'],
            '/lesson/edit' => ['LessonController', 'edit'],
            '/lesson/update' => ['LessonController', 'update'],
            '/lesson/delete' => ['LessonController', 'delete'],
            '/lesson/courseMaterials' => ['LessonController', 'courseMaterials'],
            
            // Material routes
            '/material/upload' => ['MaterialController', 'upload'],
            '/material/store' => ['MaterialController', 'store'],
            '/material/delete' => ['MaterialController', 'delete'],
            
            // Enrollment routes
            '/enrollment/register' => ['EnrollmentController', 'register'],
            '/enrollment/myCourses' => ['EnrollmentController', 'myCourses'],
            '/enrollment/progressList' => ['EnrollmentController', 'progressList'],
            '/enrollment/studentsProgress' => ['EnrollmentController', 'studentsProgress'],
            '/enrollment/updateProgressAjax' => ['EnrollmentController', 'updateProgressAjax'],
            
            // Admin routes
            '/admin/dashboard' => ['AdminController', 'dashboard'],
            '/admin/manageUsers' => ['AdminController', 'manageUsers'],
            '/admin/updateUser' => ['AdminController', 'updateUser'],
            '/admin/categories' => ['AdminController', 'categories'],
            '/admin/categoryCreate' => ['AdminController', 'categoryCreate'],
            '/admin/categoryEdit' => ['AdminController', 'categoryEdit'],
            '/admin/categoryDelete' => ['AdminController', 'categoryDelete'],
            '/admin/statistics' => ['AdminController', 'statistics'],
            '/admin/reports' => ['AdminController', 'reports'],
            
            // Home routes
            '/home/studentDashboard' => ['HomeController', 'studentDashboard'],
            '/home/instructorDashboard' => ['HomeController', 'instructorDashboard'],
        ];
    }
    
    public function run() {
        // Get request URI
        $request_uri = $_SERVER['REQUEST_URI'];
        
        // Remove query string
        $request_uri = parse_url($request_uri, PHP_URL_PATH);
        
        // Remove base directory if exists
        $base_dir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
        $base_dir = rtrim($base_dir, '/');
        
        if ($base_dir !== '' && strpos($request_uri, $base_dir) === 0) {
            $request_uri = substr($request_uri, strlen($base_dir));
        }
        
        $request_uri = rtrim($request_uri, '/');
        if ($request_uri === '') {
            $request_uri = '/';
        }
        
        // Debug
        $this->debug($request_uri);
        
        // Find matching route
        $found = false;
        
        foreach ($this->routes as $route => $handler) {
            // Exact match
            if ($route === $request_uri) {
                $found = true;
                $this->executeHandler($handler);
                break;
            }
            
            // Match with parameters (e.g., /course/detail/123)
            if (strpos($route, '/') !== false) {
                $route_parts = explode('/', $route);
                $request_parts = explode('/', $request_uri);
                
                if (count($route_parts) === count($request_parts)) {
                    $match = true;
                    $params = [];
                    
                    for ($i = 0; $i < count($route_parts); $i++) {
                        if ($route_parts[$i] !== $request_parts[$i]) {
                            // Check if it's a parameter placeholder
                            if (preg_match('/^{(.+)}$/', $route_parts[$i])) {
                                $params[] = $request_parts[$i];
                            } else {
                                $match = false;
                                break;
                            }
                        }
                    }
                    
                    if ($match) {
                        $found = true;
                        $this->executeHandler($handler, $params);
                        break;
                    }
                }
            }
        }
        
        // 404 if no route found
        if (!$found) {
            http_response_code(404);
            echo "<h1>404 Not Found</h1>";
            echo "<p>Route '$request_uri' not found.</p>";
            echo "<p>Available routes:</p>";
            echo "<ul>";
            foreach (array_keys($this->routes) as $route) {
                echo "<li>$route</li>";
            }
            echo "</ul>";
        }
    }
    
    private function executeHandler($handler, $params = []) {
        list($controller, $method) = $handler;
        $controller_file = CONTROLLER_PATH . '/' . $controller . '.php';
        
        if (!file_exists($controller_file)) {
            http_response_code(500);
            die("500 Error: Controller file '$controller.php' not found.");
        }
        
        require_once $controller_file;
        
        if (!class_exists($controller)) {
            http_response_code(500);
            die("500 Error: Controller class '$controller' not found.");
        }
        
        $controller_instance = new $controller();
        
        if (!method_exists($controller_instance, $method)) {
            http_response_code(404);
            die("404 Not Found: Method '$method' not found in $controller.");
        }
        
        // Call controller method
        call_user_func_array([$controller_instance, $method], $params);
    }
    
    private function debug($request_uri) {
        // Uncomment for debugging
        /*
        echo "<div style='background:#f0f0f0; padding:10px; margin:10px; border:1px solid #ccc;'>";
        echo "<strong>Debug Info:</strong><br>";
        echo "Request URI: $request_uri<br>";
        echo "BASE_URL: " . BASE_URL . "<br>";
        echo "Controller Path: " . CONTROLLER_PATH . "<br>";
        echo "</div>";
        */
    }
}

// Run the router
$router = new Router();
$router->run();