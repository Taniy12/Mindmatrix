<?php
// Start the session (if not already started)
if (session_status() === PHP_SESSION_NONE) {
    session_start();

    error_reporting(E_ALL);
ini_set('display_errors', 1);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MindMatrix - Mental Health Portal</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link href="assets/css/styles.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="home.php">MindMatrix</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
          </li>
          <?php if (isset($_SESSION['user_id'])): ?>
            <!-- Display these links if the user is logged in -->
            <li class="nav-item">
              <a class="nav-link" href="questions.php">Questionnaire</a>
            </li>
          <?php else: ?>
        </ul>
      </div>
    </div>
  </nav>
  </body>
  </html>

