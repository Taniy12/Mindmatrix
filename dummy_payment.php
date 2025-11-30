<?php
session_start();
include('db.php');

// ✅ Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// ✅ Validate therapist ID
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['therapist_id']) || !isset($_POST['payment_option'])) {
    die("❌ Invalid request. Please try again.");
}

$therapist_id = intval($_POST['therapist_id']);
$user_id = $_SESSION['user_id'];
$payment_option = $_POST['payment_option'];

// ✅ Simulate Payment Process
if ($payment_option == 'cod') {
    $payment_status = "not_paid"; // Payment after session
} else {
    $payment_status = "paid"; // Payment successful
}

// ✅ Redirect to payment confirmation
header("Location: payment_success.php?therapist_id=$therapist_id&status=$payment_status");
exit();
?>
