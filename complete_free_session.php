<?php
session_start();
include('db.php');

// ✅ Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// ✅ Get user and therapist IDs
$user_id = $_SESSION['user_id'];
$therapist_id = $_SESSION['therapist_id'] ?? null;

if (!$therapist_id) {
    die("Therapist not found. Please try again.");
}

// ✅ Check if session is already used
$check_query = "SELECT * FROM sessions WHERE user_id = '$user_id' AND therapist_id = '$therapist_id' AND session_type = 'free'";
$check_result = mysqli_query($conn, $check_query);

if (mysqli_num_rows($check_result) == 0) {
    // ✅ Insert free session as completed
    $insert_query = "INSERT INTO sessions (user_id, therapist_id, session_type, session_status, payment_status) 
                     VALUES ('$user_id', '$therapist_id', 'free', 'completed', 'not_paid')";
    mysqli_query($conn, $insert_query);
}

// ✅ Redirect to home after marking session complete
header('Location: home.php');
exit();
?>
