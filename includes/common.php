<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session (if not already started)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database configuration
$host = "localhost"; // Database host
$username = "root"; // Database username
$password = ""; // Database password
$database = "mindmatrix"; // Database name

// Create a database connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Set charset to utf8 (if needed)
$conn->set_charset("utf8");

// Define global constants
define("SITE_NAME", "MindMatrix");
define("BASE_URL", "http://localhost/mindmatrix");

// Utility function to sanitize input
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Utility function to redirect users
function redirect($url) {
    header("Location: $url");
    exit();
}

// Utility function to check if the user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Utility function to check user role
function getUserRole() {
    return $_SESSION['role'] ?? null;
}

// Utility function to display error messages
function displayError($message) {
    return "<div class='alert alert-danger'>$message</div>";
}

// Utility function to display success messages
function displaySuccess($message) {
    return "<div class='alert alert-success'>$message</div>";
}
?>
