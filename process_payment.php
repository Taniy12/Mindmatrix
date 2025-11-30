<?php
session_start();
include('db.php');

// ✅ Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ✅ Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// ✅ Check if therapist ID is provided via POST
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['therapist_id'])) {
    $therapist_id = intval($_POST['therapist_id']);
    $user_id = $_SESSION['user_id'];

    // ✅ Check if payment status is set in POST data (for testing purpose)
    $payment_status = isset($_POST['payment_status']) ? $_POST['payment_status'] : 'failed';

    if ($payment_status === 'success') {
        // ✅ Fetch therapist details
        $therapist_query = "SELECT * FROM therapists WHERE id = $therapist_id";
        $therapist_result = mysqli_query($conn, $therapist_query);
        $therapist = mysqli_fetch_assoc($therapist_result);

        // ✅ Fetch user details
        $user_query = "SELECT * FROM users WHERE id = $user_id";
        $user_result = mysqli_query($conn, $user_query);
        $user = mysqli_fetch_assoc($user_result);

        // ✅ Define session type (Check if it's the first session)
        $session_check_query = "SELECT COUNT(*) AS total_sessions FROM sessions WHERE user_id = $user_id AND therapist_id = $therapist_id";
        $session_check_result = mysqli_query($conn, $session_check_query);
        $session_count = mysqli_fetch_assoc($session_check_result)['total_sessions'];

        $session_type = ($session_count == 0) ? 'free' : 'paid';

        // ✅ Insert into `sessions` table
        $insert_query = "INSERT INTO sessions (user_id, therapist_id, session_type, session_status, payment_status) 
                         VALUES ('$user_id', '$therapist_id', '$session_type', 'pending', 'paid')";

        if (mysqli_query($conn, $insert_query)) {
            // ✅ Send Email Notification to Therapist
            $therapist_email = $therapist['email'];
            $subject = "New Appointment Confirmed with " . $user['name'];
            $google_meet_link = "https://meet.google.com/new"; // Google Meet link
            $session_fee = ($session_type === 'free') ? 'FREE' : '₹500'; // Fee based on session

            $message = "
Dear Dr. {$therapist['name']},

You have a new appointment scheduled with {$user['name']}.

✅ Appointment Details:
- Session Type: " . ucfirst($session_type) . " Session
- Session Fee: $session_fee
- Date & Time: " . date('Y-m-d H:i:s') . "
- Join Link: $google_meet_link

Please ensure you are available at the specified time.

Best Regards,
MindMatrix Team
";

            // ✅ Email Headers
            $headers = "From: admin@mindmatrix.com\r\n";
            $headers .= "Reply-To: admin@mindmatrix.com\r\n";
            $headers .= "Content-Type: text/plain\r\n";

            // ✅ Send Email
            mail($therapist_email, $subject, $message, $headers);

            // ✅ Redirect to payment success page
            header('Location: payment_success.php?status=success');
            exit();
        } else {
            die("❌ Error inserting session: " . mysqli_error($conn));
        }
    } else {
        // ❌ Payment failed - Redirect to fail page
        header('Location: payment_success.php?status=failed');
        exit();
    }
} else {
    die("❌ Invalid request. Please try again.");
}
?>
