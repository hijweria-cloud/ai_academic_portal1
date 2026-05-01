<?php
session_start();
include('includes/header.php');

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$user_program = strtolower(trim($_SESSION['program'] ?? ''));
$user_semester = (int)($_SESSION['semester'] ?? 0);
$current_program = strtolower(trim($_GET['program'] ?? ''));

// Restrict access: only own program allowed
if ($user_program !== $current_program) {
    echo "<script>alert('Access denied! You cannot view another program.'); window.location.href='programs.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Select Semester</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      min-height: 100vh;
      background-color: #FAF3E0;
      font-family: 'Poppins', sans-serif;
    }
    .container-main {
      padding-top: 60px;
      padding-bottom: 60px;
      text-align: center;
    }
    h1 { color: #B8860B; font-weight: 700; }
    .card {
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 6px 15px rgba(0,0,0,0.1);
      transition: transform 0.3s, box-shadow 0.3s;
      text-align: center;
    }
    .card:hover { transform: translateY(-7px); }
    .btn-custom {
      background-color: #D4AF37;
      color: #fff;
      border-radius: 8px;
      border: none;
      padding: 10px 20px;
      transition: 0.3s;
    }
    .btn-custom:hover { background-color: #B9962F; }
    footer { background-color: #1C1C1C !important; color: #D4AF37 !important; }
  </style>
</head>
<body>

<div class="container-main">
  <h1 class="fw-bold mb-4">Select Your Semester</h1>
  <p class="text-muted mb-5">Choose your semester to view your subjects and results.</p>

  <div class="row justify-content-center g-4">
    <?php
    for ($i = 1; $i <= 8; $i++) {
        $allowed = ($i == $user_semester);
        echo '
        <div class="col-md-3 col-sm-6">
          <div class="card p-4 h-100">
            <h4 class="fw-bold mb-3" style="color:#B8860B;">Semester '.$i.'</h4>
            <p class="text-muted">Subjects and performance details.</p>';
        if ($allowed) {
            echo '<a href="subjects.php?semester='.$i.'&program='.$current_program.'" class="btn btn-custom w-100">View Subjects</a>';
        } else {
            echo '<button class="btn btn-secondary w-100" disabled>Access Denied</button>';
        }
        echo '</div></div>';
    }
    ?>
  </div>
</div>

<?php include('includes/footer.php'); ?>
</body>
</html>
