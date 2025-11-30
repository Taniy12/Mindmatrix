<?php
require "includes/common.php";

// Redirect to home.php if already logged in
if (isset($_SESSION['email'])) {
    header('location: home.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>MindMatrix Portal - Home</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />

  <style>
    body {
      font-family: 'Times New Roman', Times, serif;
      background-color: #a1c0f7;
      margin: 0;
      padding: 0;
    }

    .hero-section {
      background-image: url('https://img.freepik.com/free-vector/psychologist-concept-illustration_114360-2040.jpg');
      background-size: cover;
      background-position: center;
      color: #f06060;
      padding: 100px 0;
      text-align: center;
    }

    .hero-section h1 {
      font-size: 3.5rem;
      font-weight: 700;
    }

    .hero-section p {
      font-size: 1.5rem;
      font-weight: 500;
    }

    .hero-section .btn {
      padding: 15px 30px;
      font-size: 1.2rem;
      border-radius: 30px;
      margin-top: 30px;
      background-color: #ec7728;
      border: none;
      transition: background-color 0.3s ease;
    }

    .hero-section .btn:hover {
      background-color: #e55b00;
    }

    .features-section {
      background-color: #bde0e7;
      padding: 80px 0;
    }

    .features-section h2 {
      font-size: 2.5rem;
      font-weight: 700;
      color: #080808;
    }

    .feature-card {
      background-color: #f37777;
      border: none;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(235, 197, 197, 0.1);
      text-align: center;
      padding: 40px 20px;
      transition: transform 0.3s ease;
      cursor: pointer;
    }

    .feature-card:hover {
      transform: translateY(-10px);
    }

    .feature-card h5 {
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 15px;
      color: #333;
    }

    .feature-card p {
      color: #fff;
    }

    .footer {
      background-color: #333;
      color: #fff;
      padding: 40px 0;
      text-align: center;
    }

    .policy-section {
      background-color: #f5f5f5;
      padding: 40px 20px;
    }

    .policy-section h3 {
      font-size: 1.8rem;
      font-weight: bold;
      color: #333;
      margin-bottom: 20px;
    }

    .policy-section p {
      font-size: 1rem;
      color: #444;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>

  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="#">MindMatrix</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <div class="hero-section">
    <div class="container">
      <h1>Welcome to MindMatrix</h1>
      <p>Your gateway to innovation, collaboration, and success through stress-free living.</p>
      <a href="signup.php" class="btn">Get Started</a>
    </div>
  </div>

  <!-- Features Section -->
  <div class="features-section">
    <div class="container">
      <h2 class="text-center mb-5">Our Key Features</h2>
      <div class="row">

        <!-- Innovation -->
        <div class="col-md-4 mb-4">
          <div class="feature-card" onclick="toggleFeature('innovationContent')">
            <h5>Innovation</h5>
            <p>Click to explore how AI can personalize your wellness journey.</p>
          </div>
          <div id="innovationContent" class="p-3 bg-light rounded d-none">
            <p><strong>AI Mood Tips:</strong></p>
            <ul>
              <li>🧘 Deep Breathing Alerts</li>
              <li>🎨 Art/Music Therapy Suggestions</li>
              <li>📱 Mindfulness Break Reminders</li>
            </ul>
          </div>
        </div>

        <!-- Collaboration -->
        <div class="col-md-4 mb-4">
          <div class="feature-card" onclick="toggleFeature('collaborationContent')">
            <h5>Collaboration</h5>
            <p>Tap to find your ideal therapist partner in your journey.</p>
          </div>
          <div id="collaborationContent" class="p-3 bg-light rounded d-none">
            <p><strong>Recommended Therapists:</strong></p>
            <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item active text-center">
                  <h6>Dr. Meera Sharma</h6>
                  <p>Anxiety & Emotional Healing</p>
                </div>
                <div class="carousel-item text-center">
                  <h6>Dr. Rohan Jain</h6>
                  <p>Youth Stress Management</p>
                </div>
                <div class="carousel-item text-center">
                  <h6>Dr. Ayesha Khan</h6>
                  <p>Cognitive Behavioral Therapy</p>
                </div>
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
              </button>
            </div>
          </div>
        </div>

        <!-- Analytics -->
        <div class="col-md-4 mb-4">
          <div class="feature-card" onclick="toggleFeature('analyticsContent')">
            <h5>Analytics</h5>
            <p>Tap to see how we track your emotional progress.</p>
          </div>
          <div id="analyticsContent" class="p-3 bg-light rounded d-none">
            <p><strong>Mood Trend Sample:</strong></p>
            <canvas id="moodChart" width="300" height="200"></canvas>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Footer -->
  <div class="footer">
    <div class="container">
      <p>&copy; 2025 MindMatrix. All rights reserved.</p>
    </div>
  </div>

  <!-- Privacy Policy & Terms -->
  <div class="policy-section">
    <div class="container">
      <h3>Privacy Policy</h3>
      <p>At MindMatrix, your privacy is our top priority. We do not share your data with third parties without consent. Your personal and session data is encrypted and stored securely.</p>
      <p>Only authorized professionals can access your session history and mood scores for therapeutic use. You have full control over your data visibility and can request removal at any time.</p>

      <h3>Terms of Service</h3>
      <p>By signing up with MindMatrix, you agree to participate in sessions ethically and respectfully. The platform is not a replacement for emergency psychiatric help. In case of crisis, seek immediate assistance through a certified helpline or hospital.</p>
      <p>All payments are secure and sessions are non-transferable. You agree not to misuse the platform or impersonate anyone during therapist interactions.</p>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    function toggleFeature(id) {
      document.getElementById(id).classList.toggle("d-none");
    }

    const ctx = document.getElementById('moodChart');
    if (ctx) {
      new Chart(ctx, {
        type: 'line',
        data: {
          labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
          datasets: [{
            label: 'Mood Score',
            data: [3, 4, 2, 5, 4, 3, 5],
            borderColor: '#ff6384',
            fill: false,
            tension: 0.4
          }]
        },
        options: {
          responsive: true,
          scales: {
            y: { beginAtZero: true, max: 5 }
          }
        }
      });
    }
  </script>

</body>
</html>
