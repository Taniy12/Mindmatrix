<?php
session_start();
include('db.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Get therapist and session details
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['therapist_id']) && isset($_POST['user_id'])) {
    $therapist_id = intval($_POST['therapist_id']);
    $user_id = intval($_POST['user_id']);
} else {
    die("❌ Error: Missing therapist or user details.");
}

// Dummy confirmation of payment (In a real app, this would be replaced by payment gateway integration)
$payment_status = 'confirmed'; // Simulating a successful payment

// Step 1: Check if there's an existing session for this user and therapist
$session_check_query = "SELECT * FROM sessions WHERE user_id = '$user_id' AND therapist_id = '$therapist_id' LIMIT 1";
$session_check_result = mysqli_query($conn, $session_check_query);
if (mysqli_num_rows($session_check_result) == 0) {
    die("❌ Error: No session found for this user and therapist.");
}

// Step 2: Update the session payment status if the session exists
$update_query = "UPDATE sessions SET payment_status = '$payment_status' WHERE user_id = '$user_id' AND therapist_id = '$therapist_id' AND session_status = 'pending'";
if (!mysqli_query($conn, $update_query)) {
    die("❌ Error confirming payment: " . mysqli_error($conn));
}

// Fetch the session ID if the session exists
$session = mysqli_fetch_assoc($session_check_result);
$session_id = $session['id'];

// Fetch therapist details
$therapist_query = "SELECT * FROM therapists WHERE id = $therapist_id";
$therapist_result = mysqli_query($conn, $therapist_query);
$therapist = mysqli_fetch_assoc($therapist_result);

if (!$therapist) {
    die("❌ Therapist not found!");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Confirmation</title>
    <style>
        body {
            /* Background image */
            background-image: url(https://media.istockphoto.com/id/1313442604/vector/mindfulness-watercolor-creative-abstract-background.jpg?s=612x612&w=0&k=20&c=wCOB7PyTMVXYfabK3TJXtP6cSK36S7Zu5CoZlBO2hJ0=);
            background-size: cover;
            background-position: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-attachment: fixed;
        }
        .container {
            margin-top: 80px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        .card {
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #28a745;
            font-size: 2em;
        }
        .payment-status {
            font-size: 1.3em;
            font-weight: bold;
            color: #ff6347;
            text-align: center;
        }
        .therapist-details {
            margin-top: 20px;
            text-align: center;
        }
        .therapist-details p {
            font-size: 1.1em;
        }
        .btn {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
            display: block;
            width: 100%;
            font-size: 1.1em;
            margin-top: 20px;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h2>🎉 Payment Successful!</h2>
            <p class="payment-status">Your payment has been confirmed. You can now proceed with your session.</p>
            
            <div class="therapist-details">
                <p><strong>Therapist:</strong> <?php echo htmlspecialchars($therapist['name']); ?></p>
                <p><strong>Specialization:</strong> <?php echo htmlspecialchars($therapist['specialization']); ?></p>
            </div>

            <!-- Button to join the session -->
            <a href="session_page.php?session_id=<?php echo $session_id; ?>" class="btn">✅ Start Your Session</a>
        </div>
    </div>
</body>
</html>
