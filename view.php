<?php
session_start();
include('db.php'); // Include database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Fetch user ID
$user_id = $_SESSION['user_id'];

// Get all mood scores for the user
$query = "SELECT * FROM mood_scores WHERE user_id = '$user_id' ORDER BY date DESC";
$result = mysqli_query($conn, $query);

// Check if query executed successfully
if (!$result) {
    die("Error in query: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindMatrix - Mood Analytics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="text-center mt-4">Your Mood Score Analytics</h1>
    
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Date</th>
                <th>Mood Score</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Display mood scores
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['date']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['mood_score']) . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="2" class="text-center">No mood scores recorded yet.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
