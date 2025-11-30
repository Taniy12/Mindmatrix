<?php
session_start();
include('db.php');

// ✅ Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// ✅ Check for session ID in URL
if (!isset($_GET['id'])) {
    die("❌ Invalid session.");
}

$session_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// ✅ Fetch session details
$query = "SELECT s.*, t.name AS therapist_name FROM sessions s 
          JOIN therapists t ON s.therapist_id = t.id 
          WHERE s.id = '$session_id' AND s.user_id = '$user_id'";

$result = mysqli_query($conn, $query);
$session = mysqli_fetch_assoc($result);

// ✅ Check if session exists
if (!$session) {
    die("❌ Session not found.");
}

// ✅ Get meeting link
$meeting_link = $session['meeting_link'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Session Confirmation - MindMatrix</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">🎉 Session Booked Successfully!</h2>
        <p class="text-center">Your session with <strong><?php echo htmlspecialchars($session['therapist_name']); ?></strong> is confirmed.</p>

        <!-- ✅ Display Zoom/Google Meet Link -->
        <div class="text-center mt-3">
            <p><strong>🔗 Your Meeting Link:</strong></p>
            <a href="<?php echo htmlspecialchars($meeting_link); ?>" target="_blank" class="btn btn-info">🚀 Join Session</a>
        </div>

        <div class="text-center mt-4">
            <a href="home.php" class="btn btn-success">🏠 Return to Home</a>
        </div>
    </div>
</body>
</html>
