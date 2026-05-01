<?php
session_start();
include("includes/db_connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $query = "SELECT * FROM admins WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['admin_email'] = $username;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Invalid Username or Password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login | AI Academic Portal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    /* === Global Layout === */
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      min-height: 100vh;
      background-color: #FAF3E0; /* Soft beige */
      display: flex;
      flex-direction: column;
    }

    /* Navbar - same as index.php */
    .navbar {
      background-color: #1C1C1C !important;
      padding-top: 4px !important;
      padding-bottom: 4px !important;
      height: 50px !important;
      display: flex;
      align-items: center;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }

    .navbar-brand {
      color: #D4AF37 !important;
      font-size: 18px !important;
      font-weight: 600;
    }

    .navbar-brand:hover {
      color: #B9962F !important;
    }

    .navbar-nav .nav-link {
      color: #F5EBDD !important;
      font-size: 14px !important;
      padding: 4px 10px !important;
    }

    .navbar-nav .nav-link:hover {
      color: #D4AF37 !important;
    }

    /* === Login Box === */
    .login-container {
      max-width: 420px;
      margin: 120px auto;
      background: #fff;
      border-radius: 15px;
      box-shadow: 0px 4px 12px rgba(0,0,0,0.15);
      padding: 40px;
      text-align: center;
      border-top: 5px solid #D4AF37;
      opacity: 0;
      transform: translateY(40px);
      animation: fadeUp 0.8s ease forwards;
    }

    @keyframes fadeUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    h3 {
      color: #B8860B;
      font-weight: 700;
      margin-bottom: 30px;
    }

    .form-control {
      border-radius: 8px;
    }

    .btn-custom {
      background-color: #D4AF37;
      color: #1C1C1C;
      width: 100%;
      border-radius: 8px;
      border: none;
      padding: 10px;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .btn-custom:hover {
      background-color: #B9962F;
      color: #fff;
      transform: scale(1.03);
    }

    footer {
      background-color: #1C1C1C !important;
      color:  #D4AF37!important;
      margin-top: auto;
      text-align: center;
      padding: 15px 0;
      font-size: 0.9rem;
    }
  </style>
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">AI Academic Portal</a>
    <div class="navbar-nav ms-auto">
      <a class="nav-link" href="index.php">Home</a>
      <a class="nav-link" href="login.php">Student Login</a>
    </div>
  </div>
</nav>

<!-- Admin Login Form -->
<div class="login-container">
  <h3>Admin Login</h3>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger text-center"><?= $error ?></div>
  <?php endif; ?>
  
  <form method="POST">
    <div class="mb-3 text-start">
      <label class="form-label">Username</label>
      <input type="text" name="username" class="form-control" placeholder="Enter your username" required>
    </div>
    <div class="mb-3 text-start">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
    </div>
    <button type="submit" class="btn btn-custom">Login</button>
  </form>
</div>

<footer>
  &copy; 2025 Aspire College | AI-Based Academic Portal
</footer>

</body>
</html>
