<?php
// logout.php

// Include common.php for session handling and redirection
require "includes/common.php";

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page
redirect("login.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Logout - MindMatrix</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-image: url(https://media.bizj.us/view/img/11037140/gettyimages-491580488-converted*900x506x1999-1123-0-377.jpg);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .logout-container {
      text-align: center;
      background-color: #92b9d3;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    .logout-container h2 {
      margin-bottom: 20px;
      color: #333;
    }
    .logout-container p {
      margin-bottom: 30px;
      color: #666;
    }
    .logout-container .btn {
      padding: 10px 30px;
      font-size: 1.1rem;
      border-radius: 5px;
    }
  </style>
</head>
<body>
  <div class="logout-container">
    <h2>Are you sure you want to log out?</h2>
    <p>You will be redirected to the login page.</p>
    <a href="logout.php" class="btn btn-danger">Log Out</a>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



