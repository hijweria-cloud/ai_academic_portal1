<?php
include('includes/db_connect.php');
include('send_verification.php');
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $program = trim($_POST['program']);
    $semester = trim($_POST['semester']);

    // Step 1: PASSWORD HASHING (Sir's Critical Requirement 1.1)
    // Plain password ko Bcrypt hash mein convert karna
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM students WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check_result = $check->get_result();

    if ($check_result->num_rows > 0) {
        $message = "⚠️ Email already registered. Please log in instead.";
    } else {

        // Generate email verification token
        $token = bin2hex(random_bytes(16));

       // Step 1: Query mein 7 columns aur 7 placeholders hain
$sql = "INSERT INTO students (name, email, password, program, semester, verify_token, is_verified) 
        VALUES (?, ?, ?, ?, ?, ?, 0)";
$stmt = $conn->prepare($sql);

// Step 2: Types string mein bhi 7 characters hone chahiye:
// s = name, s = email, s = password, s = program, i = semester, s = token
$stmt->bind_param("ssssis", $name, $email, $hashed_password, $program, $semester, $token);
        if ($stmt->execute()) {
            // Send email
            sendVerificationEmail($email, $token, $name);

            $message = "📩 Account created! Please check your Gmail to verify your account before logging in.";
        } else {
            $message = "❌ Something went wrong.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | AI Academic Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            background-color: #FAF3E0;
            display: flex;
            flex-direction: column;
        }

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

        .navbar-nav .nav-link {
            color: #F5EBDD !important;
            font-size: 14px !important;
            padding: 4px 10px !important;
        }

        .signup-container {
            max-width: 480px;
            margin: 80px auto;
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0px 4px 12px rgba(0,0,0,0.15);
            border-top: 5px solid #D4AF37;
            animation: fadeUp 0.8s ease forwards;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            text-align: center;
            color: #B8860B;
            margin-bottom: 25px;
            font-weight: 700;
        }

        .btn-custom {
            background-color: #D4AF37;
            color: #1C1C1C;
            width: 100%;
            border-radius: 8px;
            padding: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .message {
            text-align: center;
            color: #333;
            font-weight: 500;
            margin-bottom: 15px;
        }

        footer {
            background-color: #1C1C1C;
            color: #D4AF37;
            margin-top: auto;
            text-align: center;
            padding: 15px 0;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">AI Academic Portal</a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="index.php">Home</a>
            <a class="nav-link" href="login.php">Login</a>
            <a class="nav-link" href="signup.php">Sign Up</a>
        </div>
    </div>
</nav>

<div class="signup-container">
    <h2>Create Student Account</h2>

    <?php if ($message != ""): ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>Full Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Gmail</label>
            <input type="email" name="email" class="form-control" placeholder="example@gmail.com" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Program</label>
            <select name="program" class="form-control" required>
                <option value="">Select Program</option>
                <option value="BSCS">BS Computer Science</option>
                <option value="BSMaths">BS Mathematics</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Semester</label>
            <select name="semester" class="form-control" required>
                <option value="">Select Semester</option>
                <?php for ($i = 1; $i <= 8; $i++): ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
                <?php endfor; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-custom">Sign Up</button>
    </form>

    <div class="text-center mt-3">
        <small>Already have an account? <a href="login.php">Login here</a></small>
    </div>
</div>

<footer>
    © 2025 GC University Faisalabad | AI-Based Academic Portal
</footer>

</body>
</html>
