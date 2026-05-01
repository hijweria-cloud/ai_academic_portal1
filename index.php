<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>AI Academic Portal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      background: linear-gradient(135deg, #F5EBDD, #F3E2C7);
      color: #1C1C1C;
      min-height: 100vh;
    }

    /* Navbar */
    .navbar {
      background: #1C1C1C;
      box-shadow: 0 2px 10px rgba(0,0,0,0.3);
      padding: 0.8rem 1.2rem;
    }
    .navbar-brand {
      font-weight: 700;
      color: #D4AF37 !important;
      letter-spacing: 1px;
    }
    .navbar-nav .nav-link {
      color: #F5EBDD !important;
      margin: 0 18px;
      transition: 0.3s;
      font-weight: 500;
    }
    .navbar-nav .nav-link:hover {
      color: #D4AF37 !important;
      text-shadow: 0 0 6px rgba(212,175,55,0.5);
    }

    /* Hero Section */
    .hero {
      height: 85vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      animation: fadeIn 1s ease-out;
    }
    .hero h1 {
      font-size: 3rem;
      color: #1C1C1C;
      text-shadow: 0 0 10px rgba(212,175,55,0.2);
      margin-bottom: 15px;
    }
    .hero p {
      color: #4A403A;
      font-weight: 500;
      margin-bottom: 30px;
    }

    /* Buttons */
    .btn-custom {
      background-color: #D4AF37;
      color: #1C1C1C;
      border-radius: 8px;
      padding: 12px 28px;
      margin: 10px;
      font-weight: 600;
      border: none;
      transition: all 0.3s ease;
      box-shadow: 0 0 10px rgba(212,175,55,0.4);
    }
    .btn-custom:hover {
      background-color: #B9962F;
      color: #F5EBDD;
      transform: scale(1.05);
      box-shadow: 0 0 14px rgba(185,150,47,0.4);
    }

    /* Footer */
    footer {
      background: #1C1C1C;
      text-align: center;
      padding: 15px;
      color: #D4AF37;
      font-size: 0.9rem;
      box-shadow: 0 -2px 8px rgba(0,0,0,0.2);
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(15px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="#">AI Academic Portal</a>
      <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li><a class="nav-link" href="index.php">Home</a></li>
          <li><a class="nav-link" href="login.php">Student Login</a></li>
          <li><a class="nav-link" href="signup.php">Sign Up</a></li>
          <li><a class="nav-link" href="admin_login.php">Admin Login</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <div class="hero">
    <h1>Welcome to AI Academic Portal</h1>
    <p>Your smart, AI-powered academic companion.</p>
    <div>
      <a href="login.php" class="btn btn-custom">Student Login</a>
      <a href="signup.php" class="btn btn-custom">Sign Up</a>
      <a href="admin_login.php" class="btn btn-custom">Admin Login</a>
    </div>
  </div>

  <!-- Footer -->
  <footer>&copy; 2025 Aspire College | AI-Based Academic Portal</footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
