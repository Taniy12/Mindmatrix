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
    <title>Manage Sessions</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Manage Sessions</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Patient</th>
                    <th>Therapist</th>
                    <th>Date & Time</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Replace with dynamic PHP data -->
                <tr>
                    <td>1</td>
                    <td>John Doe</td>
                    <td>Dr. Smith</td>
                    <td>2025-03-14 10:00 AM</td>
                    <td>Pending</td>
                    <td><a href="edit_session.php?id=1" class="btn btn-warning btn-sm">Edit</a> <a href="delete_session.php?id=1" class="btn btn-danger btn-sm">Delete</a></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Jane Doe</td>
                    <td>Dr. Lee</td>
                    <td>2025-03-15 02:00 PM</td>
                    <td>Confirmed</td>
                    <td><a href="edit_session.php?id=2" class="btn btn-warning btn-sm">Edit</a> <a href="delete_session.php?id=2" class="btn btn-danger btn-sm">Delete</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
