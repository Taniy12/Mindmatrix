<?php
session_start();
require "../includes/common.php";  // Going up one directory to access 'includes/common.php'
include('../db.php'); // Include the database connection

// AI-driven User Greeting - Dynamic Message Based on Time of Day
$hour = date('H');
if ($hour >= 5 && $hour < 12) {
    $greeting = "Good Morning, Master! Ready to start your day?";
} elseif ($hour >= 12 && $hour < 18) {
    $greeting = "Good Afternoon, Master! Time to conquer the challenges ahead!";
} else {
    $greeting = "Good Evening, Master! Let's finish strong today!";
}

// Login Logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check the database for the master credentials
    $query = "SELECT * FROM master_users WHERE username = '$username' AND role = 'master'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        // Compare the plain-text password
        if ($password == $row['password']) {
            $_SESSION['master_logged_in'] = true;
            header("Location: master_dashboard.php"); // Redirect to the dashboard
            exit();
        } else {
            $error = "Invalid credentials. Please try again.";
        }
    } else {
        $error = "No such master user found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Dynamic Background with AI Theme */
        body {
            background-image: url(https://www.shutterstock.com/image-vector/global-internet-network-security-digital-260nw-604575887.jpg); /* Dynamic AI-themed background */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            color: white;
        }

        /* Elegant Login Container with Glowing Edges */
        .login-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 50px;
            background-color: rgba(36, 31, 31, 0.8);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            border-radius: 15px;
            transform: scale(1);
            transition: transform 0.5s ease;
        }

        .login-container:hover {
            transform: scale(1.05);
        }

        /* Welcome Greeting */
        .greeting-message {
            text-align: center;
            font-size: 24px;
            margin-bottom: 30px;
            color:rgb(236, 222, 222);
            animation: fadeIn 2s ease-in-out;
        }

        /* Input Field Styling */
        .form-control {
            border-radius: 10px;
            padding: 12px;
            border: 1px solidrgb(54, 41, 41);
            background-color: rgba(255, 255, 255, 0.2);
            color: #fff;
            font-size: 18px;
        }

        /* Button Styling */
        .btn-primary {
            background-color: #4CAF50;
            border: none;
            border-radius: 15px;
            padding: 12px;
            width: 100%;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #45a049;
        }

        /* Alert Message Styling */
        .alert {
            margin-top: 20px;
            font-size: 16px;
        }

        /* Footer Styling */
        .footer {
            position: absolute;
            bottom: 20px;
            width: 100%;
            text-align: center;
            font-size: 14px;
            color: white;
        }

        /* Gradient Effect for Animation */
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        /* Button Animation */
        .btn-primary {
            background: linear-gradient(45deg, #ff7f50, #ff6347);
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #ff6347, #ff7f50);
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- AI-driven Greeting -->
        <div class="greeting-message">
            <?php echo $greeting; ?>
        </div>

        <div class="login-container">
            <h2 class="text-center">Master Login</h2>
            <form method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Enter your username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
                </div>

                <!-- Display error messages -->
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>

        <div class="footer">
            <p>&copy; 2025 MindMatrix. Designed with AI for the Master.</p>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
