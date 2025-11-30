<?php
session_start();
include('db.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get selected therapist's ID
if (!isset($_GET['therapist_id'])) {
    die("Therapist ID not provided.");
}

$therapist_id = $_GET['therapist_id'];

// Fetch therapist details
$query = "SELECT * FROM therapists WHERE id = $therapist_id";
$therapist_result = mysqli_query($conn, $query);
$therapist = mysqli_fetch_assoc($therapist_result);

if (!$therapist) {
    die("Therapist not found.");
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$user_query = "SELECT * FROM users WHERE id = $user_id";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Start Video Call</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://meet.jit.si/external_api.js"></script>
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Starting Video Call with Therapist: <?php echo $therapist['name']; ?></h2>
        <div id="video-conference"></div>
    </div>

    <script>
        // Jitsi Meet API
        const domain = "meet.jit.si";
        const options = {
            roomName: "MindmatrixRoom-<?php echo uniqid(); ?>", // Unique room for each call
            width: "100%",
            height: "100%",
            parentNode: document.querySelector("#video-conference"),
            userInfo: {
                displayName: "<?php echo $user['name']; ?>"
            }
        };

        const api = new JitsiMeetExternalAPI(domain, options);
    </script>
</body>
</html>
