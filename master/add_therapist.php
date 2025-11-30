<?php
session_start();
include('../db.php'); // Include your database connection

// Check if the master user is logged in
if (!isset($_SESSION['master_logged_in'])) {
    header("Location: master_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $specialization = mysqli_real_escape_string($conn, $_POST['specialization']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Insert the therapist into the database
    $insert_query = "INSERT INTO therapists (name, specialization, contact, email, password) 
                     VALUES ('$name', '$specialization', '$contact', '$email', '$password')";
    
    if (mysqli_query($conn, $insert_query)) {
        // Redirect to the dashboard with success message
        header("Location: master_dashboard.php?message=Therapist added successfully.");
        exit();
    } else {
        $error = "Error adding therapist: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Therapist</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS for the page -->
    <style>
        /* General Body Styling */
        body {
            background-image: url(https://www.nih.gov/sites/default/files/styles/floated_media_breakpoint-medium/public/news-events/research-matters/2018/20180227-mental.jpg?itok=qpQbBaRO&timestamp=1519744146); /* Same background */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
        }

        /* Page container with the same style as the user page */
        .container {
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
        }

        /* Heading Styling */
        h2 {
            text-align: center;
            color: white;
        }

        /* Form Styling */
        .form-label {
            color: white;
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.8); /* Lighter background for inputs */
            color: black;
            border-radius: 8px;
        }

        /* Submit Button */
        .btn-success {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            border: none;
            border-radius: 8px;
            transition: background-color 0.3s;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        /* Back to Dashboard Button */
        .btn-secondary {
            width: 100%;
            margin-top: 10px;
            text-align: center;
        }

        /* Mobile-first responsive design */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
        }

    </style>
</head>
<body>
    <!-- Main Container -->
    <div class="container mt-5">
        <h2>Add Therapist</h2>

        <?php if (isset($error) && $error != ''): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <!-- Form for adding therapist -->
        <form action="add_therapist.php" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Therapist Name</label>
                <input type="text" name="name" class="form-control" id="name" required>
            </div>
            <div class="mb-3">
                <label for="specialization" class="form-label">Specialization</label>
                <input type="text" name="specialization" class="form-control" id="specialization" required>
            </div>
            <div class="mb-3">
                <label for="contact" class="form-label">Contact</label>
                <input type="text" name="contact" class="form-control" id="contact" required pattern="^\d{10}$" title="Enter a valid 10-digit phone number">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" required minlength="6" title="Password must be at least 6 characters long">
            </div>
            <button type="submit" class="btn btn-success">Add Therapist</button>
        </form>

        <!-- Back to Dashboard Button -->
        <a href="master_dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
