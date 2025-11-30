<?php
session_start();
include('../db.php');

// Check for master login session
if (!isset($_SESSION['master_logged_in'])) {
    header("Location: master_login.php");
    exit();
}

// Handling session timeout (e.g., 30-minute timeout)
if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > 1800) {
    session_unset(); 
    session_destroy(); 
    header("Location: master_login.php");
    exit();
}
$_SESSION['last_activity'] = time();

// Check if user ID is passed via the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $user_id = $_GET['id'];
} else {
    die("No user ID provided. Please provide a valid user ID in the URL.");
}

// Fetch the user data based on the user ID
$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);
if (!$result || mysqli_num_rows($result) == 0) {
    die("User not found.");
}
$user = mysqli_fetch_assoc($result);

// Update the availability status
if (isset($_POST['update_status'])) {
    $status = $_POST['status']; // 'Available' or 'Unavailable'
    
    // Update the user status in the database
    $update_query = "UPDATE users SET status = '$status' WHERE id = '$user_id'";
    if (mysqli_query($conn, $update_query)) {
        echo "User status updated successfully.";
        header("Location: master_dashboard.php"); // Redirect to the master dashboard
        exit();
    } else {
        echo "Error updating status: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update User Status</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f0f0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            margin-top: 50px;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-bottom: 20px;
        }

        .btn {
            border-radius: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Update User Status</h2>

    <p><strong>User:</strong> <?= htmlspecialchars($user['name']) ?></p>
    <p><strong>Current Status:</strong> <?= htmlspecialchars($user['status']) ?></p>

    <!-- Form to update status -->
    <form method="POST" action="">
        <div class="mb-3">
            <label for="status" class="form-label">Select New Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="Available" <?= ($user['status'] == 'Available') ? 'selected' : ''; ?>>Available</option>
                <option value="Unavailable" <?= ($user['status'] == 'Unavailable') ? 'selected' : ''; ?>>Unavailable</option>
            </select>
        </div>

        <button type="submit" name="update_status" class="btn btn-primary">Update Status</button>
    </form>

    <br>
    <a href="master_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
</div>

<!-- Bootstrap JS and Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
