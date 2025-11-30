<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit;
}

include('db.php'); // Database connection

// Fetch feedback from the database
$query = "SELECT * FROM feedback";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Feedback</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>View Feedback</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Patient Name</th>
                    <th>Therapist</th>
                    <th>Rating</th>
                    <th>Comments</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($feedback = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $feedback['id']; ?></td>
                        <td><?php echo $feedback['patient_name']; ?></td>
                        <td><?php echo $feedback['therapist_name']; ?></td>
                        <td><?php echo $
