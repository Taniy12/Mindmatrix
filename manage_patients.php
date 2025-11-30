<?php
session_start();
include('db.php');

// ✅ Check if therapist is logged in
if (!isset($_SESSION['therapist_logged_in'])) {
    header('Location: login_therapist.php');
    exit();
}

// ✅ Fetch all users (no therapist_id check needed)
$query = "SELECT id, name, email FROM users ORDER BY name ASC";
$result = mysqli_query($conn, $query);

// ✅ Check for query errors
if (!$result) {
    die("SQL Error: " . mysqli_error($conn));
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
        <h2 class="text-center">Manage Users</h2>
        <table class="table table-bordered table-striped mt-4">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    $count = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                            <td>{$count}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['email']}</td>
                        </tr>";
                        $count++;
                    }
                } else {
                    echo "<tr><td colspan='3' class='text-center'>No Users Found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <div class="text-center">
            <a href="therapist_home.php" class="btn btn-secondary">Back to Home</a>
        </div>
    </div>
</body>
</html>
