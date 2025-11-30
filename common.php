<?php
// common.php

// Start the session
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mindmatrix";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize user inputs
function sanitizeInput($data) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($data));
}

// Function to check if the user is logged in
function isLoggedIn() {
    return isset($_SESSION['email']);
}

// Function to redirect users to a specific page
function redirect($url) {
    header("Location: $url");
    exit(); // Ensure no further code is executed after redirection
}

// Function to display error messages
function displayError($message) {
    echo "<div class='alert alert-danger'>$message</div>";
}

// Function to display success messages
function displaySuccess($message) {
    echo "<div class='alert alert-success'>$message</div>";
}
?>
