<?php
// Include the database connection file
include('db.php');

// Initialize error messages variable
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data safely
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $specialization = isset($_POST['specialization']) ? $_POST['specialization'] : '';
    $contact = isset($_POST['contact']) ? $_POST['contact'] : '';

    // Validate form data
    if (empty($name) || empty($email) || empty($password) || empty($specialization) || empty($contact)) {
        $error = "All fields are required!";
    } else {
        // Insert therapist data into the database
        $sql = "INSERT INTO therapists (name, email, password, specialization, contact) 
                VALUES ('$name', '$email', '$password', '$specialization', '$contact')";
        
        if (mysqli_query($conn, $sql)) {
            $success = "Therapist added successfully!";
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Therapist</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center bg-primary text-white">Add Therapist</div>
                    <div class="card-body">
                        <!-- Display success or error message -->
                        <?php if (isset($success)) { echo "<div class='alert alert-success'>$success</div>"; } ?>
                        <?php if (!empty($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>

                        <!-- Form for adding a therapist -->
                        <form method="POST">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="specialization">Specialization</label>
                                <input type="text" name="specialization" id="specialization" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="contact">Phone</label>
                                <input type="text" name="contact" id="contact" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Therapist</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
