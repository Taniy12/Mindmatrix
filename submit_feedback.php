<?php
session_start();
include('db.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get feedback from the form
    $feedback = mysqli_real_escape_string($conn, $_POST['feedback']);
    $session_id = intval($_POST['session_id']);
    
    // Insert feedback into the database
    $query = "UPDATE sessions SET feedback = '$feedback' WHERE id = $session_id AND user_id = $user_id";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        // Feedback submitted successfully
        header("Location: session_page.php?session_id=$session_id");
        exit();
    } else {
        die("❌ Error: Could not submit feedback. Please try again later.");
    }
}
?>
