<?php
// Error reporting - only enabled in development mode
if ($_ENV['DEV_MODE'] ?? false) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Load models, helpers, controllers
require_once __DIR__ . '/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();
require_once __DIR__ . '/config.php';

// Start session
session_start();

// Create database connection with error handling
try {
    $db = new PDO(
        $config['db_connection'] . ':host=' . $config['db_host'] . ';port=' . $config['db_port'] . ';dbname=' . $config['db_database'],
        $config['db_username'],
        $config['db_password'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        ]
    );
} catch (PDOException $e) {
    // Database connection failed
    if ($_ENV['DEV_MODE'] ?? false) {
        die('Database connection failed: ' . $e->getMessage());
    } else {
        die('Database connection failed. Please contact the administrator.');
    }
}

// Create router, load routes and run
try {
    $router = new \Bramus\Router\Router();
    require_once __DIR__ . '/routes.php';
    $router->run();
} catch (Exception $e) {
    // Router error
    if ($_ENV['DEV_MODE'] ?? false) {
        die('Router error: ' . $e->getMessage());
    } else {
        die('An error occurred. Please try again later.');
    }
}