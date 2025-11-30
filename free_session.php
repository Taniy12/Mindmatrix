<?php
session_start();
include('db.php');

// ✅ Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// ✅ Check if therapist ID is provided
if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['therapist_id'])) {
    $therapist_id = intval($_POST['therapist_id']);
    $user_id = $_SESSION['user_id'];

    // ✅ Check if therapist ID is valid
    $therapist_query = "SELECT id FROM therapists WHERE id = '$therapist_id'";
    $therapist_result = mysqli_query($conn, $therapist_query);

    if (mysqli_num_rows($therapist_result) === 0) {
        die("❌ Therapist not found. Please try again.");
    }

    // ✅ Check if free session already used
    $check_free_query = "SELECT * FROM sessions WHERE user_id = '$user_id' AND therapist_id = '$therapist_id' AND session_type = 'free' AND session_status = 'completed'";
    $check_free_result = mysqli_query($conn, $check_free_query);

    if (mysqli_num_rows($check_free_result) > 0) {
        die("❌ You have already used your free session.");
    }

    // ✅ Insert free session into the database
    $insert_query = "INSERT INTO sessions (user_id, therapist_id, session_type, session_status, payment_status) 
                     VALUES ('$user_id', '$therapist_id', 'free', 'completed', 'free')";

    if (mysqli_query($conn, $insert_query)) {
        // ✅ Session inserted successfully, redirect to the free video page
        $_SESSION['selected_therapist'] = $therapist_id;  // Store therapist ID in session to track
        header("Location: free_video.php");  // Redirect to the video session page
        exit();
    } else {
        die("❌ Error booking free session: " . mysqli_error($conn));
    }
} else {
    die("❌ Therapist ID is missing. Please go back and try again.");
}
?>
