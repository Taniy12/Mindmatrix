<?php
session_start();
include('../db.php'); // Include your database connection

// Check if the master user is logged in
if (!isset($_SESSION['master_logged_in'])) {
    header("Location: master_login.php");
    exit();
}

// Check if the 'id' parameter is present in the URL
if (isset($_GET['id'])) {
    $user_id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Delete the user from the database
    $delete_query = "DELETE FROM users WHERE id = '$user_id'";

    if (mysqli_query($conn, $delete_query)) {
        // Redirect to the dashboard with success message
        header("Location: master_dashboard.php?message=User deleted successfully.");
        exit();
    } else {
        $error = "Error deleting user: " . mysqli_error($conn);
    }
} else {
    // If 'id' parameter is not provided, redirect to the dashboard
    header("Location: master_dashboard.php");
    exit();
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

        <p>Are you sure you want to delete this user? This action cannot be undone.</p>
        <a href="master_dashboard.php" class="btn btn-secondary">Cancel</a>
        <a href="delete_user.php?id=<?php echo $user_id; ?>" class="btn btn-danger">Delete User</a>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
