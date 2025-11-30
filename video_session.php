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

// Check if the session is started
if ($session['session_status'] !== 'started') {
    die("❌ This session has not been started yet.");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Start Session - Therapy</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            padding: 30px;
            text-align: center;
        }
        .container {
            background-color: #ffffff;
            padding: 40px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            display: inline-block;
        }
        h1 {
            color: #333;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Therapy Session Started</h1>
        <p>👤 Session with User ID: <?php echo $session['user_id']; ?></p>
        <p>🔗 Click below to join the session:</p>
        <a href="<?php echo $session['video_link']; ?>" class="btn" target="_blank">Join Video Session</a>
    </div>
</body>
</html>
