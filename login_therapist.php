<?php
include('db.php');
session_start(); // Start session to track logged-in user

$message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // Plain text password

    // Check if email exists and match the password
    $query = "SELECT * FROM therapists WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Email and password matched
        $row = mysqli_fetch_assoc($result);
        $_SESSION['therapist_id'] = $row['id']; // Store therapist ID in session
        $_SESSION['therapist_name'] = $row['name']; // Store therapist name in session
        
        // Redirect to the therapist dashboard
        header('Location: therapist_dashboard.php');
        exit();
    } else {
        $message = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Therapist Login - MindMatrix</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url(https://w0.peakpx.com/wallpaper/285/983/HD-wallpaper-calming-quotes-anxiety-blue-doodle-mental-health-motivational-relaxing-scribble-self-love-thumbnail.jpg);
            background-color: #f3f7fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background: rgb(229, 238, 144);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            max-width: 550px;
            width: 100%;
        }
    </style>
</head>
<body>
<div class="login-container">
    <h3 class="text-center mb-4">Therapist Login</h3>

    <?php if ($message): ?>
        <div class="alert alert-danger"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label class="form-label">Email ID</label>
            <input type="email" name="email" class="form-control" required />
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required />
        </div>
        <button type="submit" class="btn btn-success w-100">Login</button>
        <p class="text-center mt-3">Don't have an account? <a href="register_therapist.php">Register here</a></p>
    </form>
</div>
</body>
</html>
