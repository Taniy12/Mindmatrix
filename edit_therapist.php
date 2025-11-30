<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit;
}

include('db.php'); // Database connection

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch therapist data
    $query = "SELECT * FROM therapists WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    $therapist = mysqli_fetch_assoc($result);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $specialization = $_POST['specialization'];
        $available_hours = $_POST['available_hours'];

        // Update therapist data
        $updateQuery = "UPDATE therapists SET name = '$name', specialization = '$specialization', available_hours = '$available_hours' WHERE id = '$id'";
        if (mysqli_query($conn, $updateQuery)) {
            header('Location: manage_therapists.php');
            exit();
        } else {
            echo "<script>alert('Error updating therapist');</script>";
        }
    }
} else {
    header('Location: manage_therapists.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Therapist</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Therapist</h2>
        <form method="POST">
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $therapist['name']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Specialization</label>
                <input type="text" name="specialization" class="form-control" value="<?php echo $therapist['specialization']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Available Hours</label>
                <input type="text" name="available_hours" class="form-control" value="<?php echo $therapist['available_hours']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Therapist</button>
        </form>
    </div>
</body>
</html>
