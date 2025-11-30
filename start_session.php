<?php
session_start();
include('db.php');

// Check if therapist is logged in
if (!isset($_SESSION['therapist_id'])) {
    header('Location: therapist_login.php');
    exit();
}

$therapist_id = $_SESSION['therapist_id'];

// Check if session ID is provided in the URL
if (!isset($_GET['session_id'])) {
    die("❌ Error: Session ID is missing.");
}

$session_id = intval($_GET['session_id']);

// Fetch session details from the database
$query = "SELECT * FROM sessions WHERE id = $session_id AND therapist_id = $therapist_id";
$result = mysqli_query($conn, $query);
$session = mysqli_fetch_assoc($result);

if (!$session) {
    die("❌ Error: Session not found or not assigned to you.");
}

// Check if the session is pending
if ($session['session_status'] !== 'pending') {
    die("❌ This session cannot be started. It is either already started or completed.");
}

// Update session status to 'started'
$update_query = "UPDATE sessions SET session_status = 'started' WHERE id = $session_id";
if (mysqli_query($conn, $update_query)) {
    // Generate a unique video call link (you can replace this with any video platform URL)
    $video_link = 'https://meet.jit.si/' . uniqid('session-', true);

    // Update the session with the video link
    mysqli_query($conn, "UPDATE sessions SET video_link = '$video_link' WHERE id = $session_id");

    // Redirect therapist to the video session page
    header("Location: video_session.php?session_id=$session_id");
    exit();
} else {
    die("❌ Error: Could not start the session.");
}
?>
