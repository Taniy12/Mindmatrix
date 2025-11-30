<?php
session_start();
include('../db.php');

// Check for master login session
if (!isset($_SESSION['master_logged_in'])) {
    header("Location: master_login.php");
    exit();
}

// Handle form submission to send message to therapist
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $therapist_id = mysqli_real_escape_string($conn, $_POST['therapist_id']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Fetch therapist email using therapist ID
    $therapist_result = mysqli_query($conn, "SELECT email FROM therapists WHERE id = '$therapist_id'");
    $therapist = mysqli_fetch_assoc($therapist_result);

    if ($therapist) {
        $to = $therapist['email'];
        $subject = "Message from the Master Dashboard";
        $message_body = "Hello,\n\nYou have received a new message from the Master Dashboard:\n\n$message\n\nBest regards,\nThe Mindmatrix Team";

        // Send email
        if (mail($to, $subject, $message_body)) {
            echo "<script>alert('Message sent successfully!'); window.location.href='dashboard.php';</script>";
        } else {
            echo "<script>alert('Failed to send message. Please try again.'); window.location.href='dashboard.php';</script>";
        }
    } else {
        echo "<script>alert('Therapist not found.'); window.location.href='dashboard.php';</script>";
    }
}
?>
