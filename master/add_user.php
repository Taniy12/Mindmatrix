<?php
session_start();
include('../db.php'); // Include your database connection

// Check if the master user is logged in
if (!isset($_SESSION['master_logged_in'])) {
    header("Location: master_login.php");
    exit();
}

// Initialize error variable
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if 'name', 'email', and 'password' are set in the POST request
    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {
        // Get form data
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        // Insert new user into the database
        $query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
        if (mysqli_query($conn, $query)) {
            $success = "New user added successfully!";
            // Redirect after success
            header("Location: master_dashboard.php?message=" . urlencode($success));
            exit();
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    } else {
        $error = "All fields (Name, Email, Password) are required!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Background image styles */
        body {
            background-image: url(https://longevity.technology/lifestyle/wp-content/uploads/2022/11/The-ultimate-guide-to-improving-brain-health-and-mental-clarity.jpg); /* Same background image */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            background-color: rgba(0, 0, 0, 0.7); /* Darker background for better text visibility */
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(5px);
            max-width: 600px;
            margin: 50px auto;
        }

        h2 {
            color: white; /* Make the title visible */
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 30px;
        }

        .alert {
            margin-bottom: 20px;
        }

        .form-label {
            color: white; /* Ensure form labels are visible */
            font-weight: 600;
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.8); /* Light background for form fields */
            color: black; /* Ensure text inside form fields is visible */
            border-radius: 25px;
            font-size: 1rem;
            transition: transform 0.3s ease-in-out;
        }

        .form-control:focus {
            background-color: rgba(255, 255, 255, 1); /* Highlight on focus */
            transform: scale(1.05);
        }

        .btn {
            width: 100%; /* Full width button */
            border-radius: 25px;
            padding: 15px;
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            color: white;
            font-size: 1.2rem;
            transition: transform 0.3s ease, background-color 0.3s ease;
        }

        .btn:hover {
            transform: scale(1.1);
            background-color: #ff5722;
        }

        .back-btn {
            display: block;
            width: 100%;
            text-align: center;
            margin-top: 20px;
            background-color: #444;
            padding: 12px;
            font-size: 1.1rem;
            border-radius: 25px;
        }

        .back-btn:hover {
            background-color: #1c1c1c;
        }

        /* AI-inspired Hover Effects */
        .ai-card {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 20px;
            transition: all 0.3s ease-in-out;
        }

        .ai-card:hover {
            transform: translateY(-10px);
            box-shadow: 0px 15px 40px rgba(0, 0, 0, 0.1);
        }

        .ai-card h3 {
            color: #fff;
            font-weight: 600;
        }

        /* Gradient Background and Text Hover Effect */
        .gradient-text {
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            -webkit-background-clip: text;
            color: transparent;
        }
    </style>
</head>
<body>
    <div class="container mt-4 ai-card">
        <h2 class="gradient-text">Add New User</h2>

        <?php if (isset($error) && $error != ''): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php elseif (isset($success)): ?>
            <div class="alert alert-success">
                <?php echo $success; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Add User</button>
        </form>

        <a href="master_dashboard.php" class="btn back-btn">Back to Dashboard</a>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
