<?php
session_start();
include('../db.php');

// Check for master login session
if (!isset($_SESSION['master_logged_in'])) {
    header("Location: master_login.php");
    exit();
}

// Handling session timeout (e.g., 30-minute timeout)
if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > 1800) {
    session_unset(); 
    session_destroy(); 
    header("Location: master_login.php");
    exit();
}
$_SESSION['last_activity'] = time();

// Fetching users, therapists, feedback, and sessions with pagination for users and therapists
function fetchData($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Error executing query: " . mysqli_error($conn));
    }
    return $result;
}

$users_result = fetchData("SELECT * FROM users LIMIT 10");
$therapists_result = fetchData("SELECT * FROM therapists LIMIT 10");
$feedback_result = fetchData("SELECT * FROM feedback");
$sessions_result = fetchData("SELECT * FROM sessions");

// Search functionality for users and therapists
if (isset($_GET['search_query'])) {
    $search_query = mysqli_real_escape_string($conn, $_GET['search_query']);
    $users_result = fetchData("SELECT * FROM users WHERE name LIKE '%$search_query%' LIMIT 10");
    $therapists_result = fetchData("SELECT * FROM therapists WHERE name LIKE '%$search_query%' LIMIT 10");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Master Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url(https://www.emro.who.int/images/stories/mnh/world-mental-health-day-2021.png);
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: white;
        }

        .dashboard-container {
            background-color: rgba(0, 0, 0, 0.6);
            padding: 30px;
            border-radius: 15px;
            margin-top: 40px;
            box-shadow: 0 0 20px rgba(39, 38, 38, 0.2);
            backdrop-filter: blur(10px);
        }

        h2, h4, h5 {
            color: rgb(255, 255, 255);
        }

        .card {
            background-color: rgba(177, 229, 250, 0.9);
            color: #000;
            border-radius: 15px;
            margin-bottom: 30px;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .btn {
            border-radius: 20px;
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .form-control {
            border-radius: 25px;
            padding: 15px;
        }

        .search-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .toast {
            position: fixed;
            bottom: 10px;
            right: 10px;
            z-index: 9999;
        }

        .search-btn {
            background-color: #1c1b1b;
            color: #fff;
            border-radius: 25px;
        }

        .search-btn:hover {
            background-color: #ff5722;
        }
        
        /* AI-inspired hover effects */
        .user-card, .therapist-card {
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 15px;
            margin-bottom: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .user-card:hover, .therapist-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body>
    <div class="container dashboard-container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <h2 class="text-center mb-4">Master Dashboard</h2>

                <!-- Welcome -->
                <div class="card p-4 shadow">
                    <h4>Welcome to the Master Dashboard!</h4>
                    <p>You can manage users, therapists, sessions, and feedback here.</p>
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                </div>

                <!-- Users Section -->
                <div class="card p-4 shadow">
                    <h5>Manage Users</h5>
                    <a href="add_user.php" class="btn btn-success mb-3">Add New User</a>
                    <div class="search-bar">
                        <form method="get" action="" class="d-flex w-100">
                            <input type="text" name="search_query" class="form-control" placeholder="Search Users" value="<?= $_GET['search_query'] ?? '' ?>" />
                            <button type="submit" class="btn search-btn ms-2">Search</button>
                        </form>
                    </div>
                    <div class="row">
                        <?php while ($user = mysqli_fetch_assoc($users_result)): ?>
                            <div class="col-md-4 user-card">
                                <h6><?= $user['name'] ?? 'N/A' ?></h6>
                                <p>User ID: <?= $user['id'] ?></p>
                                <a href="delete_user.php?id=<?= $user['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>

                <!-- Therapists Section -->
                <div class="card p-4 shadow">
                    <h5>Manage Therapists</h5>
                    <a href="add_therapist.php" class="btn btn-success mb-3">Add New Therapist</a>
                    <div class="search-bar">
                        <form method="get" action="" class="d-flex w-100">
                            <input type="text" name="search_query" class="form-control" placeholder="Search Therapists" value="<?= $_GET['search_query'] ?? '' ?>" />
                            <button type="submit" class="btn search-btn ms-2">Search</button>
                        </form>
                    </div>
                    <div class="row">
                        <?php while ($therapist = mysqli_fetch_assoc($therapists_result)): ?>
                            <div class="col-md-4 therapist-card">
                                <h6><?= $therapist['name'] ?></h6>
                                <p>Email: <?= $therapist['email'] ?></p>
                                <a href="delete_therapist.php?id=<?= $therapist['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>

                <!-- Feedback Section -->
                <div class="card p-4 shadow">
                    <h5>Feedback</h5>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Session ID</th>
                                <th>User ID</th>
                                <th>Therapist ID</th>
                                <th>Rating</th>
                                <th>Comment</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($feedback = mysqli_fetch_assoc($feedback_result)): ?>
                            <tr>
                                <td><?= $feedback['id'] ?></td>
                                <td><?= $feedback['session_id'] ?></td>
                                <td><?= $feedback['user_id'] ?></td>
                                <td><?= $feedback['therapist_id'] ?></td>
                                <td><?= $feedback['rating'] ?></td>
                                <td><?= $feedback['comment'] ?></td>
                                <td><?= $feedback['created_at'] ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Sessions Section -->
                <div class="card p-4 shadow">
                    <h5>Session Management</h5>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Session ID</th>
                                <th>Therapist</th>
                                <th>User</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Feedback</th>
                                <th>Created</th>
                                <th>Video</th>
                                <th>Platform</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($session = mysqli_fetch_assoc($sessions_result)): ?>
                            <tr>
                                <td><?= $session['id'] ?></td>
                                <td><?= $session['therapist_id'] ?></td>
                                <td><?= $session['user_id'] ?></td>
                                <td><?= $session['session_type'] ?></td>
                                <td><?= $session['session_status'] ?></td>
                                <td><?= $session['payment_status'] ?></td>
                                <td><?= $session['feedback'] ?></td>
                                
                                <td><?= $session['video_link'] ?></td>
                                <td><?= $session['platform'] ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
