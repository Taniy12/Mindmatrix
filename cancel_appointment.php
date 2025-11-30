<?php
session_start();
include('db.php');

// Check if the therapist is logged in
if (!isset($_SESSION['therapist_id'])) {
    die("Therapist not logged in.");
}

$appointment_id = $_GET['id'];
$therapist_id = $_SESSION['therapist_id'];

// Cancel the appointment
$query = "UPDATE appointments SET status = 'Cancelled' WHERE id = $appointment_id AND therapist_id = $therapist_id";
$result = mysqli_query($conn, $query);

if ($result) {
    header("Location: therapist_dashboard.php");
    exit();
} else {
    echo "Error cancelling appointment: " . mysqli_error($conn);
}
?>
