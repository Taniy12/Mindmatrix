<?php
require "includes/common.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate user inputs
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format.'); window.history.back();</script>";
        exit();
    }

    // Check if the email exists in the database
    $check_email_query = "SELECT * FROM users WHERE email=?";
    $stmt_check = mysqli_prepare($conn, $check_email_query);
    mysqli_stmt_bind_param($stmt_check, 's', $email);
    mysqli_stmt_execute($stmt_check);
    $result = mysqli_stmt_get_result($stmt_check);
    
    if (mysqli_num_rows($result) == 0) {
        echo "<script>alert('Email does not exist. Please sign up.'); window.location.href='signup.php';</script>";
        exit();
    }

    // Fetch user data
    $user = mysqli_fetch_assoc($result);
    
    // Check if the password matches
    if ($password !== $user['password']) {
        echo "<script>alert('Invalid password.'); window.history.back();</script>";
        exit();
    }

    // Start session and store user info
    $_SESSION['email'] = $email;  // Store email in session
    $_SESSION['user_id'] = $user['id']; // Optional: Store user ID if needed

    echo "<script>alert('Login successful!'); window.location.href='questions.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - MindMatrix</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url(https://images.axa-contento-118412.eu/www-axa-com%2F108cce09-998a-4f96-8480-9f773e40a9d3_cover-3.jpg?auto=compress,format&rect=0,0,1920,1281&w=1920&h=1281);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            margin: 0;
            padding: 0;
            font-family: 'Times New Roman', Times, serif;
        }

        .login-container {
            background-color: rgba(238, 110, 110, 0.9);
            padding: 20px;
            border-radius: 10px;
            margin-top: 50px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .login-container h2 {
            font-weight: 700;
            color: #2c3e50;
            text-align: center;
        }

        .form-label {
            font-weight: 600;
            color: #34495e;
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #bdc3c7;
            padding: 10px;
        }

        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
        }

        .btn-success {
            background-color: #27ae60;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: 600;
            width: 100%;
            border-radius: 5px;
        }

        .btn-success:hover {
            background-color: #f56b0f;
        }

        a {
            color: #3498db;
            font-weight: 600;
        }

        a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .login-container {
                margin-top: 20px;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <form action="login.php" method="POST">
        <div class="container login-container">
            <h2>Login</h2>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-success">Login</button>
            <p class="mt-3">Don't have an account? <a href="signup.php">Sign Up</a></p>
        </div>
    </form>
</body>
</html>
