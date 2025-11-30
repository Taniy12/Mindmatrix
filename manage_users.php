<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Manage Users</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Replace with dynamic PHP data -->
                <tr>
                    <td>1</td>
                    <td>john_doe</td>
                    <td>john@example.com</td>
                    <td>Patient</td>
                    <td><a href="edit_user.php?id=1" class="btn btn-warning btn-sm">Edit</a> <a href="delete_user.php?id=1" class="btn btn-danger btn-sm">Delete</a></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>jane_smith</td>
                    <td>jane@example.com</td>
                    <td>Therapist</td>
                    <td><a href="edit_user.php?id=2" class="btn btn-warning btn-sm">Edit</a> <a href="delete_user.php?id=2" class="btn btn-danger btn-sm">Delete</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
