<?php
session_start();
include('db.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Get session ID from URL
if (!isset($_GET['session_id'])) {
    die("❌ Error: Session ID is missing.");
}

$session_id = intval($_GET['session_id']);

// Fetch session details
$session_query = "SELECT * FROM sessions WHERE id = $session_id";
$session_result = mysqli_query($conn, $session_query);
$session = mysqli_fetch_assoc($session_result);

if (!$session) {
    die("❌ Error: Session not found.");
}

// Get therapist ID (assuming it is stored in the session or the session details)
$therapist_id = $session['therapist_id']; // Assuming therapist_id is in the session

// Handle feedback submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if comment and rating are set
    if (isset($_POST['comment']) && isset($_POST['rating'])) {
        // Sanitize feedback text
        $feedback_text = mysqli_real_escape_string($conn, $_POST['comment']);
        $rating = intval($_POST['rating']); // Rating will be an integer

        // Validate feedback
        if (empty($feedback_text)) {
            die("❌ Error: Feedback cannot be empty.");
        }

        if ($rating < 1 || $rating > 5) {
            die("❌ Error: Rating must be between 1 and 5.");
        }

        // Insert feedback into the database
        $insert_query = "INSERT INTO feedback (session_id, user_id, therapist_id, rating, comment) 
                         VALUES ($session_id, $user_id, $therapist_id, $rating, '$feedback_text')";
        
        // Execute query and check for success
        if (mysqli_query($conn, $insert_query)) {
            // Log out the user and redirect to the login page
            session_unset();
            session_destroy();
            header("Location: login.php"); 
            exit();
        } else {
            // Display detailed error if query fails
            echo "❌ Error submitting feedback! " . mysqli_error($conn);
        }
    } 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submit Feedback</title>
    <style>
        body {
            background-image: url('https://news.emory.edu/stories/2012/11/esc_positive_mental_health_boosts_lifespan/thumbs/story_main_happy.jpg');
            background-size: cover;
            background-attachment: fixed;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 650px;
            margin: 100px auto;
            background: rgba(229, 143, 193, 0.85);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }
        h2 {
            text-align: center;
            color: #2c3e50;
        }
        textarea {
            width: 100%;
            height: 150px;
            margin: 10px 0;
            padding: 10px;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }
        select, .btn {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }
        .btn {
            text-align: center;
            margin-top: 20px;
        }
        .btn input {
            background-color: #2575fc;
            color: white;
            padding: 12px 25px;
            border-radius: 30px;
            font-size: 16px;
            cursor: pointer;
            border: none;
        }
        .btn input:hover {
            background-color: #1a5edc;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>📝 Submit Your Feedback</h2>

        <form action="" method="POST">
            <!-- Rating -->
            <label for="rating">Rating (1 to 5):</label>
            <select name="rating" id="rating" required>
                <option value="">Select Rating</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>

            <!-- Feedback Comment -->
            <label for="comment">Your Feedback:</label>
            <textarea name="comment" id="comment" required></textarea>

            <div class="btn">
                <input type="submit" value="Submit Feedback">
            </div>
        </form>
    </div>

</body>
</html>
