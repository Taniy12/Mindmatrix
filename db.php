<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mindmatrix";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to fetch all users
function getUsers($conn) {
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    $users = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }
    return $users;
}

// Function to insert a new user
function addUser($conn, $name, $email, $password) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        return "New user created successfully.";
    } else {
        return "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>