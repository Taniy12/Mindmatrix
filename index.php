<?php
// Start the session
// Test Github push
session_start();

// Redirect to home.php if user is logged in
if (isset($_SESSION['email'])) {
    header('location: home.php');
    exit();
}

// AI-driven Dynamic Greeting Based on Time of Day
$hour = date('H');
if ($hour >= 5 && $hour < 12) {
    $greeting = "Good Morning, welcome to MindMatrix! Ready to start your day stress-free?";
} elseif ($hour >= 12 && $hour < 18) {
    $greeting = "Good Afternoon! Find peace and calm with MindMatrix!";
} else {
    $greeting = "Good Evening! Relax and take control of your mental wellness.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to MindMatrix Portal</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">

  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Times New Roman', Times, serif;
      overflow-x: hidden;
    }

    .hero-section {
      background-image: url(https://www.tulasihealthcare.com/wp-content/uploads/2023/01/Imp-mental-health-1024x576.webp);
      background-size: cover;
      background-position: center;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
      position: relative;
      animation: fadeIn 1s ease-in-out;
    }

    .overlay {
      background: linear-gradient(45deg, rgba(189, 173, 173, 0.7), rgba(151, 139, 139, 0.4));
      width: 100%;
      height: 100%;
      position: absolute;
      top: 0;
      left: 0;
    }

    .content {
      position: relative;
      z-index: 2;
      color: white;
      text-shadow: 2px 2px 4px rgba(197, 178, 178, 0.7);
      animation: fadeIn 2s ease-out;
    }

    .section-heading {
      font-size: 4rem;
      font-weight: 700;
      margin-bottom: 20px;
      letter-spacing: 2px;
    }

    .btn-primary {
      font-size: 1.2rem;
      padding: 15px 40px;
      margin: 10px;
      border-radius: 50px;
      transition: transform 0.3s ease, background-color 0.3s ease;
      font-weight: 600;
    }

    .btn-primary:hover {
      transform: scale(1.1);
      background-color: #ff6600;
    }

    @keyframes fadeIn {
      0% {
        opacity: 0;
        transform: translateY(30px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @media (max-width: 768px) {
      .section-heading {
        font-size: 2.5rem;
      }
      .btn-primary {
        padding: 12px 30px;
      }
    }

    /* AI-Chatbot Floating Button */
    .chatbot-btn {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background-color: #ff6600;
      color: white;
      font-size: 18px;
      padding: 15px;
      border-radius: 50%;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .chatbot-btn:hover {
      background-color: #e55d00;
    }

    /* Chatbot UI */
    .chatbox {
      position: fixed;
      bottom: 70px;
      right: 20px;
      background-color: #fff;
      border-radius: 10px;
      width: 300px;
      height: 400px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      display: none;
      flex-direction: column;
      animation: slideIn 0.5s ease-in-out;
    }

    .chatbox-header {
      background-color: #ff6600;
      color: white;
      padding: 10px;
      text-align: center;
      border-radius: 10px 10px 0 0;
    }

    .chatbox-body {
      flex: 1;
      padding: 10px;
      overflow-y: auto;
      height: 100%;
      border-bottom: 1px solid #ddd;
    }

    .chatbox-footer {
      padding: 10px;
      display: flex;
    }

    .chatbox-footer input {
      flex: 1;
      padding: 10px;
      border-radius: 20px;
      border: 1px solid #ddd;
    }

    .chatbox-footer button {
      background-color: #ff6600;
      color: white;
      border: none;
      padding: 10px 15px;
      border-radius: 50%;
      margin-left: 10px;
      cursor: pointer;
    }

    @keyframes slideIn {
      from {
        transform: translateX(100%);
      }
      to {
        transform: translateX(0);
      }
    }

  </style>
</head>
<body>

  <!-- Hero Section (Welcome Page) -->
  <div class="hero-section">
    <div class="overlay"></div>
    <div class="content">
      <h1 class="section-heading">Welcome to MindMatrix!!!</h1>
      <p><?php echo $greeting; ?></p>
      <div>
        <a href="register_therapist.php" class="btn btn-primary">Therapist Sign Up</a>
        <a href="login_therapist.php" class="btn btn-primary">Therapist Login</a>
        <a href="master/master_login.php" class="btn btn-primary">Master Login</a>
        <a href="signup.php" class="btn btn-primary">User Sign Up</a>
        <a href="login.php" class="btn btn-primary">User Login</a>
      </div>
    </div>
  </div>

  <!-- AI Chatbot Button -->
  <div class="chatbot-btn" onclick="toggleChatbox()">💬</div>

  <!-- Chatbot UI -->
  <div class="chatbox" id="chatbox">
    <div class="chatbox-header">
      <h5>MindMatrix Bot</h5>
    </div>
    <div class="chatbox-body" id="chatbox-body">
      <!-- Chat messages will appear here -->
    </div>
    <div class="chatbox-footer">
      <input type="text" id="user-input" placeholder="Type a message..." />
      <button onclick="sendMessage()">Send</button>
    </div>
  </div>

  <script>
    // Toggle chatbox visibility
    function toggleChatbox() {
      var chatbox = document.getElementById('chatbox');
      chatbox.style.display = (chatbox.style.display === 'flex') ? 'none' : 'flex';
    }

    // Send message to chatbot
    function sendMessage() {
      var userInput = document.getElementById('user-input').value;
      if (userInput.trim() === '') return;

      // Display user message
      var chatboxBody = document.getElementById('chatbox-body');
      var userMessage = document.createElement('div');
      userMessage.classList.add('user-message');
      userMessage.textContent = "You: " + userInput;
      chatboxBody.appendChild(userMessage);

      // Display bot response (AI-like)
      var botMessage = document.createElement('div');
      botMessage.classList.add('bot-message');
      botMessage.textContent = "Bot: " + getBotResponse(userInput);
      chatboxBody.appendChild(botMessage);

      // Clear input field
      document.getElementById('user-input').value = '';

      // Scroll to the bottom of chatbox
      chatboxBody.scrollTop = chatboxBody.scrollHeight;
    }

    // Simple AI responses based on user input
    function getBotResponse(input) {
      var response = '';
      if (input.toLowerCase().includes('hello')) {
        response = "Hello! How can I assist you today?";
      } else if (input.toLowerCase().includes('therapist')) {
        response = "We have amazing therapists ready to help you. Would you like to register?";
      } else if (input.toLowerCase().includes('help')) {
        response = "You can ask me about therapist sign-ups or logins. How can I assist you further?";
      } else {
        response = "I'm still learning! Could you please rephrase your question?";
      }
      return response;
    }
  </script>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
