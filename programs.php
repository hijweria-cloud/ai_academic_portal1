<?php
session_start();
include('includes/header.php');

// === Make sure user is logged in ===
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

// Get student details from session
$user_program = strtolower(trim($_SESSION['program'] ?? ''));
$user_semester = (int)($_SESSION['semester'] ?? 0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Choose Your Program</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
      min-height: 100vh;
      font-family: 'Poppins', sans-serif;
      background-color: #FAF3E0;
    }

    .navbar {
      background-color: #1C1C1C !important;
      height: 50px !important;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }

    .navbar-brand {
      color: #D4AF37 !important;
      font-weight: 600;
      font-size: 18px !important;
    }

    .container { padding: 60px 0; }
    h1 { color: #B8860B; font-weight: 700; }
    .text-muted { color: #333 !important; }

    .card {
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s, box-shadow 0.3s;
      text-align: center;
    }

    .card:hover { transform: translateY(-5px); }

    .btn-custom {
      background-color: #D4AF37;
      color: #fff;
      border-radius: 8px;
      border: none;
      padding: 10px 20px;
      transition: 0.3s;
    }

    .btn-custom:hover { background-color: #B9962F; }

    footer { background-color: #1C1C1C !important; color: #F5EBDD !important; }
  </style>
</head>

<body>
  <div class="container text-center">
    <h1 class="fw-bold mb-3">Choose Your Program</h1>
    <p class="text-muted mb-5">Select your degree program to view semester details.</p>

    <div class="row justify-content-center g-4">

      <?php
      // Programs available
      $programs = [
        'bscs' => ['name' => 'BS Computer Science', 'img' => 'cs.png'],
        'bsmaths' => ['name' => 'BS Mathematics', 'img' => 'maths.png']
      ];

      foreach ($programs as $key => $data) {
          $allowed = ($user_program === $key);

          echo '<div class="col-md-4 col-sm-6">
                  <div class="card p-4 h-100">
                    <img src="assets/images/'.$data['img'].'" alt="'.$data['name'].'" class="mb-3" style="width:80px; margin:auto;">
                    <h4 class="fw-bold mb-2" style="color:#B8860B;">'.$data['name'].'</h4>
                    <p class="text-muted">Semester-wise subjects and performance reports.</p>';

          if ($allowed) {
              echo '<a href="semesters.php?program='.$key.'" class="btn btn-custom mt-3 w-100">View Semesters</a>';
          } else {
              echo '<button class="btn btn-secondary mt-3 w-100" disabled>Access Denied</button>';
          }

          echo '</div></div>';
      }
      ?>

    </div>
  </div>

  <?php include('includes/footer.php'); ?>
  <?php include('includes/chatbot.php'); ?>
</body>
</html>
