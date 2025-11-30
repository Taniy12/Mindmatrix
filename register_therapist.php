<?php
include('db.php');
$message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $specialization = mysqli_real_escape_string($conn, $_POST['specialization']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $access_code = mysqli_real_escape_string($conn, $_POST['access_code']);

    // Check if the therapist access code is correct
    if ($access_code !== "MM2025") {
        $message = "Invalid therapist access code!";
    } else {
        // Check if email already exists
        $query = "SELECT * FROM therapists WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $message = "Email is already registered!";
        } else {
            // Insert new therapist into the database
            $query = "INSERT INTO therapists (name, specialization, contact, email, password) 
                      VALUES ('$name', '$specialization', '$contact', '$email', '$password')";
            if (mysqli_query($conn, $query)) {
                header('Location: login_therapist.php'); // Redirect to login page
                exit();
            } else {
                $message = "Error registering. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Therapist Registration - MindMatrix</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url(https://images.rawpixel.com/image_800/cHJpdmF0ZS9sci9pbWFnZXMvd2Vic2l0ZS8yMDIyLTA1L3Y5MDEtYmFubmVyLTAyLmpwZw.jpg);
            background-color: rgb(133, 182, 241);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .register-container {
            background: rgb(151, 141, 238);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            max-width: 550px;
            width: 100%;
        }
    </style>
</head>
<body>
<div class="register-container">
    <h3 class="text-center mb-4">Therapist Registration</h3>

    <?php if ($message): ?>
        <div class="alert alert-danger"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required />
        </div>
        <div class="mb-3">
            <label class="form-label">Specialization</label>
            <input type="text" name="specialization" class="form-control" required />
        </div>
        <div class="mb-3">
            <label class="form-label">Contact</label>
            <input type="text" name="contact" class="form-control" required />
        </div>
        <div class="mb-3">
            <label class="form-label">Email ID</label>
            <input type="email" name="email" class="form-control" required />
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required />
        </div>
        <div class="mb-3">
            <label class="form-label">Therapist Access Code</label>
            <input type="text" name="access_code" class="form-control" required />
        </div>
        <p class="text-center">To get the access code only for therapist that had meeting with master user, contact the master user: <strong>9326288607</strong></p>
        <button type="submit" class="btn btn-success w-100">Register</button>
        <p class="text-center mt-3">Already have an account? <a href="login_therapist.php">Login here</a></p>
    </form>
</div>
</body>
</html>
