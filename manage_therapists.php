<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit;
}

include('db.php'); // Database connection

// Fetch therapists from the database
$query = "SELECT * FROM therapists";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Therapists</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Manage Therapists</h2>
        <a href="add_therapist.php" class="btn btn-success mb-3">Add New Therapist</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Specialization</th>
                   
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($therapist = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $therapist['id']; ?></td>
                        <td><?php echo $therapist['name']; ?></td>
                        <td><?php echo $therapist['specialization']; ?></td>
                        <td>
                            <a href="edit_therapist.php?id=<?php echo $therapist['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_therapist.php?id=<?php echo $therapist['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
