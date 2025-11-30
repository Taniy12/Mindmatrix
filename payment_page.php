<?php
session_start();
include('db.php');

// ✅ Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("❌ User not logged in.");
}

$user_id = $_SESSION['user_id'];

// ✅ Check and retrieve therapist_id
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['therapist_id'])) {
    $therapist_id = intval($_POST['therapist_id']);
} elseif (isset($_GET['therapist_id'])) {
    $therapist_id = intval($_GET['therapist_id']);
} else {
    die("❌ Therapist ID is missing.");
}

// ✅ Check DB connection
if (!$conn) {
    die("❌ Database connection failed: " . mysqli_connect_error());
}

// ✅ Fetch therapist info
$query = "SELECT * FROM therapists WHERE id = $therapist_id";
$result = mysqli_query($conn, $query);
$therapist = mysqli_fetch_assoc($result);
if (!$therapist) {
    die("❌ Therapist not found.");
}

// ✅ Check if free session used
$check_free = "SELECT COUNT(*) AS free_count FROM sessions WHERE user_id = $user_id AND session_type = 'free'";
$free_result = mysqli_query($conn, $check_free);
$free_data = mysqli_fetch_assoc($free_result);
$session_type = ($free_data['free_count'] == 0) ? 'free' : 'paid';
$session_fee = ($session_type === 'free') ? 0 : 500;

// ✅ Insert into sessions table
$insert_query = "INSERT INTO sessions (user_id, therapist_id, session_type, session_status, payment_status) 
                 VALUES ($user_id, $therapist_id, '$session_type', 'pending', 'not_paid')";

// ✅ Check if the query is successful
if (!mysqli_query($conn, $insert_query)) {
    die("❌ Error inserting session: " . mysqli_error($conn));
}

// ✅ After successful insert, get session_id
$session_id = mysqli_insert_id($conn);
if (!$session_id) {
    die("❌ Failed to retrieve session ID.");
}

$google_meet_link = "https://meet.google.com/new";
$zoom_link = "https://us04web.zoom.us/join";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Session Confirmation</title>
    <style>
        body {
            background: linear-gradient(to right, #ffecd2 0%, #fcb69f 100%);
            font-family: Arial, sans-serif;
        }
        .container {
            margin: 50px auto;
            max-width: 600px;
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }
        .qr-code-box img {
            width: 200px;
            border-radius: 10px;
        }
        .btn {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>🎉 Session with <?php echo htmlspecialchars($therapist['name']); ?> Confirmed!</h2>
        <p><strong>Specialization:</strong> <?php echo htmlspecialchars($therapist['specialization']); ?></p>
        <p><strong>Session Type:</strong> <?php echo ucfirst($session_type); ?></p>
        <p><strong>Session Fee:</strong> ₹<?php echo $session_fee; ?></p>

        <?php if ($session_type === 'paid'): ?>
            <div class="qr-code-box">
                <h4>Scan QR to Pay ₹<?php echo $session_fee; ?></h4>
                <img src="images/qr_code.png" alt="QR Code">
                <form method="POST" action="confirm_payment.php">
                    <input type="hidden" name="session_id" value="<?php echo $session_id; ?>">
                    <input type="hidden" name="therapist_id" value="<?php echo $therapist_id; ?>">
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                    <br><br>
                    <button type="submit" class="btn">✅ Confirm Payment</button>
                </form>
            </div>
        <?php else: ?>
            <p class="text-success">✅ Join Your Free Session:</p>
            <a href="<?php echo $google_meet_link; ?>" target="_blank" class="btn">Join Google Meet</a>
            <a href="<?php echo $zoom_link; ?>" target="_blank" class="btn">Join Zoom</a>
        <?php endif; ?>
    </div>
</body>
</html>
