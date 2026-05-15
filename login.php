<?php
session_start();
include('includes/db_connect.php');

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Step 1: Prepared Statement for Security (Sir's Requirement 1.1)
    $sql = "SELECT * FROM students WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        $student = $result->fetch_assoc();

        // Step 2: Check Verification Status
        if ($student['is_verified'] == 0) {
            $error = "⚠️ You must verify your Gmail before logging in.";
        }

        // Step 3: Hashed Password Verification (Critical Fix) 
        // password_verify() use karna hai plaintext compare ki jagah
        else if (!password_verify($password, $student['password'])) {
            $error = "❌ Incorrect password!";
        }

        // Step 4: Login Success
        else {
            $_SESSION['student_id'] = $student['id'];
            $_SESSION['student_name'] = $student['name'];
            $_SESSION['program'] = $student['program'];
            $_SESSION['semester'] = $student['semester'];

            header("Location: dashboard.php");
            exit();
        }

    } else {
        $error = "❌ No account found with this email.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Login | AI Academic Portal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
      background: linear-gradient(135deg, #F5EBDD, #F3E2C7);
      display: flex;
      flex-direction: column;
    }

    .navbar {
      background: #1C1C1C;
      padding: 0.8rem 1.2rem;
    }

    .navbar-brand {
      font-weight: 700;
      color: #D4AF37 !important;
    }

    .navbar a {
      color: #F5EBDD !important;
      font-weight: 500;
      margin-left: 20px;
    }

    .login-container {
      max-width: 420px;
      margin: auto;
      background: #fff;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
      border-top: 5px solid #D4AF37;
      animation: slideUp 0.8s ease forwards;
      opacity: 0;
    }

    @keyframes slideUp {
      to { opacity: 1; transform: translateY(0); }
      from { opacity: 0; transform: translateY(25px); }
    }

    h2 {
      text-align: center;
      font-weight: 700;
      margin-bottom: 25px;
    }

    .btn-custom {
      background-color: #D4AF37;
      color: #1C1C1C;
      width: 100%;
      border-radius: 8px;
      padding: 10px;
      font-weight: 600;
      transition: 0.3s;
    }

    .btn-custom:hover {
      background-color: #B9962F;
      color: #fff;
      transform: scale(1.05);
    }

    .error-msg {
      color: #B8860B;
      text-align: center;
      font-weight: 600;
      margin-bottom: 15px;
    }

    footer {
      background: #1C1C1C;
      color: #D4AF37;
      padding: 15px;
      margin-top: auto;
      text-align: center;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="index.php">AI Academic Portal</a>
      <div>
        <a href="index.php">Home</a>
        <a href="signup.php">Sign Up</a>
      </div>
    </div>
</nav>

<div class="login-container">
    <h2>Student Login</h2>

    <?php if ($error != ""): ?>
        <div class="error-msg"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" placeholder="Enter your Gmail" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-custom">Login</button>

        <div class="text-center mt-3">
            <small>© 2025 GC University Faisalabad | AI-Based Academic Portal</small>
        </div>
    </form>
</div>

<footer>&copy; 2025 GC University Faisalabad | AI-Based Academic Portal</footer>

</body>
</html>
