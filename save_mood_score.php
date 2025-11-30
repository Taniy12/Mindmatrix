<?php
session_start();
include('db.php'); // Include the database connection

// ✅ Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ✅ Fetch form data
    $user_id = $_SESSION['user_id']; // Get the user ID from the session
    $mood_score = $_POST['mood_score']; // Get the mood score submitted by the user
    $date = date('Y-m-d'); // Use today's date

    // ✅ Check if the mood score already exists for the user on that date
    $check_query = "SELECT * FROM mood_scores WHERE user_id = '$user_id' AND date = '$date'";
    $check_result = mysqli_query($conn, $check_query);

    // ✅ Check for query error
    if (!$check_result) {
        die("Error in query: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($check_result) > 0) {
        // ✅ If record exists, update it
        $update_query = "UPDATE mood_scores SET mood_score = '$mood_score' WHERE user_id = '$user_id' AND date = '$date'";
        if (mysqli_query($conn, $update_query)) {
            echo "Mood score updated successfully!";
        } else {
            echo "Error updating mood score: " . mysqli_error($conn);
        }
    } else {
        // ✅ If no record exists, insert a new one
        $insert_query = "INSERT INTO mood_scores (user_id, mood_score, date) VALUES ('$user_id', '$mood_score', '$date')";
        if (mysqli_query($conn, $insert_query)) {
            echo "Mood score saved successfully!";
        } else {
            echo "Error saving mood score: " . mysqli_error($conn);
        }
    }
} else {
    echo "Invalid request method!";
}
?>
