<?php
include('db.php');
session_start();

// ✅ Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// ✅ Get therapist ID from URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Therapist not found!");
}

$therapist_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// ✅ Fetch therapist details
$query = "SELECT * FROM therapists WHERE id = $therapist_id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Therapist not found!");
}

$therapist = mysqli_fetch_assoc($result);

// ✅ Check if free session is already used
$check_free_query = "SELECT * FROM sessions 
                     WHERE user_id = '$user_id' 
                     AND therapist_id = '$therapist_id' 
                     AND session_type = 'free' 
                     AND session_status = 'completed'";

$check_free_result = mysqli_query($conn, $check_free_query);
$free_session_used = mysqli_num_rows($check_free_result) > 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Therapist Details - Mindmatrix</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        :root {
            --card-bg-color:rgb(210, 186, 233); /* 🎨 Change this to your preferred card color */
        }

        body {
            margin: 0;
            padding: 0;
            background: url(https://www.ucsf.edu/sites/default/files/styles/article_feature_banner__image/public/2021-06/iStock_illustration_heads.jpg) no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .overlay {
            background-color: rgba(8, 8, 8, 0.5);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
        }

        .card {
            width: 100%;
            max-width: 700px;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            border: none;
            padding: 30px;
            background-color: var(--card-bg-color);
            transition: background-color 0.3s ease;
        }

        .card h2 {
            font-weight: bold;
            color: #2c3e50;
        }

        .card p {
            margin: 10px 0;
            font-size: 1.1rem;
            color: #333;
        }

        .btn {
            width: 100%;
            margin-top: 10px;
            padding: 12px;
            font-size: 1rem;
            border-radius: 8px;
        }

        .btn-primary {
            background-color: #3498db;
            border: none;
        }

        .btn-success {
            background-color: #2ecc71;
            border: none;
        }

        .btn-secondary {
            background-color: #7f8c8d;
            border: none;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .contact-message {
            font-size: 1.1rem;
            color: #e74c3c;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="overlay">
        <div class="card text-center">
            <h2><?php echo htmlspecialchars($therapist['name']); ?></h2>
            <p><strong>Specialization:</strong> <?php echo htmlspecialchars($therapist['specialization']); ?></p>
           
            <!-- ✅ Free Session Button -->
            <form action="free_session.php" method="POST">
                <input type="hidden" name="therapist_id" value="<?php echo $therapist_id; ?>">
                <button type="submit" class="btn btn-primary"
                    <?php echo $free_session_used ? 'disabled' : ''; ?> >
                    📹 First Session - Free
                </button>
            </form>

            <!-- ✅ Paid Session Button -->
            <form action="payment_page.php" method="POST">
                <input type="hidden" name="therapist_id" value="<?php echo $therapist_id; ?>">
                <button type="submit" class="btn btn-success">
                    💳 Book Paid Session
                </button>
            </form>

            <!-- ✅ Change Therapist Button -->
            <a href="result.php" class="btn btn-secondary">
                🔄 Change Therapist
            </a>
        </div>
    </div>
</body>
</html>
