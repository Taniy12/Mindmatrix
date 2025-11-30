<?php
session_start();
include('db.php');

// Check if therapist is logged in
if (!isset($_SESSION['therapist_id'])) {
    header("Location: therapist_login.php");
    exit();
}

// Logout logic
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login_therapist.php");
    exit();
}

$therapist_id = $_SESSION['therapist_id'];

// Fetch sessions with status 'completed'
$query = "SELECT * FROM sessions WHERE therapist_id = $therapist_id AND session_status = 'completed'";
$result = mysqli_query($conn, $query);
$completed_sessions = mysqli_num_rows($result) > 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Therapist Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-image: url(https://e0.pxfuel.com/wallpapers/980/242/desktop-wallpaper-awesome-aesthetic-flower-background-this-week-two-minds-aesthetic-butterfly-thumbnail.jpg);
            background-size: cover;
            font-family: 'Arial', sans-serif;
        }
        .container {
            max-width: 600px;
            margin-top: 40px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        h2 {
            text-align: center;
            color: #4CAF50;
        }
        .session-card {
            margin: 15px 0;
            background-color:rgb(248, 151, 151);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .btn-custom {
            background-color:rgb(252, 89, 25);
            color: white;
            border-radius: 5px;
            padding: 10px 20px;
            text-decoration: none;
            margin: 5px;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        .btn-danger {
            background-color: #e74c3c;
            border-radius: 5px;
            padding: 10px 20px;
        }
        .btn-danger:hover {
            background-color: #c0392b;
        }
        .feedback-card {
            background-color:rgb(137, 221, 241);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Welcome, Therapist</h2>

    <!-- Logout Button -->
    <div class="mb-4">
        <a href="?logout=true" class="btn btn-danger">Logout</a>
    </div>

    <h4>Your Completed Sessions</h4>

    <?php
    if ($completed_sessions) {
        while ($session = mysqli_fetch_assoc($result)) {
            $user_id = $session['user_id'];
            $session_id = $session['id'];

            // Get user details
            $user_query = "SELECT * FROM users WHERE id = $user_id";
            $user_result = mysqli_query($conn, $user_query);
            $user = mysqli_fetch_assoc($user_result);

            // Fetch feedback for the session
            $feedback_query = "SELECT * FROM feedback WHERE session_id = $session_id";
            $feedback_result = mysqli_query($conn, $feedback_query);
            $feedback = mysqli_fetch_assoc($feedback_result);
            ?>

            <div class="session-card">
              <h5>User: <?php echo isset($user['name']) ? htmlspecialchars($user['name']) : 'User info not found'; ?></h5>

                <p>Status: <?php echo $session['session_status']; ?></p>

                <!-- Video call options -->
                <div class="btn-group" role="group">
                    <a href="https://meet.jit.si" class="btn-custom" target="_blank">Start via Jitsi</a>
                    <a href="https://meet.google.com" class="btn-custom" target="_blank">Start via Google Meet</a>
                    <a href="https://zoom.us" class="btn-custom" target="_blank">Start via Zoom</a>
                </div>

                <!-- Feedback Section -->
                <?php if ($feedback) { ?>
                    <div class="feedback-card">
                        <h6>Feedback from User</h6>
                        <p>Rating: <?php echo $feedback['rating']; ?> / 5</p>
                        <p>Comment: <?php echo htmlspecialchars($feedback['comment']); ?></p>
                    </div>
                <?php } else { ?>
                    <div class="feedback-card">
                        <p>No feedback submitted yet.</p>
                    </div>
                <?php } ?>
            </div>

            <?php
        }
    } else {
        echo "<p>No completed sessions.</p>";
    }
    ?>
</div>

</body>
</html>
