<?php
session_start();
include('db.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Validate session ID
if (!isset($_GET['session_id'])) {
    die("❌ Error: Session ID is missing.");
}

$session_id = intval($_GET['session_id']);

// Fetch session details
$session_query = "SELECT * FROM sessions WHERE id = $session_id AND user_id = $user_id";
$session_result = mysqli_query($conn, $session_query);

if (!$session_result) {
    die("❌ Error fetching session: " . mysqli_error($conn));
}

$session = mysqli_fetch_assoc($session_result);

if (!$session) {
    die("❌ Error: Session not found.");
}

// Auto-confirm free session if not paid
if ($session['session_type'] === 'free' && $session['payment_status'] !== 'paid') {
    $update_payment_query = "UPDATE sessions SET payment_status = 'paid' WHERE id = $session_id";
    if (mysqli_query($conn, $update_payment_query)) {
        $session['payment_status'] = 'paid';
    } else {
        die("❌ Error updating payment status: " . mysqli_error($conn));
    }
}

// Ensure session is paid
if ($session['payment_status'] !== 'paid') {
    die("❌ Error: Payment not confirmed.");
}

// Generate a unique Jitsi room link (optional: use dynamic session code here)
$video_link = 'https://meet.jit.si/session_' . $session_id;

// Update session with video link if not already updated
if (empty($session['video_link'])) {
    $update_video_query = "UPDATE sessions SET video_link = '$video_link' WHERE id = $session_id";
    if (!mysqli_query($conn, $update_video_query)) {
        die("❌ Error updating video link: " . mysqli_error($conn));
    }
    $session['video_link'] = $video_link;
}

// Validate therapist ID
$therapist_id = isset($session['therapist_id']) ? intval($session['therapist_id']) : 0;
if ($therapist_id <= 0) {
    die("❌ Invalid or missing therapist ID.");
}

// Fetch therapist info
$therapist_query = "SELECT * FROM therapists WHERE id = $therapist_id";
$therapist_result = mysqli_query($conn, $therapist_query);

if (!$therapist_result) {
    die("❌ Error fetching therapist details: " . mysqli_error($conn));
}

$therapist = mysqli_fetch_assoc($therapist_result);

if (!$therapist) {
    die("❌ Therapist not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Therapy Session</title>
    <style>
        body {
            background-image: url('https://img.freepik.com/free-vector/watercolor-abstract-floral-background_23-2150790562.jpg?semt=ais_hybrid&w=740');
            background-size: cover;
            background-attachment: fixed;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 650px;
            margin: 100px auto;
            background: rgba(229, 143, 193, 0.95);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        }
        h2 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 20px;
        }
        .info {
            text-align: center;
            font-size: 16px;
            margin-bottom: 10px;
        }
        .btn {
            text-align: center;
            margin-top: 20px;
        }
        .btn a {
            display: inline-block;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            padding: 12px 25px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s ease;
            margin: 10px;
        }
        .btn a:hover {
            background: linear-gradient(135deg, #5a0eb8, #1a5edc);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>🎥 Your Therapy Session is Ready!</h2>

        <div class="info">👤 Therapist: <strong><?php echo htmlspecialchars($therapist['name']); ?></strong></div>
        <div class="info">💼 Specialization: <?php echo htmlspecialchars($therapist['specialization']); ?></div>
        <div class="info">Email:<strong><?php echo htmlspecialchars($therapist['email']); ?></strong></div>
        <div class="info">Contact:<strong><?php echo htmlspecialchars($therapist['contact']); ?></strong></div>
      
        <div class="btn">
            <a href="<?php echo htmlspecialchars($session['video_link']); ?>" target="_blank">🚀 Join via Jitsi (Recommended)</a>
            <a href="https://meet.google.com/" target="_blank">🌐 Try Google Meet</a>
            <a href="https://zoom.us/" target="_blank">🌐 Try Zoom</a>
        </div>

        <div class="btn">
            <a href="feedback_form.php?session_id=<?php echo urlencode($session_id); ?>">📝 Submit Feedback</a>
        </div>
    </div>
</body>
</html>
