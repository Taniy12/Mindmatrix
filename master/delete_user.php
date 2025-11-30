<?php
session_start();
include('../db.php'); // Include your database connection

// Check if the master user is logged in
if (!isset($_SESSION['master_logged_in'])) {
    header("Location: master_login.php");
    exit();
}

// Check if the user ID is provided in the URL
if (isset($_GET['id'])) {
    $user_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Check if the user exists before deleting
    $check_query = "SELECT * FROM users WHERE id = '$user_id'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Delete the user from the database
        $delete_query = "DELETE FROM users WHERE id = '$user_id'";
        if (mysqli_query($conn, $delete_query)) {
            // Redirect to the dashboard with success message
            header("Location: master_dashboard.php?message=User deleted successfully.");
            exit();
        } else {
            // If there's an error deleting the user
            $error = "Error deleting user: " . mysqli_error($conn);
        }
    } else {
        // If user doesn't exist
        $error = "User not found!";
    }
} else {
    // If the ID is not set in the URL
    $error = "No user ID specified!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Delete User</h2>

        <?php if (isset($error) && $error != ''): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <a href="master_dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
