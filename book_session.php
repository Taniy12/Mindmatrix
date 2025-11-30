<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['therapist_id'])) {
    $therapist_id = intval($_POST['therapist_id']);

    // Check if free session already used
    $check = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM sessions WHERE user_id = $user_id AND session_type = 'free'");
    $row = mysqli_fetch_assoc($check);
    $is_free = ($row['cnt'] == 0);

    $session_type = $is_free ? 'free' : 'paid';
    $payment_status = 'pending';
    $session_status = 'pending';

    // Create session
    $insert = "INSERT INTO sessions (user_id, therapist_id, session_type, session_status, payment_status)
               VALUES ($user_id, $therapist_id, '$session_type', '$session_status', '$payment_status')";
    if (mysqli_query($conn, $insert)) {
        $session_id = mysqli_insert_id($conn);
        // Redirect to payment page
        header("Location: payment_page.php?session_id=$session_id&therapist_id=$therapist_id");
        exit();
    } else {
        die("Error creating session: " . mysqli_error($conn));
    }
} 
?>
