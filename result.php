<?php
session_start();
include('db.php'); // Include database connection

// ✅ Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// ✅ Fetch user ID
$user_id = $_SESSION['user_id'];

// ✅ Fetch response and calculate total score
$total_score = 0;

// ✅ Get responses for the user
$response_query = "SELECT * FROM response WHERE user_id = '$user_id'";
$response_result = mysqli_query($conn, $response_query);

// ✅ Check for query error
if (!$response_result) {
    die("Error fetching response: " . mysqli_error($conn));
}

// ✅ Calculate total score
while ($row = mysqli_fetch_assoc($response_result)) {
    $total_score += intval($row['answer_value']);
}

// ✅ Determine stress level based on score
if ($total_score <= 6) {
    $stress_level = "Mild Stress";
    $specialization = "General Therapist"; // Specialization for Mild Stress
} elseif ($total_score <= 10) {
    $stress_level = "Moderate Stress";
    $specialization = "Psychologist"; // Specialization for Moderate Stress
} else {
    $stress_level = "High Stress";
    $specialization = "Psychiatrist"; // Specialization for High Stress
}

// ✅ Query to fetch therapists based on specialization
$therapist_query = "SELECT * FROM therapists WHERE specialization = '$specialization' ORDER BY RAND() LIMIT 5"; // Fetch top 5 therapists based on specialization
$therapist_result = mysqli_query($conn, $therapist_query);

// ✅ Check if query is successful
if (!$therapist_result) {
    die("Error fetching therapist: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindMatrix - Results</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background-image: url(https://img.freepik.com/premium-photo/mental-health-awareness-wallpaper-visual-expression-wellbeing-aspects-resources_924727-33423.jpg); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .result-container {
            background: rgba(167, 237, 240, 0.9); 
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(12, 1, 1, 0.2);
            max-width: 600px;
            width: 100%;
            text-align: center;
        }
        h2 {
            color: #f18508;
            font-weight: bold;
            margin-bottom: 20px;
        }
        p {
            font-size: 1.1rem;
        }
        #level {
            color: #f34545; 
            font-weight: bold;
        }
        .btn-custom {
            background-color:rgb(8, 231, 60);
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }
        .btn-custom:hover {
            background-color: #218838;
        }
        .btn-secondary {
            background-color: #6c757d;
        }
        .therapist {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            padding: 15px;
            margin: 10px 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .therapist p {
            margin: 5px 0;
        }
    </style>
</head>
<body>

<div class="container result-container">
    <h2 class="text-center mb-4">Your Mental Health Level</h2>

    <p><strong>Stress Level:</strong> <span id="level"><?php echo $stress_level; ?></span></p>

    <hr>

    <h4>Recommended Therapists:</h4>
    <?php 
    // Display therapists based on stress level
    if (mysqli_num_rows($therapist_result) > 0) {
        while ($therapist = mysqli_fetch_assoc($therapist_result)) {
            echo '<div class="therapist">';
            echo '<p><strong>Name:</strong> ' . htmlspecialchars($therapist['name']) . '</p>';
            echo '<p><strong>Specialization:</strong> ' . htmlspecialchars($therapist['specialization']) . '</p>';
            echo '<p><strong>Contact No:</strong> ' . htmlspecialchars($therapist['contact']) . '</p>';
            echo '<p><strong>Email:</strong> ' . htmlspecialchars($therapist['email']) . '</p>';
            echo '<a href="detail_therapist.php?id=' . $therapist['id'] . '" class="btn btn-custom">View Therapist</a>';
            echo '</div>';
        }
    } else {
        echo '<p class="text-center text-danger">No therapists available for your stress level. Please try again later.</p>';
    }
    ?>

    <!-- Mood Score Submission Form -->
    <h4 class="mt-4">Rate Your Current Mood</h4>
    <form action="save_mood_score.php" method="POST">
        <label for="mood_score">How are you feeling today?</label>
        <select name="mood_score" id="mood_score" class="form-select" required>
            <option value="1">Very Bad</option>
            <option value="2">Bad</option>
            <option value="3">Neutral</option>
            <option value="4">Good</option>
            <option value="5">Very Good</option>
        </select>
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>"> <!-- Pass User ID -->
        <input type="hidden" name="date" value="<?php echo date('Y-m-d'); ?>"> <!-- Pass Current Date -->
        <button type="submit" class="btn btn-custom mt-3">Submit Mood</button>
    </form>

    <div class="text-center mt-3">
        <a href="home.php" class="btn btn-secondary">Go to Home</a>
    </div>
</div>

</body>
</html>
