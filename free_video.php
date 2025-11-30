<?php
session_start();
include('db.php');

// ✅ Redirect if user is not logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['selected_therapist'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$therapist_id = $_SESSION['selected_therapist'];

// ✅ Check if free session already marked
$check = mysqli_query($conn, "SELECT * FROM sessions WHERE user_id = $user_id AND therapist_id = $therapist_id AND session_type = 'free'");
if (mysqli_num_rows($check) == 0) {
    // ✅ Mark free session as completed
    $insert = "INSERT INTO sessions (user_id, therapist_id, session_type, session_status, session_date)
               VALUES ($user_id, $therapist_id, 'free', 'completed', NOW())";
    mysqli_query($conn, $insert);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Free Video Session - Mindmatrix</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
      background: linear-gradient(-45deg, #ff9a9e, #fad0c4, #a18cd1, #fbc2eb);
      background-size: 400% 400%;
      animation: gradientBG 15s ease infinite;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    @keyframes gradientBG {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .video-box {
      background: rgba(255, 255, 255, 0.9);
      padding: 30px;
      border-radius: 20px;
      box-shadow: 0 12px 35px rgba(0, 0, 0, 0.2);
      max-width: 960px;
      width: 95%;
      text-align: center;
    }

    h2 {
      font-weight: bold;
      color: #2c3e50;
      margin-bottom: 25px;
    }

    iframe {
      width: 100%;
      height: 500px;
      border: none;
      border-radius: 15px;
    }

    .btn-group {
      margin-top: 25px;
    }

    .btn {
      padding: 12px 25px;
      font-size: 1rem;
      border-radius: 10px;
    }

    .btn-warning {
      background-color: #f39c12;
      color: white;
      border: none;
    }

    .btn-danger {
      background-color: #e74c3c;
      color: white;
      border: none;
    }

    @media (max-width: 768px) {
      iframe {
        height: 250px;
      }
    }
  </style>
</head>

<body>

  <div class="video-box">
    <h2>🎥 Free Session: Introduction to Mental Health</h2>

    <!-- ✅ Embedded YouTube Video -->
    <iframe 
      src="https://www.youtube.com/embed/DxIDKZHW3-E" 
      title="Understanding Mental Health" 
      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
      allowfullscreen>
    </iframe>

    <div class="btn-group mt-4">
      <button onclick="history.back()" class="btn btn-warning me-2">🔙 Back</button>
      <a href="logout.php" class="btn btn-danger">🚪 Logout</a>
    </div>
  </div>

</body>
</html>
